<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modulos extends Model
{
    protected $table = 'modulos';
    protected $fillable = ['title', 'description', 'duration', 'genilay_recursos_link1', 'genilay_recursos_link2', 'parent_id'];

    public function submodulos()
    {
        return $this->hasMany(Modulos::class, 'parent_id');
    }

    public function recursos()
    {
        return $this->hasMany(Recurso::class, 'modulo_id');
    }

    public function preguntas()
    {
        return $this->hasMany(Pregunta::class, 'modulo_id');
    }
}
