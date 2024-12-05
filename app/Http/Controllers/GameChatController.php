<?php

namespace App\Http\Controllers;

use App\Models\GameChat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GameChatController extends Controller
{
    // Method to send a chat message (only chart_url is allowed)
    public function sendMessage(Request $request, $user_id)
    {
        // Validate the incoming request data (only chart_url now)
        $validatedData = $request->validate([
            'chart_url' => 'required|url',  // chart_url is now required
        ]);

        try {
            // Ensure the user exists
            $user = User::findOrFail($user_id);

            // Create the game chat message with the chart_url
            $gameChat = GameChat::create([
                'user_id' => $user_id,
                'chart_url' => $validatedData['chart_url'], // Save chart_url
            ]);

            return response()->json([
                'message' => 'Chat message sent successfully',
                'game_chat' => $gameChat,
            ], 201);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while sending the chat message.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Method to get all messages (chart_url) for a specific user
    public function getMessages($user_id)
    {
        try {
            // Fetch all chat messages for the user (based on user_id)
            $gameChats = GameChat::where('user_id', $user_id)->get();

            if ($gameChats->isEmpty()) {
                return response()->json([
                    'message' => 'No chat messages found for this user.',
                ], 404);
            }

            return response()->json([
                'game_chats' => $gameChats,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching the chat messages.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
