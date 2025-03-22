<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'parking_event_id', 'license_plate', 'plate_color',
        'vehicle_type', 'vehicle_color', 'vehicle_brand'
    ];

    public function event()
    {
        return $this->belongsTo(ParkingEvent::class, 'parking_event_id');
    }
}
