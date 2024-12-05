<?php 

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function createNotification(Request $request, $user_id)
{
    $validatedData = $request->validate([
        'message' => 'required|string|max:255',
    ]);

    try {
        $user = User::findOrFail($user_id);

        $notification = Notification::create([
            'user_id' => $user_id,
            'message' => $validatedData['message'],
            'date' => now()->toDateString(),
            'time' => now()->toTimeString(),
        ]);

        return response()->json([
            'message' => 'Notification created successfully',
            'notification' => [
                'id' => $notification->id,
                'user_id' => $notification->user_id,
                'message' => $notification->message,
                'date' => $notification->date,
                'time' => $notification->time,
                'created_at' => $notification->created_at->toISOString(),
                'updated_at' => $notification->updated_at->toISOString(),
            ],
        ], 201);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'message' => 'User not found',
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'An error occurred while creating the notification.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function getNotifications($user_id)
{
    try {
        $notifications = Notification::where('user_id', $user_id)->get();

        if ($notifications->isEmpty()) {
            return response()->json([
                'message' => 'No notifications found for this user.',
            ], 404);
        }

        $formattedNotifications = $notifications->map(function ($notification) {
            return [
                'id' => $notification->id,
                'message' => $notification->message,
                'date' => $notification->date->format('Y-m-d'),
                'time' => $notification->time->format('H:i:s'),
                'created_at' => $notification->created_at->toISOString(),
                'updated_at' => $notification->updated_at->toISOString(),
            ];
        });

        return response()->json([
            'notifications' => $formattedNotifications,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'An error occurred while fetching notifications.',
            'error' => $e->getMessage(),
        ], 500);
    }
}




}
