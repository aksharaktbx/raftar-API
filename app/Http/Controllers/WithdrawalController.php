<?php

namespace App\Http\Controllers;

use App\Models\TransactionHistory;
use App\Models\Withdrawal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class WithdrawalController extends Controller
{
    public function withdraw(Request $request, $userId)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
            'upi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $user = User::findOrFail($userId);

            if ($user->wallet_balance < $request->amount) {
                return response()->json([
                    'message' => 'Insufficient balance',
                ], 400);
            }

            $withdrawal = Withdrawal::create([
                'user_id' => $userId,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'upi' => $request->upi,
            ]);

            $user->wallet_balance -= $request->amount;
            $user->save();

            TransactionHistory::create([
                'user_id' => $userId,
                'transaction_type' => 'Withdraw',
                'amount' => $request->amount,
                'transaction_date' => Carbon::now(),
            ]);

            return response()->json([
                'message' => 'Withdrawal successful',
                'withdrawal' => $withdrawal,
                'wallet_balance' => $user->wallet_balance,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while processing the withdrawal.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getTotalWithdrawAmount(Request $request)
    {
        try {
            $totalWithdrawAmount = Withdrawal::sum('amount');

            return response()->json([
                'message' => 'Total withdrawal amount retrieved successfully.',
                'total_withdraw_amount' => $totalWithdrawAmount,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching the total withdrawal amount.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteAllWithdrawals()
    {
        try {
            // Delete all withdrawal records
            Withdrawal::truncate();

            // Optionally, reset all wallet balances for users (if needed)
            User::query()->update(['wallet_balance' => 0]);

            return response()->json([
                'message' => 'All withdrawal records deleted successfully and wallet balances reset.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting withdrawal records.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
