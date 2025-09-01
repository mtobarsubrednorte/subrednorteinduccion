<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['quiz_id', 'question_text'];

    // Una pregunta pertenece a un quiz
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    // Una pregunta tiene muchas respuestas
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
