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
        'image_path',
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function caracteristicas()
    {
        return $this->belongsToMany(\App\Models\Caracteristica::class, 'bem_caracteristicas', 'bem_locavel_id', 'caracteristica_id');
    }

    public function localizacoes()
    {
        return $this->hasMany(\App\Models\Localizacao::class, 'bem_locavel_id');
    }

    public function getCharacteristics()
    {
        $marca = \App\Models\Marca::where('nome', $this->brand)->first();
        if (!$marca) {
            return null;
        }
        $bensLocaveis = \App\Models\BensLocaveis::where('marca_id', $marca->id)
            ->where('modelo', $this->model)
            ->get();

        return [
            'marca' => $marca,
            'bens_locaveis' => $bensLocaveis,
        ];
    }
}
