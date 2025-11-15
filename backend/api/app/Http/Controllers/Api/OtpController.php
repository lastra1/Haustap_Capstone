<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OtpCode;
use App\Services\Firebase\FirestoreClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class OtpController extends Controller
{
    protected $firestore;

    public function __construct()
    {
        $this->firestore = app(FirestoreClient::class);
    }

    /**
     * Send OTP code
     */
    public function sendOtp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required_without:email|string|max:20',
                'email' => 'required_without:phone|email|max:255',
                'type' => 'required|string|in:phone,email',
                'purpose' => 'required|string|in:registration,login,password_reset,verification',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $recipient = $request->type === 'phone' ? $request->phone : $request->email;
            $code = $this->generateOtpCode();
            $expiresAt = now()->addMinutes(10);

            // Create OTP in local database
            $otp = OtpCode::create([
                'recipient' => $recipient,
                'type' => $request->type,
                'code' => $code,
                'purpose' => $request->purpose,
                'expires_at' => $expiresAt,
                'used' => false,
            ]);

            // Create OTP in Firebase
            $firebaseOtp = [
                'id' => $otp->id,
                'recipient' => $recipient,
                'type' => $request->type,
                'code' => $code,
                'purpose' => $request->purpose,
                'expires_at' => $expiresAt->toIso8601String(),
                'used' => false,
                'created_at' => now()->toIso8601String(),
            ];

            $this->firestore->collection('otp_codes')->document($otp->id)->set($firebaseOtp);

            // Send OTP based on type
            if ($request->type === 'phone') {
                $this->sendSmsOtp($recipient, $code);
            } else {
                $this->sendEmailOtp($recipient, $code);
            }

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully',
                'data' => [
                    'otp_id' => $otp->id,
                    'expires_at' => $expiresAt->toIso8601String(),
                    'message' => 'OTP has been sent to your ' . $request->type
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify OTP code
     */
    public function verifyOtp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'otp_id' => 'required|integer|exists:otp_codes,id',
                'code' => 'required|string|max:6',
                'purpose' => 'required|string|in:registration,login,password_reset,verification',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $otp = OtpCode::find($request->otp_id);

            // Check if OTP exists and is valid
            if (!$otp || $otp->used || $otp->expires_at < now()) {
                return response()->json([
                    'success' => false,
                    'message' => 'OTP is invalid or expired'
                ], 400);
            }

            // Check if code matches
            if ($otp->code !== $request->code) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid OTP code'
                ], 400);
            }

            // Check if purpose matches
            if ($otp->purpose !== $request->purpose) {
                return response()->json([
                    'success' => false,
                    'message' => 'OTP purpose mismatch'
                ], 400);
            }

            // Mark OTP as used
            $otp->update(['used' => true]);

            // Update Firebase
            $this->firestore->collection('otp_codes')->document($otp->id)->update([
                ['path' => 'used', 'value' => true],
                ['path' => 'verified_at', 'value' => now()->toIso8601String()]
            ]);

            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully',
                'data' => [
                    'verified' => true,
                    'recipient' => $otp->recipient,
                    'purpose' => $otp->purpose
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'OTP verification failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Resend OTP code
     */
    public function resendOtp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'otp_id' => 'required|integer|exists:otp_codes,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $oldOtp = OtpCode::find($request->otp_id);

            // Mark old OTP as expired
            $oldOtp->update(['used' => true]);

            // Create new OTP
            $newCode = $this->generateOtpCode();
            $expiresAt = now()->addMinutes(10);

            $newOtp = OtpCode::create([
                'recipient' => $oldOtp->recipient,
                'type' => $oldOtp->type,
                'code' => $newCode,
                'purpose' => $oldOtp->purpose,
                'expires_at' => $expiresAt,
                'used' => false,
            ]);

            // Create new OTP in Firebase
            $firebaseOtp = [
                'id' => $newOtp->id,
                'recipient' => $oldOtp->recipient,
                'type' => $oldOtp->type,
                'code' => $newCode,
                'purpose' => $oldOtp->purpose,
                'expires_at' => $expiresAt->toIso8601String(),
                'used' => false,
                'created_at' => now()->toIso8601String(),
                'resend_of' => $oldOtp->id,
            ];

            $this->firestore->collection('otp_codes')->document($newOtp->id)->set($firebaseOtp);

            // Send new OTP
            if ($oldOtp->type === 'phone') {
                $this->sendSmsOtp($oldOtp->recipient, $newCode);
            } else {
                $this->sendEmailOtp($oldOtp->recipient, $newCode);
            }

            return response()->json([
                'success' => true,
                'message' => 'New OTP sent successfully',
                'data' => [
                    'otp_id' => $newOtp->id,
                    'expires_at' => $expiresAt->toIso8601String()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to resend OTP',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get OTP history for user
     */
    public function otpHistory(Request $request)
    {
        try {
            $user = Auth::user();
            $limit = $request->get('limit', 20);

            $otps = OtpCode::where('recipient', $user->email)
                ->orWhere('recipient', $user->phone)
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $otps
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get OTP history',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate 6-digit OTP code
     */
    private function generateOtpCode()
    {
        return str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Send SMS OTP (placeholder - integrate with SMS provider)
     */
    private function sendSmsOtp($phone, $code)
    {
        // Placeholder for SMS integration
        // You can integrate with Twilio, Vonage, or any SMS provider
        
        // Log the OTP for development
        \Log::info("SMS OTP sent to {$phone}: {$code}");
        
        // Store in cache for development/testing
        Cache::put("sms_otp_{$phone}", $code, 600); // 10 minutes
        
        return true;
    }

    /**
     * Send Email OTP (placeholder - integrate with email provider)
     */
    private function sendEmailOtp($email, $code)
    {
        // Placeholder for email integration
        // You can integrate with Mailgun, SendGrid, or any email provider
        
        // Log the OTP for development
        \Log::info("Email OTP sent to {$email}: {$code}");
        
        // Store in cache for development/testing
        Cache::put("email_otp_{$email}", $code, 600); // 10 minutes
        
        return true;
    }
}