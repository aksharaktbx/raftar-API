<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTPMail;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
  public function register(Request $request)
  {
    try {
      $validatedData = $request->validate([
        'username' => 'required|string|max:255',
        'mobile_number' => 'required|string|unique:users,mobile_number',
        'password' => 'required|string|min:8',
        'mpin' => 'required|digits:4',
        'email' => 'required|email|unique:users,email',
      ]);
      $otp = rand(1000, 9999);
      DB::table('pending_registrations')->updateOrInsert(
        ['mobile_number' => $validatedData['mobile_number']],
        [
          'username' => $validatedData['username'],
          'email' => $validatedData['email'],
          'password' => Hash::make($validatedData['password']),
          'mpin' => $validatedData['mpin'],
          'otp' => $otp,
          'created_at' => now(),
        ]
      );

      // Send OTP via email
      Mail::to($validatedData['email'])->send(new OTPMail($otp));

      return response()->json([
        'status' => 200,
        'message' => 'OTP sent successfully. Please verify to complete registration.',
      ]);
    } catch (ValidationException $e) {
      $errorMessages = collect($e->errors())->flatten()->join(' ');
      return response()->json([
        'status' => 401,
        'message' => $errorMessages,
      ], 401);
    } catch (Exception $e) {
      return response()->json([
        'status' => 500,
        'message' => 'An unexpected error occurred.',
        'error' => $e->getMessage(),
      ], 500);
    }
  }
  public function verifyOTP(Request $request)
  {
    $request->validate([
      'otp' => 'required|digits:4',
    ]);


    $otpRecord = DB::table('pending_registrations')
      ->where('otp', $request->otp)
      ->orderBy('created_at', 'desc')
      ->first();

    if ($otpRecord) {
      // Create the user from pending registration data
      $user = User::create([
        'username' => $otpRecord->username,
        'email' => $otpRecord->email,
        'password' => $otpRecord->password,
        'mpin' => $otpRecord->mpin,
        'is_verified' => true,
        'mobile_number' => $otpRecord->mobile_number,  // Ensure mobile number is passed
      ]);

      // Generate referral code
      $referralCode = 'REF' . strtoupper(substr(md5($user->id . time()), 0, 6));
      $user->update(['referral_code' => $referralCode]);

      // Delete the OTP record
      DB::table('pending_registrations')->where('otp', $request->otp)->delete();

      return response()->json([
        'status' => 200,
        'message' => 'OTP verified and user created successfully.',
        'referral_code' => $referralCode,
      ]);
    }

    return response()->json([
      'status' => 401,
      'message' => 'Invalid OTP.',
    ], 401);
  }
  public function getAllUsers()
  {
    try {
      $users = User::all()->makeHidden(['photo']); // Hides the 'photo' field
      return response()->json([
        'users' => $users
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'An error occurred while fetching users.',
        'error' => $e->getMessage(),
      ], 500);
    }
  }
  public function getUserById($id)
  {
    try {
      $user = User::findOrFail($id);
      return response()->json([
        'user' => $user
      ], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      return response()->json([
        'message' => 'User not found',
      ], 404);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'An error occurred while fetching the user.',
        'error' => $e->getMessage(),
      ], 500);
    }
  }
  public function updateUser(Request $request, $id)
  {
    try {
      // Validate the incoming request data
      $validatedData = $request->validate([
        'username' => 'nullable|string|max:255|unique:users,username,' . $id,
        'mobile_number' => 'nullable|string|max:15|unique:users,mobile_number,' . $id,
        'state' => 'nullable|string|max:255',
        'distic' => 'nullable|string|max:255',
        'photo' => 'nullable|image|max:2048', // Validate photo as an image with a max size of 2MB
        'email' => 'nullable|string|email|max:255|unique:users,email,' . $id,
      ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
      return response()->json([
        'message' => 'Validation error.',
        'errors' => $e->errors(),
      ], 422);
    }

    try {
      // Find the user by ID
      $user = User::findOrFail($id);

      // Handle photo upload if a file is provided
      if ($request->hasFile('photo')) {
        // Delete the old photo if it exists
        if ($user->photo && \Storage::exists($user->photo)) {
          \Storage::delete($user->photo);
        }

        // Store the new photo in the 'photos' directory inside the storage folder
        $photoPath = $request->file('photo')->store('photos', 'public');
        $validatedData['photo'] = $photoPath; // Save the path to the validated data
      }

      // Update the user's data explicitly
      $user->username = $validatedData['username'] ?? $user->username;
      $user->mobile_number = $validatedData['mobile_number'] ?? $user->mobile_number;
      $user->state = $validatedData['state'] ?? $user->state;
      $user->email = $validatedData['email'] ?? $user->email;
      $user->distic = $validatedData['distic'] ?? $user->distic;
      $user->photo = $validatedData['photo'] ?? $user->photo;

      // Save the updated user
      $user->save();

      // Return success response with updated user data
      return response()->json([
        "message" => "User updated successfully.",
        "user" => [
          "id" => $user->id,
          "username" => $user->username,
          "mobile_number" => $user->mobile_number,
          "mpin" => $user->mpin,
          "state" => $user->state,
          "email" => $user->email,
          "distic" => $user->distic,
          "created_at" => $user->created_at,
          "updated_at" => $user->updated_at,
          "wallet_balance" => $user->wallet_balance,
          "is_active" => $user->is_active,
          "photo" => $user->photo ? url('storage/' . $user->photo) : null, // Ensure full URL for the photo
        ],
      ], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      return response()->json([
        "message" => "User not found.",
      ], 404);
    } catch (\Exception $e) {
      return response()->json([
        "message" => "An error occurred while updating the user.",
        "error" => $e->getMessage(),
      ], 500);
    }
  }
  public function updateMpin(Request $request, $id)
  {
    try {

      $validatedData = $request->validate([
        'oldmpin' => 'required|digits:4',
        'newmpin' => 'required|digits:4|different:oldmpin',
      ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
      return response()->json([
        'message' => 'Validation error',
        'errors' => $e->errors(),
      ], 422);
    }

    try {

      $user = User::findOrFail($id);


      if ($user->mpin !== $validatedData['oldmpin']) {
        return response()->json([
          'message' => 'The old MPIN is incorrect.',
        ], 400);
      }

      $user->update([
        'mpin' => $validatedData['newmpin'],
      ]);

      return response()->json([
        'message' => 'MPIN updated successfully',
      ], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      return response()->json([
        'message' => 'User not found',
      ], 404);
    } catch (\Illuminate\Database\QueryException $e) {
      return response()->json([
        'message' => 'An unexpected error occurred while updating the MPIN.',
        'error' => $e->getMessage(),
      ], 500);
    }
  }
  public function login(Request $request)
  {
    try {

      $validatedData = $request->validate([
        'mpin' => 'required|digits:4',
      ]);

      $user = User::where('mpin', $validatedData['mpin'])->first();

      if (!$user) {
        return response()->json([
          'message' => 'Invalid MPIN or user not found.',
        ], 401);
      }

      if ($user->is_active == 0) {
        return response()->json([
          'message' => 'Account is deactivated. Please contact support.',
        ], 403);
      }

      $token = $user->createToken('LoginToken')->accessToken;

      return response()->json([
        'message' => 'Login successful',
        'token' => $token,
      ], 200);
    } catch (\Illuminate\Validation\ValidationException $e) {
      return response()->json([
        'message' => 'Validation error.',
        'errors' => $e->errors(),
      ], 422);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'An error occurred during login.',
        'error' => $e->getMessage(),
      ], 500);
    }
  }
  public function getWalletBalance($id)
  {
    try {

      $user = User::findOrFail($id);


      return response()->json([
        'wallet_balance' => $user->wallet_balance,
      ], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      return response()->json([
        'message' => 'User not found',
      ], 404);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'An error occurred while fetching the wallet balance.',
        'error' => $e->getMessage(),
      ], 500);
    }
  }
  public function verifyMpin(Request $request, $id)
  {
    $validatedData = $request->validate([
      'mpin' => 'required|digits:4',
    ]);
    try {
      $user = User::findOrFail($id);
      if ($user->mpin === $validatedData['mpin']) {
        return response()->json([
          'message' => 'MPIN verified successfully',
        ], 200);
      } else {
        return response()->json([
          'message' => 'Invalid MPIN',
        ], 401);
      }
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      return response()->json([
        'message' => 'User not found',
      ], 404);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'An error occurred while verifying the MPIN.',
        'error' => $e->getMessage(),
      ], 500);
    }
  }
  public function deleteUser($id)
  {
    try {

      $user = User::findOrFail($id);

      $user->delete();


      return response()->json([
        'message' => 'User deleted successfully.',
      ], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

      return response()->json([
        'message' => 'User not found.',
      ], 404);
    } catch (\Exception $e) {

      return response()->json([
        'message' => 'An error occurred while deleting the user.',
        'error' => $e->getMessage(),
      ], 500);
    }
  }
  public function toggleUserStatus($id, Request $request)
  {
    try {
      $validatedData = $request->validate([
        'is_active' => 'required|boolean',
      ]);

      $user = User::findOrFail($id);
      $user->update([
        'is_active' => $validatedData['is_active'],
      ]);
      $statusMessage = $validatedData['is_active'] ? 'activated' : 'deactivated';
      return response()->json([
        'message' => "User successfully $statusMessage.",
        'user' => $user,
      ], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      return response()->json([
        'message' => 'User not found.',
      ], 404);
    } catch (\Illuminate\Validation\ValidationException $e) {
      return response()->json([
        'message' => 'Validation error.',
        'errors' => $e->errors(),
      ], 422);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'An error occurred while updating the user status.',
        'error' => $e->getMessage(),
      ], 500);
    }
  }
  public function getTotalUserCount(Request $request)
  {
    try {

      $activeUsersCount = User::where('is_active', true)->count();
      $inactiveUsersCount = User::where('is_active', false)->count();
      $totalUsersCount = User::count();
      return response()->json([
        'message' => 'User counts retrieved successfully.',
        'total_users_count' => $totalUsersCount,
        'active_users_count' => $activeUsersCount,
        'inactive_users_count' => $inactiveUsersCount,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'An error occurred while fetching the user count.',
        'error' => $e->getMessage(),
      ], 500);
    }
  }
  public function deleteWalletBalance($id)
  {
    try {
      $user = User::findOrFail($id);

      $user->update([
        'wallet_balance' => 0,
      ]);

      return response()->json([
        'message' => 'Wallet balance deleted successfully.',
        'user' => [
          'id' => $user->id,
          'username' => $user->username,
          'wallet_balance' => $user->wallet_balance,
        ],
      ], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      return response()->json([
        'message' => 'User not found.',
      ], 404);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'An error occurred while deleting the wallet balance.',
        'error' => $e->getMessage(),
      ], 500);
    }
  }
}
