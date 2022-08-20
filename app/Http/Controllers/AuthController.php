<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except("login", "register");
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!User::where('email', $request->email)->exists()) {
            return response()->json([
                'status' => [
                    'result' => "error",
                    "message" => "Email not found!",
                ],
                'message' => 'Could not find that email!',
            ], 404);
        }

        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => [
                    "result" => "error",
                    "message" => "Invalid credentials!",
                ]
            ], 401);
        }

        $user = Auth::user();

        return response()->json([
            'status' => [
                "result" => "success",
                "message" => "Successfully logged in!",
            ],
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ], 200);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            "username" => "required|string|max:255",
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
        ]);

        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email already exists',
            ], 409);
        }

        $user = User::create([
            'name' => $request->name,
            "username" => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function me()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
        ]);
    }

    public function refresh()
    {
        return response()->json([
            "status" => [
                "result" => "success",
                "message" => "Successfully refreshed token!",
            ],
            'user' => Auth::user(),
            'authorization' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $user->update($request->all());

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully',
            'user' => $user,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $user = Auth::user();

        if (Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'New password must be different from old one!',
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        Auth::logout();

        return response()->json([
            "status" => "success",
            "message" => "Password reset successfully!",
        ]);
    }

    public function destroy()
    {
        Auth::user()->delete();
        Auth::logout();

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully',
        ]);
    }
}
