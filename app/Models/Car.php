<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Rental;
use App\Models\Review;

class Car extends Model
{
    protected $fillable = [
        'brand',
        'model',
        'license_plate',
        'price_per_day',
        'is_available',
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
