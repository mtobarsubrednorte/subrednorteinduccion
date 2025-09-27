<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modulos extends Model
{
    protected $table = 'modulos';
    protected $fillable = [
        'title',
        'description',
        'duration',
        'genilay_recursos_link1',
        'genilay_recursos_link2',
    ];
}
