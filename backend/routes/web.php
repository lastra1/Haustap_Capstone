<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\Service;
use App\Http\Controllers\ServiceController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

Route::get('/', function () {
    return view('welcome');
});

// Minimal auth endpoints for UI integration (CSRF disabled for mobile clients)
Route::post('/auth/register', [AuthController::class, 'register'])
    ->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/auth/login', [AuthController::class, 'login'])
    ->withoutMiddleware([VerifyCsrfToken::class]);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});
