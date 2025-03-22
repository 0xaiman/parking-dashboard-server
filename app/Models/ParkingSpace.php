<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingSpace extends Model
{
    protected $fillable = ['level_id', 'name', 'status'];

    public function level()
    {
        return $this->belongsTo(ParkingLevel::class, 'level_id');
    }

    public function events()
    {
        return $this->hasMany(ParkingEvent::class, 'space_id');
    }
}
