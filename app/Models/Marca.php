<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    protected $table = 'marca';

    protected $fillable = [
        'tipo_bem_id',
        'nome',
        'observacao',
    ];

    public function tipoBem()
    {
        return $this->belongsTo(TipoBem::class, 'tipo_bem_id');
    }

    public function bensLocaveis()
    {
        return $this->hasMany(BensLocaveis::class, 'marca_id');
    }
}
