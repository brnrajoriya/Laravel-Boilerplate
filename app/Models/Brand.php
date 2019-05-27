<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicles;

class Brand extends Model
{
    protected $fillable = [
        'name'
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
