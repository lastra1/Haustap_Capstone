<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MySQLFirebaseBridgeService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SyncController extends Controller
{
    private MySQLFirebaseBridgeService $bridgeService;

    public function __construct(MySQLFirebaseBridgeService $bridgeService)
    {
        $this->bridgeService = $bridgeService;
    }

    /**
     * Get sync status
     */
    public function status(): JsonResponse
    {
        try {
            $status = $this->bridgeService->getSyncStatus();
            
            return response()->json([
                'success' => true,
                'data' => $status,
                'message' => 'Sync status retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get sync status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Sync MySQL users to Firebase
     */
    public function syncUsersToFirebase(Request $request): JsonResponse
    {
        try {
            $result = $this->bridgeService->syncUsersToFirebase();
            
            return response()->json([
                'success' => true,
                'data' => $result,
                'message' => "Users sync completed: {$result['synced']} users synced"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to sync users to Firebase: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Sync Firebase users to MySQL
     */
    public function syncUsersFromFirebase(Request $request): JsonResponse
    {
        try {
            $result = $this->bridgeService->syncUsersFromFirebase();
            
            return response()->json([
                'success' => true,
                'data' => $result,
                'message' => "Users sync completed: {$result['synced']} users synced"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to sync users from Firebase: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Sync bookings between MySQL and Firebase
     */
    public function syncBookings(Request $request): JsonResponse
    {
        try {
            $result = $this->bridgeService->syncBookings();
            
            return response()->json([
                'success' => true,
                'data' => $result,
                'message' => "Bookings sync completed: {$result['mysql_to_firebase']} bookings synced to Firebase"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to sync bookings: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Full sync - users and bookings
     */
    public function fullSync(Request $request): JsonResponse
    {
        try {
            $usersResult = $this->bridgeService->syncUsersToFirebase();
            $bookingsResult = $this->bridgeService->syncBookings();
            
            return response()->json([
                'success' => true,
                'data' => [
                    'users' => $usersResult,
                    'bookings' => $bookingsResult
                ],
                'message' => "Full sync completed: {$usersResult['synced']} users and {$bookingsResult['mysql_to_firebase']} bookings synced"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to perform full sync: ' . $e->getMessage()
            ], 500);
        }
    }
}