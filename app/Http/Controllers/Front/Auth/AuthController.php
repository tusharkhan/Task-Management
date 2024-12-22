<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function verifyEmail($token)
    {
        $currentDateTime = now();
        $checkToken = DB::table('personal_access_tokens')
            ->where('token', $token)
            ->where('expires_at', '>', $currentDateTime)
            ->first();

        if (!$checkToken) {
            return redirect()->route('login')->with('error', 'Invalid token or token expired');
        }

        $user = DB::table('users')->where('id', $checkToken->tokenable_id)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'User not found');
        }

        DB::table('personal_access_tokens')->where('token', $token)->delete();

        DB::table('users')->where('id', $user->id)->update(['email_verified_at' => $currentDateTime]);

        return redirect()->route('login')->with('success', 'Email verified successfully');
    }
}
