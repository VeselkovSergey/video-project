<?php

namespace App\Http\Controllers\Management;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManagementController
{
    public function Index()
    {
        $authUser = auth()->check();
//        $user = auth()->user();
        if (!$authUser /*|| $user->role < 10*/) {
            return redirect(route('management-login-page'));
        } else {
            return redirect(route('home-page'));
        }
    }

    public function LoginPage() {
        return view('management.auth.login');
    }

    public function Login(Request $request)
    {
        $user = User::where('email', $request->login)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();
        }
        return redirect(route('management-home-page'));
    }

    public function Logout()
    {
        Auth::logout();
        return redirect(route('management-home-page'));
    }
}
