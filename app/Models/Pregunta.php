<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $fillable = ['modulo_id', 'pregunta', 'respuesta'];
    public function modulo()
    {
        return $this->belongsTo(Modulos::class);
    }
}
