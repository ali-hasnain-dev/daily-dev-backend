<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $payload = $request->validated();
        try {
            $payload['password'] = Hash::make($payload['password']);
            User::create($payload);
            return response()->json(['message' => 'User created successfully'], 201);
        } catch (\Exception $th) {
            Log::info('Register error: ' . $th->getMessage());
            return response()->json(['message' => 'Something went wrong try again later'], 500);
        }
    }

    public function login(Request $request)
    {
        $payload = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($payload)) {
            $user = User::find(Auth::id());
            $token = $user->createToken('auth_token')->plainTextToken;
            $userRes = array_merge($user->toArray(), ['token' => $token]);
            return response()->json(['status' => 'success', 'user' => $userRes]);
        }

        return response()->json(['message' => 'Invalid email or password'], 401);
    }

    public function checkCredentials(Request $request)
    {
        $payload = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($payload)) {
            return response()->json(['status' => 200, 'message' => 'successfully logged in']);
        }

        return response()->json(['message' => 'Invalid email or password'], 401);
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['status' => 200, 'message' => 'successfully logged out']);
        } catch (\Exception $th) {
            Log::info('Logout error: ' . $th->getMessage());
            return response()->json(['message' => 'Something went wrong try again later'], 500);
        }
    }
}