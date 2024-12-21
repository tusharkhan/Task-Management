<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $loginRequest)
    {
        $credentials = $loginRequest->only('email', 'password');

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return sendError('Unauthorized', ['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
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
