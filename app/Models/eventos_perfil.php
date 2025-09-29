<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class eventos_perfil extends Model
{
    protected $table = 'eventos_perfil';
    protected $fillable = [
        'id', 
        'description'
    ]; 

    
}
