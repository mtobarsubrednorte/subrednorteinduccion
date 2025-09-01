<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description'];

    // Un módulo tiene muchos quizzes
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
