<?php

namespace App\Http\Controllers;

use App\Models\TransactionHistory;
use App\Models\User;
use App\Models\AddFund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddFundController extends Controller
{
  public function addFund(Request $request, $userId)
  {
    $validator = Validator::make($request->all(), [
      'amount' => 'required|numeric|min:1',
      'utr_no' => 'required|string|max:255',
      'image' => 'nullable', // Allow both URLs or null
    ]);

    if ($validator->fails()) {
      return response()->json([
        'message' => 'Validation error',
        'errors' => $validator->errors(),
      ], 422);
    }

    try {
      DB::beginTransaction();

      $user = User::findOrFail($userId);

      $imagePath = null;

      // Check if the 'image' is a URL or uploaded file
      if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('addfund', 'public');
      } elseif ($request->image) {
        $imagePath = $request->image; // Directly use the URL
      }

      // Create the AddFund entry with status set to 'pending'
      $addFund = AddFund::create([
        'user_id' => $userId,
        'amount' => $request->amount,
        'utr_no' => $request->utr_no,
        'image' => $imagePath,
        'status' => 'pending', // Set the default status to 'pending'
      ]);

      DB::commit();

      return response()->json([
        'message' => 'Fund request added successfully. Pending admin approval.',
        'utr_no' => $request->utr_no,
        'amount' => $request->amount,
        'image_url' => $imagePath ? asset('storage/' . $imagePath) : $imagePath,
        'status' => 'pending',
      ], 200);
    } catch (\Exception $e) {
      DB::rollBack();

      Log::error('Error adding funds: ' . $e->getMessage());

      return response()->json([
        'message' => 'An error occurred while adding funds.',
        'error' => $e->getMessage(),
      ], 500);
    }
  }
  public function approveFund($addFundId)
  {
    try {
      DB::beginTransaction();

      $addFund = AddFund::findOrFail($addFundId);

      if ($addFund->status !== 'pending') {
        return response()->json([
          'message' => 'Fund is already approved or disapproved.',
        ], 400);
      }

      // Update the fund status to 'approved'
      $addFund->status = 'approved';
      $addFund->save();

      // Update wallet balance
      $user = User::findOrFail($addFund->user_id);
      $user->wallet_balance += $addFund->amount;
      $user->save();

      // Add to transaction history
      TransactionHistory::create([
        'user_id' => $addFund->user_id,
        'transaction_type' => 'Deposit',
        'amount' => $addFund->amount,
        'transaction_date' => Carbon::now(),
      ]);

      DB::commit();

      return response()->json([
        'message' => 'Fund approved successfully',
        'status' => $addFund->status,
        'wallet_balance' => $user->wallet_balance,
      ], 200);
    } catch (\Exception $e) {
      DB::rollBack();

      Log::error('Error approving funds: ' . $e->getMessage());

      return response()->json([
        'message' => 'An error occurred while approving the fund.',
        'error' => $e->getMessage(),
      ], 500);
    }
  }
  public function disapproveFund($addFundId)
  {
    try {
      $addFund = AddFund::findOrFail($addFundId);
      $addFund->status = 'disapproved';
      $addFund->save();

      return response()->json([
        'message' => 'Fund disapproved successfully',
        'status' => $addFund->status,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'An error occurred while disapproving the fund.',
        'error' => $e->getMessage(),
      ], 500);
    }
  }
  public function getTotalDepositAmount(Request $request)
  {
    try {
      $totalDepositAmount = AddFund::sum('amount');

      return response()->json([
        'message' => 'Total deposit amount retrieved successfully.',
        'total_deposit_amount' => $totalDepositAmount,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'An error occurred while fetching the total deposit amount.',
        'error' => $e->getMessage(),
      ], 500);
    }
  }
  public function getAllFundRequests(Request $request)
  {
    try {
      $status = $request->query('status');
      $fundRequests = AddFund::query();

      if ($status) {
        $fundRequests->where('status', $status);
      }

      $fundRequests = $fundRequests->with('user:id,username')
        ->orderBy('created_at', 'desc')
        ->get();

      $formattedFundRequests = $fundRequests->map(function ($fundRequest) {
        return [
          'id' => $fundRequest->id,
          'user_id' => $fundRequest->user_id,
          'amount' => $fundRequest->amount,
          'utr_no' => $fundRequest->utr_no,
          'image' => $fundRequest->image ? asset('storage/' . $fundRequest->image) : null,
          'created_at' => $fundRequest->created_at->toIso8601String(),
          'updated_at' => $fundRequest->updated_at->toIso8601String(),
          'status' => $fundRequest->status,
          'username' => $fundRequest->user->username ?? 'N/A',
        ];
      });

      return response()->json([
        'message' => 'Fund requests retrieved successfully.',
        'fund_requests' => $formattedFundRequests,
      ], 200);
    } catch (\Exception $e) {
      Log::error('Error fetching fund requests: ' . $e->getMessage());

      return response()->json([
        'message' => 'An error occurred while fetching fund requests.',
        'error' => $e->getMessage(),
      ], 500);
    }
  }

  public function deleteFund($addFundId)
  {
    try {
      // Find the AddFund record by ID
      $addFund = AddFund::findOrFail($addFundId);

      // Delete the AddFund record
      $addFund->delete();

      return response()->json([
        'message' => 'Fund request deleted successfully.',
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'An error occurred while deleting the fund request.',
        'error' => $e->getMessage(),
      ], 500);
    }
  }
}
