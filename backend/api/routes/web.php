<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Admin dashboard served via Blade wrapper, preserving legacy UI
Route::view('/admin', 'admin.dashboard');
