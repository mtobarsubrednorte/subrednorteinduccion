<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModuleProgress extends Model
{
    use HasFactory;

    // Columnas que se pueden asignar masivamente
    protected $fillable = [
        'user_id',
        'module_id',
        'status',
    ];

    // Opcional: si tu tabla tiene un nombre distinto al plural de la clase
    // protected $table = 'user_module_progress';
}