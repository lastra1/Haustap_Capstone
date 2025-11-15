<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class GuestController extends BaseController
{
    public function home()
    {
        return view('guest.home');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }
}