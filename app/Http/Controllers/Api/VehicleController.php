<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    use ResponseAPI;
    // List all vehicles with associated parking event
    public function getAllVehicles()
{
    try {
        // Retrieve all vehicles
        $vehicles = Vehicle::all();

        return ResponseAPI::success("Vehicle data retrieved successfully!", $vehicles);
    } catch (\Exception $e) {
        return ResponseAPI::error("Failed to retrieve vehicle data!", $e->getMessage(), 500);
    }
}

    // Create a new vehicle record linked to a parking event
    public function store(Request $request)
    {
        $request->validate([
            'parking_event_id' => 'required|exists:parking_events,id',
            'license_plate'    => 'required|string|max:15',
            'plate_color'      => 'required|string|max:20',
            'vehicle_type'     => 'required|string|max:20',
            'vehicle_color'    => 'required|string|max:20',
            'vehicle_brand'    => 'nullable|string|max:50'
        ]);

        $vehicle = Vehicle::create($request->all());
        return response()->json($vehicle, 201);
    }

    // Show a specific vehicle
    public function show(Vehicle $vehicle)
    {
        return response()->json($vehicle->load('event'));
    }

    // Update a vehicle record
    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'license_plate'    => 'string|max:15',
            'plate_color'      => 'string|max:20',
            'vehicle_type'     => 'string|max:20',
            'vehicle_color'    => 'string|max:20',
            'vehicle_brand'    => 'nullable|string|max:50'
        ]);

        $vehicle->update($request->all());
        return response()->json($vehicle);
    }

    // Delete a vehicle record
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return response()->json(null, 204);
    }
}
