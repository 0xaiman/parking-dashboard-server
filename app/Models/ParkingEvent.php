<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingEvent extends Model
{
    protected $guarded = [];

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
