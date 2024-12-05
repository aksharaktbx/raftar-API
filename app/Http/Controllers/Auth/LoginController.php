<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
 public function login(Request $request)
{
    // Validate the input data
    $validatedData = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:8',
    ]);

    // Retrieve the user by email
    $user = User::where('email', $validatedData['email'])->first();

    // Check if the user exists
    if (!$user) {
        return response()->json([
            'status' => 401,
            'message' => 'Email does not exist.',
        ], 401);
    }

    // Verify the password
    if (!Hash::check($validatedData['password'], $user->password)) {
        return response()->json([
            'status' => 401,
            'message' => 'Invalid password.',
        ], 401);
    }

    // Generate a random token (you can store this token in the database for further use)
    $token = Str::random(32);

    // Return the success response with all user data
    return response()->json([
        'message' => 'Login successful',
        'token' => $token,
        'user' => $user, // Returns all user data as per the User model
    ], 200);
}

}
