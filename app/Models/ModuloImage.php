<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuloImage extends Model
{
    protected $fillable = ['modulo_id', 'image_path', 'description'];

    public function modulo()
    {
        return $this->belongsTo(Modulos::class, 'modulo_id');
    }
}
