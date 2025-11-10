<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;

Route::get('/', function () {
    return view('welcome');
});

// Admin dashboard served via Blade wrapper, preserving legacy UI
Route::view('/admin', 'admin.dashboard');

// Guest-facing pages served via Blade views
Route::get('/home', [GuestController::class, 'home']);
Route::get('/login', [GuestController::class, 'login']);
Route::get('/register', [GuestController::class, 'register']);
