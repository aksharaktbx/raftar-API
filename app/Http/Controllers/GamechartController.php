<?php 

namespace App\Http\Controllers;

use App\Models\Gamechart;
use Illuminate\Http\Request;

class GamechartController extends Controller
{
    // Get all game charts
    public function index()
    {
        // Get all game charts
        $data = GameChart::all();
    
        // Return the data wrapped in a 'data' key
        return response()->json(['data' => $data]);
    }



    // Store a new game chart
    public function store(Request $request)
    {
        $request->validate([
            'game_name' => 'required|string',
            'jodiUrl' => 'required|url',
            'panelUrl' => 'required|url',
        ]);

        $chart = Gamechart::create($request->all());

        return response()->json($chart, 201);
    }

    // Show a specific game chart
    public function show($id)
    {
        $chart = Gamechart::findOrFail($id);
        return response()->json($chart);
    }

    // Update a specific game chart
    public function update(Request $request, $id)
    {
        $request->validate([
            'game_name' => 'required|string',
            'jodiUrl' => 'required|url',
            'panelUrl' => 'required|url',
        ]);

        $chart = Gamechart::findOrFail($id);
        $chart->update($request->all());

        return response()->json($chart);
    }

    // Delete a specific game chart
   public function destroy($id)
{
    // Find the game chart by ID
    $chart = Gamechart::find($id);

    // If the chart does not exist, return a 404 response
    if (!$chart) {
        return response()->json(['error' => 'Game chart not found.'], 404);
    }

    // Delete the chart and return a success response
    $chart->delete();
    return response()->json(['success' => 'Game chart deleted successfully.'], 200);
}

}
