<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\RegistrationVerificationMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $loginRequest)
    {
        $credentials = $loginRequest->only('email', 'password');

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return sendError('Unauthorized', ['error' => 'Credentials mismatch'], Response::HTTP_UNAUTHORIZED);
        }

        return sendSuccess(
            'Login Success',
            [
                'access_token' => $token,
                'token_type' => 'bearer',
                'user' => Auth::guard('api')->user()
            ]
        );
    }

    public function register(RegisterRequest $registerRequest)
    {
        $user = User::create([
            'name' => $registerRequest->name,
            'email' => $registerRequest->email,
            'password' => Hash::make($registerRequest->password)
        ]);

        $token = Auth::guard('api')->attempt(['email' => $user->email, 'password' => $registerRequest->password]);

        $accessToken = [
            'token' => randomHashString(),
            'tokenable_type' => 'verification',
            'tokenable_id' => $user->id,
            'name' => 'Registration Verification',
            'expires_at' => now()->addDay()
        ];

        DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();
        DB::table('personal_access_tokens')->insert($accessToken);

        $data = [
            'user' => $user,
            'link' => route('email.verify', $accessToken['token']) ,
            'expires_at' => $accessToken['expires_at'],
            'brand_name' => config('app.name')
        ];

        if( $token ){
            Mail::to($user->email)->send(new RegistrationVerificationMail($data));
        }

        return sendSuccess(
            'Register Success',
            [
                'access_token' => $token,
                'token_type' => 'bearer',
                'user' => $user
            ],
            Response::HTTP_CREATED
        );
    }

    public function logout()
    {
        Auth::guard('api')->logout();

        return sendSuccess('Logout Success', [], Response::HTTP_OK);
    }

    public function me()
    {
        $me = Auth::guard('api')->user();

        return sendSuccess('User Profile', $me, Response::HTTP_OK);
    }
}
