<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Exception\AuthException;

class FirebaseApiController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    /**
     * Create a new user with Firebase authentication
     */
    public function createUser(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:6',
                'displayName' => 'nullable|string|max:255',
                'phoneNumber' => 'nullable|string|max:20',
                'role' => 'nullable|string|in:client,service_provider,admin'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $userData = [
                'displayName' => $request->displayName,
                'phoneNumber' => $request->phoneNumber,
                'role' => $request->role ?? 'client'
            ];

            $user = $this->firebaseService->createUser(
                $request->email,
                $request->password,
                $userData
            );

            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'data' => [
                    'uid' => $user->uid,
                    'email' => $user->email,
                    'displayName' => $user->displayName
                ]
            ], 201);

        } catch (AuthException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication error',
                'error' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user data from Firebase
     */
    public function getUserData(Request $request, $uid)
    {
        try {
            $userData = $this->firebaseService->getUserData($uid);

            if (!$userData) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $userData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get user data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update user profile
     */
    public function updateUserProfile(Request $request, $uid)
    {
        try {
            $validator = Validator::make($request->all(), [
                'displayName' => 'nullable|string|max:255',
                'phoneNumber' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:500',
                'profileImage' => 'nullable|string|max:1000'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $updates = array_filter($request->only([
                'displayName', 'phoneNumber', 'address', 'profileImage'
            ]));

            if (empty($updates)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No data to update'
                ], 400);
            }

            $this->firebaseService->updateUserProfile($uid, $updates);

            return response()->json([
                'success' => true,
                'message' => 'User profile updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new booking
     */
    public function createBooking(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'clientId' => 'required|string',
                'serviceProviderId' => 'required|string',
                'serviceType' => 'required|string|max:100',
                'bookingDate' => 'required|date',
                'bookingTime' => 'required|string',
                'duration' => 'required|integer|min:1',
                'location' => 'required|string|max:500',
                'notes' => 'nullable|string|max:1000',
                'totalAmount' => 'required|numeric|min:0',
                'voucherCode' => 'nullable|string|max:50'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $bookingData = $request->all();
            
            // Validate voucher if provided
            if (!empty($bookingData['voucherCode'])) {
                $voucher = $this->firebaseService->validateVoucher(
                    $bookingData['voucherCode'],
                    $bookingData['clientId']
                );
                
                if (!$voucher) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid or expired voucher code'
                    ], 400);
                }
                
                $bookingData['voucherApplied'] = true;
                $bookingData['discountAmount'] = $voucher['discountAmount'];
                $bookingData['finalAmount'] = $bookingData['totalAmount'] - $voucher['discountAmount'];
            } else {
                $bookingData['finalAmount'] = $bookingData['totalAmount'];
            }

            $bookingId = $this->firebaseService->createBooking($bookingData);

            return response()->json([
                'success' => true,
                'message' => 'Booking created successfully',
                'data' => [
                    'bookingId' => $bookingId,
                    'finalAmount' => $bookingData['finalAmount']
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get booking details
     */
    public function getBooking(Request $request, $bookingId)
    {
        try {
            $booking = $this->firebaseService->getBooking($bookingId);

            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $booking
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user bookings
     */
    public function getUserBookings(Request $request, $userId)
    {
        try {
            $role = $request->get('role', 'client');
            $bookings = $this->firebaseService->getUserBookings($userId, $role);

            return response()->json([
                'success' => true,
                'data' => $bookings,
                'count' => count($bookings)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get user bookings',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update booking status
     */
    public function updateBookingStatus(Request $request, $bookingId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'status' => 'required|string|in:pending,confirmed,in_progress,completed,cancelled',
                'notes' => 'nullable|string|max:500'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $this->firebaseService->updateBookingStatus(
                $bookingId,
                $request->status,
                $request->notes
            );

            return response()->json([
                'success' => true,
                'message' => 'Booking status updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update booking status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available service providers
     */
    public function getAvailableServiceProviders(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'serviceType' => 'required|string|max:100'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $providers = $this->firebaseService->getAvailableServiceProviders($request->serviceType);

            return response()->json([
                'success' => true,
                'data' => $providers,
                'count' => count($providers)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get service providers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get valid vouchers
     */
    public function getValidVouchers(Request $request)
    {
        try {
            $userId = $request->get('userId');
            $vouchers = $this->firebaseService->getValidVouchers($userId);

            return response()->json([
                'success' => true,
                'data' => $vouchers,
                'count' => count($vouchers)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get vouchers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get dashboard statistics
     */
    public function getDashboardStats(Request $request)
    {
        try {
            $stats = $this->firebaseService->getDashboardStats();

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get dashboard stats',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}