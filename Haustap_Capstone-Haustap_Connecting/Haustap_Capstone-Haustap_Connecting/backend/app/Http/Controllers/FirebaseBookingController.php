<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FirebaseBookingController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function createBooking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'clientId' => 'required|string',
            'serviceType' => 'required|string|max:255',
            'serviceDetails' => 'required|array',
            'location' => 'required|array',
            'location.address' => 'required|string',
            'location.latitude' => 'required|numeric',
            'location.longitude' => 'required|numeric',
            'schedule' => 'required|array',
            'schedule.date' => 'required|date',
            'schedule.time' => 'required|string',
            'pricing' => 'required|array',
            'pricing.basePrice' => 'required|numeric|min:0',
            'pricing.additionalCharges' => 'numeric|min:0',
            'pricing.discount' => 'numeric|min:0',
            'pricing.totalPrice' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $bookingData = $request->all();
            $bookingData['status'] = 'pending';
            $bookingData['paymentStatus'] = 'pending';
            
            $bookingId = $this->firebaseService->createBooking($bookingData);

            return response()->json([
                'success' => true,
                'message' => 'Booking created successfully',
                'data' => ['bookingId' => $bookingId]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getBooking($bookingId)
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

    public function getUserBookings(Request $request, $userId)
    {
        $validator = Validator::make(['userId' => $userId, 'role' => $request->role], [
            'userId' => 'required|string',
            'role' => 'required|in:client,service_provider',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $bookings = $this->firebaseService->getUserBookings($userId, $request->role);

            return response()->json([
                'success' => true,
                'data' => $bookings
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get user bookings',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateBookingStatus(Request $request, $bookingId)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,confirmed,ongoing,completed,cancelled,returned',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
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

    public function assignServiceProvider(Request $request, $bookingId)
    {
        $validator = Validator::make($request->all(), [
            'serviceProviderId' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $this->firebaseService->assignServiceProvider($bookingId, $request->serviceProviderId);

            return response()->json([
                'success' => true,
                'message' => 'Service provider assigned successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to assign service provider',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function cancelBooking(Request $request, $bookingId)
    {
        $validator = Validator::make($request->all(), [
            'reason' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $this->firebaseService->cancelBooking($bookingId, $request->reason);

            return response()->json([
                'success' => true,
                'message' => 'Booking cancelled successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAvailableServiceProviders(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'serviceType' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $providers = $this->firebaseService->getAvailableServiceProviders($request->serviceType);

            return response()->json([
                'success' => true,
                'data' => $providers
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get service providers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getBookingStats(Request $request, $userId)
    {
        $validator = Validator::make(['userId' => $userId, 'role' => $request->role], [
            'userId' => 'required|string',
            'role' => 'required|in:client,service_provider',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $stats = $this->firebaseService->getBookingStats($userId, $request->role);

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get booking stats',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}