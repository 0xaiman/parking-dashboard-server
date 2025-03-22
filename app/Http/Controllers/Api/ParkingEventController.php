<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ParkingEvent;
use Illuminate\Http\Request;

class ParkingEventController extends Controller
{
    // List all parking events with related device, space and vehicle
    public function index()
    {
        return response()->json(ParkingEvent::with(['device', 'space', 'vehicle'])->get());
    }

    // Create a new parking event
    public function store(Request $request)
    {
        $request->validate([
            'device_id'      => 'required|exists:devices,id',
            'space_id'       => 'required|exists:parking_spaces,id',
            'event_time'     => 'required|date',
            'report_type'    => 'required|string',
            'occupancy'      => 'required|boolean',
            'duration'       => 'nullable|integer',
            'coordinate_x1'  => 'nullable|integer',
            'coordinate_y1'  => 'nullable|integer',
            'coordinate_x2'  => 'nullable|integer',
            'coordinate_y2'  => 'nullable|integer'
        ]);

        $event = ParkingEvent::create($request->all());
        return response()->json($event, 201);
    }

    // Show a specific parking event
    public function show(ParkingEvent $parkingEvent)
    {
        return response()->json($parkingEvent->load(['device', 'space', 'vehicle']));
    }

    // Update a parking event
    public function update(Request $request, ParkingEvent $parkingEvent)
    {
        $request->validate([
            'device_id'      => 'exists:devices,id',
            'space_id'       => 'exists:parking_spaces,id',
            'event_time'     => 'date',
            'report_type'    => 'string',
            'occupancy'      => 'boolean',
            'duration'       => 'nullable|integer',
            'coordinate_x1'  => 'nullable|integer',
            'coordinate_y1'  => 'nullable|integer',
            'coordinate_x2'  => 'nullable|integer',
            'coordinate_y2'  => 'nullable|integer'
        ]);

        $parkingEvent->update($request->all());
        return response()->json($parkingEvent);
    }

    // Delete a parking event
    public function destroy(ParkingEvent $parkingEvent)
    {
        $parkingEvent->delete();
        return response()->json(null, 204);
    }
}
