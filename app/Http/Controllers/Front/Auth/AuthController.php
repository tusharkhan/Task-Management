<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Mail\ForgetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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


    public function showForgetPasswordForm()
    {
        return view('forgetPass.forgetPassword');
    }

    public function submitForgetPasswordForm(ForgetPasswordRequest $forgetPasswordRequest)
    {
        $user = User::firstWhere('email', $forgetPasswordRequest->email);
        //reset.password.get
        $accessToken = [
            'token' => randomHashString(),
            'expires_at' => now()->addMinutes(60),
            'tokenable_type' => 'reset_password',
            'tokenable_id' => $user->id,
            'name' => 'Reset Password'
        ];

        DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();
        DB::table('personal_access_tokens')->insert($accessToken);

        $mailData = [
            'brand_name' => env("APP_NAME"),
            'user' => $user,
            'link' => route('reset.password.get', $accessToken['token']),
            'expires_at' => $accessToken['expires_at']
        ];

        Mail::to($user->email)->send(new ForgetPasswordMail($mailData));

        return redirect()->route('login')->with('success', 'Reset password link sent to your email');
    }

    public function showResetPasswordForm($token) {

        return view('forgetPass.resetPass', ['token' => $token]);

    }

    public function submitResetPasswordForm(ResetPasswordRequest $resetPasswordRequest)
    {
        $currentDateTime = now();
        $checkToken = DB::table('personal_access_tokens')
            ->where('token', $resetPasswordRequest->token)
            ->where('expires_at', '>', $currentDateTime)
            ->first();

        if (!$checkToken) {
            return redirect()->route('login')->with('error', 'Invalid token or token expired');
        }

        $user = DB::table('users')->where('id', $checkToken->tokenable_id)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'User not found');
        }

        DB::table('personal_access_tokens')->where('token', $resetPasswordRequest->token)->delete();

        DB::table('users')->where('id', $user->id)->update(['password' => Hash::make($resetPasswordRequest->password)]);

        return redirect()->route('login')->with('success', 'Password reset successfully, please login');
    }
}
