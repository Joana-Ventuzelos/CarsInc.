<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationHistory extends Model
{
    protected $table = 'rentals';  // Link to rentals table

    protected $fillable = [
        'user_id',
        'car_id',
        'start_date',
        'end_date',
        'total_price',
        'status',
    ];

    protected $dates = ['start_date', 'end_date'];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
