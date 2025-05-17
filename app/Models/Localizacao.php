<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localizacao extends Model
{
    protected $table = 'localizacoes';

    protected $fillable = [
        'bem_locavel_id',
        'cidade',
        'filial',
        'posicao',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class, 'bem_locavel_id');
    }
}
