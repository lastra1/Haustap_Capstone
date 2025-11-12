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
Route::get('/auth/mode', [ModeController::class, 'get'])->middleware('role');
Route::post('/auth/mode', [ModeController::class, 'save'])->middleware('role');

// Provider application and status
Route::get('/providers/status', [ProviderController::class, 'status'])->middleware('role');
Route::post('/providers/apply', [ProviderController::class, 'apply'])->middleware('role');
Route::post('/admin/providers/approve', [ProviderController::class, 'approve'])->middleware('role:admin');
Route::post('/admin/providers/revoke', [ProviderController::class, 'revoke'])->middleware('role:admin');

Route::get('/bookings/', [BookingsController::class, 'index'])->middleware('role');
Route::post('/bookings/', [BookingsController::class, 'store'])->middleware('role:client');
Route::get('/bookings/{id}', [BookingsController::class, 'show'])->whereNumber('id')->middleware('role');
Route::post('/bookings/{id}/cancel', [BookingsController::class, 'cancel'])->whereNumber('id')->middleware('role:client');
Route::post('/bookings/{id}/status', [BookingsController::class, 'updateStatus'])->whereNumber('id')->middleware('role:provider');
Route::post('/bookings/{id}/rate', [BookingsController::class, 'rate'])->whereNumber('id')->middleware('role:client');
Route::post('/bookings/{id}/return', [BookingsController::class, 'requestReturn'])->whereNumber('id')->middleware('role:client');
Route::get('/bookings/returns', [BookingsController::class, 'listReturns'])->middleware('role:admin');

Route::post('/chat/open', [ChatController::class, 'open'])->middleware('role');
Route::get('/chat/{booking_id}/messages', [ChatController::class, 'listMessages'])->whereNumber('booking_id')->middleware('role');
Route::post('/chat/{booking_id}/messages', [ChatController::class, 'sendMessage'])->whereNumber('booking_id')->middleware('role');

Route::get('/admin/settings', [AdminSettingsController::class, 'get'])->middleware('role:admin');
Route::post('/admin/settings', [AdminSettingsController::class, 'save'])->middleware('role:admin');