<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash; 


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->all();

        // Combine names if provided separately
        $name = $data['name'] ?? trim(($data['firstName'] ?? '') . ' ' . ($data['lastName'] ?? ''));

        $validator = Validator::make([
            'name' => $name,
            'email' => $data['email'] ?? null,
            'password' => $data['password'] ?? null,
            'confirmPassword' => $data['confirmPassword'] ?? null,
        ], [
            'name' => 'required|string|min:2',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'confirmPassword' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $name,
            'email' => $data['email'],
            'password' => $data['password'], // hashed via model cast
        ]);

        $token = $user->createToken('web')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

       if ($request->has('fcm_token')) {
            $user->fcm_token = $request->fcm_token;
            $user->save();
        }

        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }
    // Return the authenticated user (requires Bearer token)
    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    // Revoke the current access token (logout)
    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }

        return response()->json(['success' => true]);
    }

    // public function updateFcmToken(Request $request)
    // {
    //     $request->validate([
    //         'fcm_token' => 'required|string',
    //     ]);

    //     $user = $request->user();
    //     $user->fcm_token = $request->fcm_token;
    //     $user->save();

    //     return response()->json(['message' => 'FCM token updated']);
    // }
}