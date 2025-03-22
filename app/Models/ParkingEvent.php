<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ParkingSpace;

class ParkingEvent extends Model
{
    protected $fillable = [
        'device_id', 'space_id', 'event_time', 'report_type',
        'occupancy', 'duration', 'coordinate_x1', 'coordinate_y1',
        'coordinate_x2', 'coordinate_y2'
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function space()
    {
        return $this->belongsTo(ParkingSpace::class, 'space_id');
    }

    public function vehicle()
    {
        return $this->hasOne(Vehicle::class, 'parking_event_id');
    }
}
