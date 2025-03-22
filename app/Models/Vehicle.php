<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $guarded=[];

    public function event()
    {
        return $this->belongsTo(ParkingEvent::class, 'parking_event_id');
    }
}
