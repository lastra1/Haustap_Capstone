<?php

namespace App\Http\Controllers\Auth;

use App\Support\FileJsonStore;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OtpController extends BaseController
{
    private function store(): FileJsonStore
    {
        $path = base_path('storage/data/otp.json');
        return new FileJsonStore($path, ['records' => []]);
    }

    public function send(Request $request)
    {
        $email = trim((string) $request->input('email'));
        if ($email === '') {
            return response()->json(['success' => false, 'message' => 'email required'], 422);
        }
        $code = (string) random_int(100000, 999999);
        $expires = round(microtime(true) * 1000) + (5 * 60 * 1000);
        $store = $this->store()->read();
        $recs = is_array($store['records'] ?? null) ? $store['records'] : [];
        $recs = array_values(array_filter($recs, function ($r) use ($email) {
            return (string) ($r['email'] ?? '') !== $email;
        }));
        $recs[] = ['email' => $email, 'code' => $code, 'expires' => $expires];
        $this->store()->write(['records' => $recs]);
        // Send OTP via email (dev env defaults to log mailer)
        try {
            Mail::raw(
                "Your HausTap verification code is {$code}. It expires in 5 minutes.",
                function ($message) use ($email) {
                    $message->to($email)->subject('Your HausTap OTP');
                }
            );
            Log::info('OTP sent', ['email' => $email]);
            // Keep dev_code in response for developer convenience in non-production environments
            return response()->json([
                'success' => true,
                'email_sent' => true,
                'dev_code' => app()->isProduction() ? null : $code,
                'expires' => $expires,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send OTP email', ['email' => $email, 'error' => $e->getMessage()]);
            return response()->json([
                'success' => true,
                'email_sent' => false,
                'dev_code' => app()->isProduction() ? null : $code,
                'expires' => $expires,
            ]);
    }
    }

    public function verify(Request $request)
    {
        $email = trim((string) $request->input('email'));
        $code = trim((string) $request->input('code'));
        if ($email === '' || $code === '') {
            return response()->json(['success' => false, 'message' => 'email and code required'], 422);
        }
        $now = round(microtime(true) * 1000);
        $store = $this->store()->read();
        $recs = is_array($store['records'] ?? null) ? $store['records'] : [];
        foreach ($recs as $r) {
            if ((string) ($r['email'] ?? '') === $email && (string) ($r['code'] ?? '') === $code) {
                if ((int) ($r['expires'] ?? 0) < $now) {
                    return response()->json(['success' => false, 'message' => 'code expired'], 400);
                }
                return response()->json(['success' => true, 'token' => 'dev-token-' . md5($email . $code)]);
            }
        }
        return response()->json(['success' => false, 'message' => 'invalid code'], 400);
    }
}