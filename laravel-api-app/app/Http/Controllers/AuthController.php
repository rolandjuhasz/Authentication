<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
{
    $fields = $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed',
        'admin' => 'nullable|string', // Az admin mező opcionális
    ]);

    $user = User::create([
        'name' => $fields['name'],
        'email' => $fields['email'],
        'password' => Hash::make($fields['password']),
        'admin' => $fields['admin'] ?? null, // Ha nincs megadva, marad null
    ]);

    $token = $user->createToken($request->name);

    return [
        'user' => $user,
        'token' => $token->plainTextToken
    ];
}

public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'errors' => [
                'email' => ['The provided credentials are incorrect.']
            ]
        ], 401);
    }

    $token = $user->createToken($user->name);

    return [
        'user' => $user,
        'isAdmin' => $user->admin === 'Admin', // Admin státusz visszaadása
        'token' => $token->plainTextToken
    ];
}

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'You are logged out.' 
        ];
    }
}