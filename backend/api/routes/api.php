<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\Auth\ModeController;
use App\Http\Controllers\Provider\ProviderController;
use App\Http\Controllers\Auth\PasswordController;

// Stateless API endpoints (no CSRF)
Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});

Route::post('/auth/otp/send', [OtpController::class, 'send']);
Route::post('/auth/otp/verify', [OtpController::class, 'verify']);
Route::post('/auth/register', [PasswordController::class, 'register']);
Route::post('/auth/login', [PasswordController::class, 'login']);
Route::post('/auth/password/reset', [PasswordController::class, 'reset']);
Route::get('/auth/mode', [ModeController::class, 'get']);
Route::post('/auth/mode', [ModeController::class, 'save']);

// Provider application and status
Route::get('/providers/status', [ProviderController::class, 'status']);
Route::post('/providers/apply', [ProviderController::class, 'apply']);
Route::post('/admin/providers/approve', [ProviderController::class, 'approve']);
Route::post('/admin/providers/revoke', [ProviderController::class, 'revoke']);

Route::get('/bookings/', [BookingsController::class, 'index']);
Route::post('/bookings/', [BookingsController::class, 'store']);
Route::get('/bookings/{id}', [BookingsController::class, 'show'])->whereNumber('id');
Route::post('/bookings/{id}/cancel', [BookingsController::class, 'cancel'])->whereNumber('id');
Route::post('/bookings/{id}/status', [BookingsController::class, 'updateStatus'])->whereNumber('id');
Route::post('/bookings/{id}/rate', [BookingsController::class, 'rate'])->whereNumber('id');
Route::post('/bookings/{id}/return', [BookingsController::class, 'requestReturn'])->whereNumber('id');
Route::get('/bookings/returns', [BookingsController::class, 'listReturns']);

Route::post('/chat/open', [ChatController::class, 'open']);
Route::get('/chat/{booking_id}/messages', [ChatController::class, 'listMessages'])->whereNumber('booking_id');
Route::post('/chat/{booking_id}/messages', [ChatController::class, 'sendMessage'])->whereNumber('booking_id');

Route::get('/admin/settings', [AdminSettingsController::class, 'get']);
Route::post('/admin/settings', [AdminSettingsController::class, 'save']);