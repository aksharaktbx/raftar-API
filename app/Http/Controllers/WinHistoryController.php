<?php

namespace App\Http\Controllers;

use App\Models\WinHistory;
use Illuminate\Http\Request;

class WinHistoryController extends Controller
{
    // Fetch Win History
    public function index(Request $request)
    {
        $winHistories = WinHistory::with(['user', 'game'])->get();
        return response()->json(['data' => $winHistories]);
    }

    // Store Win History
    public function store(Request $request, $user_id)
    {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'game_name' => 'required|string',
                'result' => 'nullable|string',
                'open_time' => 'required|date_format:H:i:s',
                'close_time' => 'required|date_format:H:i:s',
            ]);

            // Create a new win history record
            $winHistory = WinHistory::create([
                'user_id' => $user_id,
                'game_name' => $validatedData['game_name'],
                'result' => $validatedData['result'] ?? null,
                'open_time' => $validatedData['open_time'],
                'close_time' => $validatedData['close_time'],
            ]);

            // Return success response
            return response()->json([
                'message' => 'Win history created successfully.',
                'win_history' => $winHistory,
            ], 201);
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'message' => 'An error occurred while creating the win history.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Delete Win History
    public function destroy($id)
    {
        try {
            $winHistory = WinHistory::find($id);

            if (!$winHistory) {
                return response()->json(['message' => 'Win history record not found.'], 404);
            }

            $winHistory->delete();

            return response()->json(['message' => 'Win history record deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the win history record.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
