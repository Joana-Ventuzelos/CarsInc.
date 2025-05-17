<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caracteristica extends Model
{
    protected $table = 'caracteristicas';

    protected $fillable = ['nome'];

    public $timestamps = false;

    public function cars()
    {
        return $this->belongsToMany(Car::class, 'bem_caracteristicas', 'caracteristica_id', 'bem_locavel_id');
    }
}
