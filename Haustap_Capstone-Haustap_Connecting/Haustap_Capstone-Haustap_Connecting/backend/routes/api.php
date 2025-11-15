<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FirebaseApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Firebase API Routes
Route::prefix('firebase')->group(function () {
    
    // User Management
    Route::post('/users/create', [FirebaseApiController::class, 'createUser']);
    Route::get('/users/{uid}', [FirebaseApiController::class, 'getUserData']);
    Route::put('/users/{uid}/profile', [FirebaseApiController::class, 'updateUserProfile']);
    
    // Booking Management
    Route::post('/bookings/create', [FirebaseApiController::class, 'createBooking']);
    Route::get('/bookings/{bookingId}', [FirebaseApiController::class, 'getBooking']);
    Route::get('/users/{userId}/bookings', [FirebaseApiController::class, 'getUserBookings']);
    Route::put('/bookings/{bookingId}/status', [FirebaseApiController::class, 'updateBookingStatus']);
    
    // Service Providers
    Route::get('/service-providers/available', [FirebaseApiController::class, 'getAvailableServiceProviders']);
    
    // Vouchers
    Route::get('/vouchers/valid', [FirebaseApiController::class, 'getValidVouchers']);
    
    // Dashboard
    Route::get('/dashboard/stats', [FirebaseApiController::class, 'getDashboardStats']);
    
});

// Authentication Routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [FirebaseApiController::class, 'createUser']);
    // Add more auth routes as needed
});

// Health Check
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
        'service' => 'HausTap API'
    ]);
});