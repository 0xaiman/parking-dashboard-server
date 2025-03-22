<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ParkingSpace;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;

class ParkingSpaceController extends Controller
{
    use ResponseAPI; // <-- Use the trait

    public function getParkingStatus()
    {
        try {
            // Retrieve all parking spaces with their status
            $parkingSpaces = ParkingSpace::select('id', 'level_id', 'status')->with('level:id,name')->get();

            return self::success("Parking occupancy status retrieved successfully!", $parkingSpaces, 200);
        } catch (\Exception $e) {
            return self::error("Failed to retrieve parking status!", $e->getMessage(), 500);
        }
    }

    public function clearAllParkingSpaces()
{
    try {
        // Update all occupied parking spaces to vacant
        ParkingSpace::where('status', 'occupied')->update(['status' => 'vacant']);

        return ResponseAPI::success("All parking spaces have been reset to vacant.", []);
    } catch (\Exception $e) {
        return ResponseAPI::error("Failed to reset parking spaces!", $e->getMessage(), 500);
    }
}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
