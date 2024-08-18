<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Validate user input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password for security
        ]);

        // Generate a token for the new user
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return the user and token in the response
        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201); // 201 status code indicates resource creation
    }

    /**
     * Authenticate a user and issue a token.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        // Validate user input
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user
        if (!Auth::attempt($request->only('email', 'password'))) {
            // If authentication fails, throw an exception
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Retrieve the authenticated user
        $user = User::where('email', $request->email)->firstOrFail();

        // Generate a new token for the authenticated user
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return the user and token in the response
        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Revoke all tokens...
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
