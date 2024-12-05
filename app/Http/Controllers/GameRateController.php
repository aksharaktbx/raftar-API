<?php

namespace App\Http\Controllers;

use App\Models\GameRate;
use Illuminate\Http\Request;

class GameRateController extends Controller
{

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0',
        ]);


        $gameRate = GameRate::create([
            'name' => $validated['name'],
            'rate' => $validated['rate'],
        ]);


        return response()->json([
            'status' => 'success',
            'data' => $gameRate
        ], 201);
    }

    public function index()
    {
        $gameRates = GameRate::all();

        return response()->json([
            'status' => 'success',
            'data' => $gameRates
        ]);
    }


    public function show($id)
    {
        $gameRate = GameRate::find($id);

        if (!$gameRate) {
            return response()->json([
                'status' => 'error',
                'message' => 'Game rate not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $gameRate
        ]);
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0',
        ]);

        $gameRate = GameRate::find($id);

        if (!$gameRate) {
            return response()->json([
                'status' => 'error',
                'message' => 'Game rate not found'
            ], 404);
        }

        // Update the game rate
        $gameRate->update([
            'name' => $validated['name'],
            'rate' => $validated['rate'],
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $gameRate
        ]);
    }

    // Delete a game rate
    public function destroy($id)
    {
        $gameRate = GameRate::find($id);

        if (!$gameRate) {
            return response()->json([
                'status' => 'error',
                'message' => 'Game rate not found'
            ], 404);
        }

        // Delete the game rate
        $gameRate->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Game rate deleted successfully'
        ]);
    }
}
