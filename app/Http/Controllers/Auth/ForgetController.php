<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;


class ForgetController extends Controller
{
    /**
     * Check if the email exists.
     */
    public function checkEmail(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|email|exists:users,email',
            ], [
                'email.exists' => 'The email does not match',
            ]);
            return response()->json([
                'message' => 'Email exists in the system.',
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->errors()['email'][0],
            ], 401);
        }
    }

    public function checkmpinEmail(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|email|exists:users,email', 
            ], [
                'email.exists' => 'Email Is Does Not Match!', 
            ]);

            return response()->json([
                'message' => 'Email Match Successfully!',
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->errors()['email'][0],
            ], 401);
        }
    }
    /**
     * Reset password with email only.
     */
    public function resetPassword(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|exists:users,email',
            'new_password' => 'required|string|min:8', 
        ]);

        try {
            $user = User::where('email', $validatedData['email'])->firstOrFail();
            $user->update([
                'password' => Hash::make($validatedData['new_password']),
            ]);
            return response()->json([
                'message' => 'Password reset successfully.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error resetting password: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while resetting the password.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function resetMPIN(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|exists:users,email', 
            'new_mpin' => 'required|numeric|digits:4', 
        ]);

        try {
            $user = User::where('email', $validatedData['email'])->firstOrFail();
            $user->update([
                'mpin' => $validatedData['new_mpin'], 
            ]);

            return response()->json([
                'message' => 'MPIN reset successfully.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error resetting MPIN: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while resetting the MPIN.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
