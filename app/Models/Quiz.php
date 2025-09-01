<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['module_id', 'title', 'min_score'];

    // Un quiz pertenece a un módulo
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    // Un quiz tiene muchas preguntas
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}