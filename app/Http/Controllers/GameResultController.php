<?php

namespace App\Http\Controllers;

use App\Models\GameResult;
use App\Models\SattaMatkaGame;
use Illuminate\Http\Request;

class GameResultController extends Controller
{
  public function store(Request $request)
  {

    $validator = \Validator::make($request->all(), [
      'market_id' => 'required|exists:satta_matka_games,id',
      'open' => 'nullable|string|max:255',
      'jodi' => 'nullable|string|max:255',
      'close' => 'nullable|string|max:255',
    ]);
    if ($validator->fails()) {

      $errorMessage = $validator->errors()->first();


      return response()->json($errorMessage, 422);
    }

    $result = GameResult::create($request->only(['market_id', 'open', 'jodi', 'close']));
    $marketName = SattaMatkaGame::find($request->market_id)->market_name;
    return response()->json([
      'message' => 'Game result added successfully',
      'data' => [
        'market_name' => $marketName,
        'open' => $result->open,
        'jodi' => $result->jodi,
        'close' => $result->close,
        'updated_at' => $result->updated_at,
        'created_at' => $result->created_at,
        'id' => $result->id,
      ],
    ], 201); // HTTP status code 201 for successful creation
  }

public function index(Request $request)
{
    $results = GameResult::with('market:id,market_name')->get();

    $formattedResults = $results->map(function ($result) {
        $openDigitsSum = array_sum(str_split($result->open));
        $figureOpen = $openDigitsSum % 10;

        $closeDigitsSum = array_sum(str_split($result->close));
        $figureClose = $closeDigitsSum % 10;

        $jodi = $figureOpen . $figureClose;

        try {
            // Update SattaMatkaGame with calculated values and set `open` to `aankdo_open`
            $updated = SattaMatkaGame::where('market_id', $result->market_id)->update([
                'figure_open' => $figureOpen,
                'figure_close' => $figureClose,
                'jodi' => $jodi,
                'open' => $result->aankdo_open, // Update 'open' field with 'aankdo_open'
            ]);

            if (!$updated) {
                \Log::warning("No rows updated for SattaMatkaGame with market_id: " . $result->market_id);
            }
        } catch (\Exception $e) {
            \Log::error("Error updating SattaMatkaGame: " . $e->getMessage());
        }

        return [
            'id' => $result->id,
            'market_id' => $result->market_id,
            'market_name' => optional($result->market)->market_name,
            'open' => $result->open,
            'figure_open' => $figureOpen,
            'figure_close' => $figureClose,
            'jodi' => $jodi,
            'created_at' => $result->created_at,
            'updated_at' => $result->updated_at,
        ];
    });

    return response()->json([
        'message' => 'Game results retrieved successfully',
        'data' => $formattedResults,
    ], 200);
}

}
