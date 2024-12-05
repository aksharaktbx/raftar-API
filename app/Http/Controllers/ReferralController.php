<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
   public function joinReferral(Request $request, $id)
{
    $validatedData = $request->validate([
        'referral_code' => 'required|string|exists:users,referral_code', // Ensure the referral code exists in the users table
    ]);

    try {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Check if the user has already joined using a referral code
        if (!is_null($user->referred_by)) {
            return response()->json([
                'status' => 400,
                'message' => 'User has already joined using a referral code.',
            ], 400);
        }

        // Find the referring user by referral code
        $referringUser = User::where('referral_code', $validatedData['referral_code'])->first();

        if ($referringUser->id === $user->id) {
            return response()->json([
                'status' => 400,
                'message' => 'Users cannot use their own referral code.',
            ], 400);
        }

        // Associate the referral
        $user->referred_by = $referringUser->id;
        $user->save();

        // Calculate the total number of users referred by the referring user
        $totalJoined = User::where('referred_by', $referringUser->id)->count();

        // Calculate the total earnings from referrals (example: assuming each referral earns 10 units)
        $totalEarn = $totalJoined * 10; // Adjust logic based on your application's rules

        return response()->json([
            'status' => 200,
            'message' => 'Referral code joined successfully.',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'referred_by' => $referringUser->username,
                'referral_code' => $referringUser->referral_code,
            ],
            'referral_summary' => [
                'total_joined' => $totalJoined,
                'total_earn' => $totalEarn,
            ],
        ], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'status' => 404,
            'message' => 'User not found.',
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 500,
            'message' => 'An error occurred while joining the referral code.',
            'error' => $e->getMessage(),
        ], 500);
    }
}
public function getReferralDetails($user_id)
{
    try {
        // Find the user by ID
        $referringUser = User::findOrFail($user_id);

        // Get the total number of users referred
        $totalJoined = User::where('referred_by', $referringUser->id)->count();

        // Calculate the total bonus earned (example: 10 units per referral)
        $totalEarned = $totalJoined * 10; // Adjust logic based on your application's referral rules

        // Fetch the list of referred users
        $referredUsers = User::where('referred_by', $referringUser->id)
            ->select('id', 'username', 'created_at')
            ->get();

        // Prepare the response
        return response()->json([
            'status' => 200,
            'message' => 'Referral details retrieved successfully.',
            'data' => [
                'id' => $referringUser->id,
                'username' => $referringUser->username,
                'referral_code' => $referringUser->referral_code,
                'total_joined' => $totalJoined,
                'total_earned' => $totalEarned,
               
            ],
        ], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'status' => 404,
            'message' => 'User not found.',
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 500,
            'message' => 'An error occurred while retrieving referral details.',
            'error' => $e->getMessage(),
        ], 500);
    }
}


}
