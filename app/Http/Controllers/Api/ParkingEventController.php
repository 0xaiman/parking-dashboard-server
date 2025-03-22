<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParkingEvent;
use App\Models\ParkingSpace;
use App\Models\Device;
use App\Models\Vehicle;
use Carbon\Carbon;
use App\Traits\ResponseAPI; // <-- Import the trait

class ParkingEventController extends Controller
{
    use ResponseAPI; // <-- Use the trait

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $parkingEvents = ParkingEvent::paginate($perPage);

        return $this->success("Parking events retrieved successfully", $parkingEvents);
    }

    public function store(Request $request)
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'device_id'        => 'required|exists:devices,id',
                'space_id'         => 'required|exists:parking_spaces,id',
                'event_time'       => 'required|date',
                'report_type'      => 'required|string',
                'occupancy'        => 'required|boolean',
                'duration'         => 'nullable|integer',
                'coordinate_x1'    => 'nullable|integer',
                'coordinate_y1'    => 'nullable|integer',
                'coordinate_x2'    => 'nullable|integer',
                'coordinate_y2'    => 'nullable|integer',
                'license_plate'    => 'nullable|string|max:15',
                'plate_color'      => 'nullable|string|max:20',
                'vehicle_type'     => 'nullable|string|max:20',
                'vehicle_color'    => 'nullable|string|max:20',
                'vehicle_brand'    => 'nullable|string|max:50',
                'owner'            => 'nullable|string|max:100',
                'membership_status'=> 'nullable|in:staff,guest,member',
            ]);
    
            // Find the parking space
            $parkingSpace = ParkingSpace::findOrFail($validated['space_id']);
    
            // Check if the parking space is already occupied
            if ($parkingSpace->status === 'occupied' && $validated['occupancy']) {
                return self::error("Parking space is already occupied!", null, 400);
            }
    
            // Register the parking event
            $parkingEvent = ParkingEvent::create([
                'device_id'     => $validated['device_id'],
                'space_id'      => $validated['space_id'],
                'event_time'    => Carbon::parse($validated['event_time']),
                'report_type'   => $validated['report_type'],
                'occupancy'     => $validated['occupancy'],
                'duration'      => $validated['duration'] ?? 0,
                'coordinate_x1' => $validated['coordinate_x1'] ?? null,
                'coordinate_y1' => $validated['coordinate_y1'] ?? null,
                'coordinate_x2' => $validated['coordinate_x2'] ?? null,
                'coordinate_y2' => $validated['coordinate_y2'] ?? null,
            ]);
    
            // Update parking space status
            $parkingSpace->status = $validated['occupancy'] ? 'occupied' : 'vacant';
            $parkingSpace->save();
    
            // If a vehicle is detected, register it
            if (!empty($validated['license_plate'])) {
                $vehicle = Vehicle::updateOrCreate(
                    ['license_plate' => $validated['license_plate']],  // Find by license_plate
                    [
                        'plate_color'      => $validated['plate_color'] ?? 'Unknown',
                        'owner'            => $validated['owner'] ?? 'Unknown',
                        'membership_status'=> $validated['membership_status'] ?? 'guest',
                        'vehicle_type'     => $validated['vehicle_type'] ?? 'Unknown',
                        'vehicle_color'    => $validated['vehicle_color'] ?? 'Unknown',
                        'vehicle_brand'    => $validated['vehicle_brand'] ?? null,
                    ]
                );
                
    
                // Increment visit count for returning vehicles
                $vehicle->increment('visit_count');
    
                // Link vehicle to parking event
                $parkingEvent->update(['vehicle_id' => $vehicle->id]);
            }
    
            return self::success("Parking event registered successfully!", $parkingEvent, 201);
    
        } catch (\Exception $e) {
            return self::error("Failed to register parking event!", $e->getMessage(), 500);
        }
    }
    

  

    
}
