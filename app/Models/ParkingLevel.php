<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ParkingSpace;

class ParkingLevel extends Model
{
    protected $fillable = ['name'];

    public function spaces()
    {
        return $this->hasMany(ParkingSpace::class, 'level_id');
    }
}
