<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    protected $fillable = ['modulo_id', 'file_path', 'file_type', 'original_name'];
    public function modulo()
    {
        return $this->belongsTo(Modulos::class);
    }
}
