<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $fillable = ['modulo_id', 'pregunta', 'opciones', 'respuestas_correctas', 'perfiles_id'];

    protected $casts = [
        'opciones' => 'array',
        'respuestas_correctas' => 'array',
        'perfiles_id' => 'array',
    ];

    public function modulo()
    {
        return $this->belongsTo(Modulos::class);
    }
}

