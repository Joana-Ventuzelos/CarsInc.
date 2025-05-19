<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BensLocaveis extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'bens_locaveis';

    protected $fillable = [
        'marca_id',
        'modelo',
        'registo_unico_publico',
        'cor',
        'numero_passageiros',
        'combustivel',
        'numero_portas',
        'transmissao',
        'ano',
        'manutencao',
        'preco_diario',
        'observacao',
    ];

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }

    public function car()
    {
        return $this->belongsTo(\App\Models\Car::class, 'car_id');
    }
}
