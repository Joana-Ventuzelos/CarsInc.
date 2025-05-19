<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoBem extends Model
{
    use HasFactory;

    protected $table = 'tipo_bens';

    protected $fillable = [
        'nome',
    ];

    public function marcas()
    {
        return $this->hasMany(Marca::class, 'tipo_bem_id');
    }
}
