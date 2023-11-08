<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create(array_merge($request->validated(), [
                'password' => Hash::make($request->input('password')),
            ]));

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
                'message' => 'User created successfully!!'
            ], 201);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error updating message subject',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $user->createToken('authToken')->plainTextToken;
                return response()->json([
                    'user' => $user,
                    'token' => $token,
                    'message' => 'User successfully login!!'
                ], 200);
            }

            return response()->json(['message' => 'Invalid credentials'], 401);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error updating message subject',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();

            return response()->json(['message' => 'Logged out'], 200);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error updating message subject',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
