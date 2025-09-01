<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Quiz;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        $quiz = Quiz::first();

        $questions = [
            '¿Cuál es la temperatura normal del cuerpo humano?',
            '¿Cuántos litros de agua se recomienda tomar al día?',
            '¿Qué vitamina se obtiene principalmente del sol?'
        ];

        foreach ($questions as $q) {
            Question::create([
                'quiz_id' => $quiz->id,
                'question_text' => $q,
            ]);
        }
    }
}
