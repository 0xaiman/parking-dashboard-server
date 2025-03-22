<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = ['device_name', 'channel', 'resolution_w', 'resolution_h'];

    public function events()
    {
        return $this->hasMany(ParkingEvent::class);
    }
}
