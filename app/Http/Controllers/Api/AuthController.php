<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\AuthException;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);
            $credentials = $request->only('email', 'password');
            $token = Auth::attempt($credentials);

            if (!$token) {
                return response()->json([
                    'message' => 'Unauthorized',
                ], 401);
            }

            $user = Auth::user();
            return response()->json([
                'user' => $user,
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
        } catch (AuthException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 401);
        }
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'message' => 'User created successfully',
                'user' => $user
            ]);
        }catch (AuthException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 401);
        }
    }

    public function logout()
    {
        try {
            Auth::logout();
            return response()->json([
                'message' => 'Successfully logged out',
            ]);
        }catch (AuthException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 401);
        }
    }

    public function refresh()
    {
        try {
            return response()->json([
                'user' => Auth::user(),
                'authorisation' => [
                    'token' => Auth::refresh(),
                    'type' => 'bearer',
                ]
            ]);
        }catch (AuthException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 401);
        }
    }
}
