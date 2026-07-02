<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Login and generate a new token for the user.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['These credentials do not match our records.'],
            ]);
        }

        // Revoke any existing tokens for this user with the same name
        $user->tokens()->where('name', 'postman-token')->delete();

        $token = $user->createToken('postman-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'user'    => $user->only('id', 'name', 'email'),
            'roles'   => $user->getRoleNames(),
            'token'   => $token,
        ]);
    }

    /**
     * Logout — revoke the current token only.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully.',
        ]);
    }
}