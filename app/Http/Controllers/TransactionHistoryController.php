<?php


namespace App\Http\Controllers;

use App\Models\TransactionHistory;
use Illuminate\Http\Request;

class TransactionHistoryController extends Controller
{
    public function getTransactionHistory($userId)
    {
        try {
            $transactions = TransactionHistory::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get(['id', 'transaction_type', 'amount', 'transaction_date', 'created_at']); // Specify 'transaction_date'

            return response()->json([
                'transactions' => $transactions
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching transaction history.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        try {
            // Fetch transactions with the associated user's username
            $transactions = TransactionHistory::with('user:id,username') // Load the user relation
                ->orderBy('created_at', 'desc')
                ->get(['id', 'user_id', 'transaction_type', 'amount', 'transaction_date', 'created_at']);
    
            // Map transactions to include username
            $transactions = $transactions->map(function ($transaction) {
                return [
                    'id' => $transaction->id,
                    'user_id' => $transaction->user_id,
                    'username' => $transaction->user->username ?? 'N/A', // Include username
                    'transaction_type' => $transaction->transaction_type,
                    'amount' => $transaction->amount,
                    'transaction_date' => $transaction->transaction_date,
                    'created_at' => $transaction->created_at,
                ];
            });
    
            return response()->json([
                'transactions' => $transactions
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching all transaction histories.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
}
