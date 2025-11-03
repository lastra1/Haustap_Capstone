<?php

use App\Http\Controllers\AuthController;
use App\Models\Service;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceCategoryController;


//services
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services-category', [ServiceCategoryController::class, 'index']);

// Minimal auth endpoints for UI integration (CSRF disabled for mobile clients)
Route::post('/auth/register', [AuthController::class, 'register'])
    ->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/auth/login', [AuthController::class, 'login']);
// Route::middleware('auth:sanctum')->post('/auth/update-fcm', [AuthController::class, 'updateFcmToken']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
 
    // bookings
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings/{id}', [BookingController::class, 'show']);
    Route::put('/bookings/{id}', [BookingController::class, 'update']);
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);
});