<?php

namespace App\Http\Controllers;

use App\Models\SattaMatkaGame;
use Illuminate\Http\Request;

class SattaMatkaGameController extends Controller
{
  public function index($user_id)
  {
    if (!$user_id) {
      return response()->json(['error' => 'User ID is required'], 400);
    }
    $games = SattaMatkaGame::where('user_id', $user_id)->get();
    return response()->json($games);
  }
  public function store(Request $request)
  {
    try {
      // Validate the incoming data
      $validatedData = $request->validate([
        'open_time_formatted' => 'required',
        'close_time_formatted' => 'required',
        'market_id' => 'required',
        'market_name' => 'required',
        'aankdo_date' => 'required',
        'aankdo_open' => 'required',
        'aankdo_close' => 'required',
        'figure_open' => 'required',
        'figure_close' => 'required',
        'jodi' => 'required',
        'open_time' => 'required',
        'close_time' => 'required',
      ]);

      // Create the game
      $game = SattaMatkaGame::create($validatedData);

      // Remove unwanted fields from the response
      $game = $game->makeHidden(['updated_at', 'created_at', 'id']);

      return response()->json([
        'message' => 'Game created successfully.',
        'game' => $game,
      ], 201);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'An error occurred while creating the game.',
        'error' => $e->getMessage(),
      ], 500);
    }
  }
  public function getgamelist()
  {
    // Fetch all games
    $games = SattaMatkaGame::all();

    // Transform the collection to the desired structure
    $formattedGames = $games->map(function ($game) {
      return [


        'open_time_formatted' => $game->open_time_formatted,
        'close_time_formatted' => $game->close_time_formatted,
        'market_id' => $game->market_id,
        'market_name' => $game->market_name,
        'aankdo_date' => $game->aankdo_date,
        'aankdo_open' => $game->aankdo_open, // No decimal formatting
        'aankdo_close' => $game->aankdo_close, // No decimal formatting
        'figure_open' => $game->figure_open, // No decimal formatting
        'figure_close' => $game->figure_close, // No decimal formatting
        'jodi' => $game->jodi, // No decimal formatting
        'open_time' => $game->open_time,
        'close_time' => $game->close_time,
      ];
    });

    return response()->json(['data' => $formattedGames], 200);
  }
  public function getTotalGamesCount(Request $request)
  {
    try {
      $totalGamesCount = SattaMatkaGame::count();

      return response()->json([
        'message' => 'Total games count retrieved successfully.',
        'total_games_count' => $totalGamesCount,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'An error occurred while fetching the total games count.',
        'error' => $e->getMessage(),
      ], 500);
    }
  }
  public function destroy($id)
  {
    try {

      $game = SattaMatkaGame::find($id);

      if (!$game) {
        return response()->json([
          'message' => 'Game not found.',
        ], 404);
      }

      $game->delete();

      return response()->json([
        'message' => 'Game deleted successfully.',
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'An error occurred while deleting the game.',
        'error' => $e->getMessage(),
      ], 500);
    }
  }
  public function update(Request $request, $id)
  {
    try {
      // Validate the incoming data, including open_time and close_time
      $validatedData = $request->validate([
        'open_time_formatted' => 'required|string',
        'close_time_formatted' => 'required|string',
        'market_id' => 'required|string',
        'market_name' => 'required|string',
        'aankdo_date' => 'required|date',
        'aankdo_open' => 'required|numeric',
        'aankdo_close' => 'required|numeric',
        'figure_open' => 'required|numeric',
        'figure_close' => 'required|numeric',
        'jodi' => 'required|numeric',
        'open_time' => 'required|string',  // Validate open_time
        'close_time' => 'required|string', // Validate close_time
      ]);

      // Find the game by ID
      $game = SattaMatkaGame::find($id);

      if (!$game) {
        return response()->json([
          'message' => 'Game not found.',
        ], 404);
      }

      // Update the game with the validated data
      $game->update($validatedData);

      return response()->json([
        'message' => 'Game updated successfully.',
        'game' => $game,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'An error occurred while updating the game.',
        'error' => $e->getMessage(),
      ], 500);
    }
  }
}
