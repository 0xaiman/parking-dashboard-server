<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ParkingLevel;
use Illuminate\Http\Request;

class ParkingLevelController extends Controller
{
    // List all parking levels
    public function index()
    {
        return response()->json(ParkingLevel::with('spaces')->get());
    }

    // Create a new parking level
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $level = ParkingLevel::create($request->only('name'));
        return response()->json($level, 201);
    }

    // Show a specific parking level
    public function show(ParkingLevel $parkingLevel)
    {
        return response()->json($parkingLevel->load('spaces'));
    }

    // Update a parking level
    public function update(Request $request, ParkingLevel $parkingLevel)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $parkingLevel->update($request->only('name'));
        return response()->json($parkingLevel);
    }

    // Delete a parking level
    public function destroy(ParkingLevel $parkingLevel)
    {
        $parkingLevel->delete();
        return response()->json(null, 204);
    }
}


