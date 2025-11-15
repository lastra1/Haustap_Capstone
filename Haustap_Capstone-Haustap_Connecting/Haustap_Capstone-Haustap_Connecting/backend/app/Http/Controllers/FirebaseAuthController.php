<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FirebaseAuthController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'displayName' => 'required|string|max:255',
            'phoneNumber' => 'nullable|string|max:20',
            'role' => 'required|in:client,service_provider',
            'businessName' => 'nullable|string|max:255',
            'services' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $userData = [
                'displayName' => $request->displayName,
                'phoneNumber' => $request->phoneNumber,
                'role' => $request->role,
                'businessName' => $request->businessName,
                'services' => $request->services ?? [],
            ];

            $user = $this->firebaseService->createUser($request->email, $request->password, $userData);

            return response()->json([
                'success' => true,
                'message' => 'User registered successfully',
                'data' => [
                    'uid' => $user->uid,
                    'email' => $user->email,
                    'displayName' => $user->displayName,
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Note: In a real implementation, you would verify the password
            // This is a simplified example - Firebase Auth should be handled client-side
            $user = $this->firebaseService->loginUser($request->email, $request->password);
            $userData = $this->firebaseService->getUserData($user->uid);

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => [
                    'user' => $userData,
                    'uid' => $user->uid,
                    'email' => $user->email,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed',
                'error' => $e->getMessage()
            ], 401);
        }
    }

    public function getUserProfile($uid)
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
                'message' => 'Failed to get user profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateProfile(Request $request, $uid)
    {
        $validator = Validator::make($request->all(), [
            'displayName' => 'nullable|string|max:255',
            'phoneNumber' => 'nullable|string|max:20',
            'businessName' => 'nullable|string|max:255',
            'services' => 'nullable|array',
            'availability' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $updates = array_filter($request->only([
                'displayName', 'phoneNumber', 'businessName', 'services', 'availability'
            ]));

            $this->firebaseService->updateUserProfile($uid, $updates);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $this->firebaseService->resetPassword($request->email);

            return response()->json([
                'success' => true,
                'message' => 'Password reset email sent successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send password reset email',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}