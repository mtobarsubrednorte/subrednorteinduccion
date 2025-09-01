<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Answer;
use App\Models\Question;

class AnswerSeeder extends Seeder
{
    public function run()
    {
        $questions = Question::all();

        // Pregunta 1
        $q1 = $questions[0];
        Answer::create(['question_id' => $q1->id, 'answer_text' => '36°C a 37.5°C', 'is_correct' => true]);
        Answer::create(['question_id' => $q1->id, 'answer_text' => '39°C a 40°C', 'is_correct' => false]);

        // Pregunta 2
        $q2 = $questions[1];
        Answer::create(['question_id' => $q2->id, 'answer_text' => '1 litro', 'is_correct' => false]);
        Answer::create(['question_id' => $q2->id, 'answer_text' => '2 litros', 'is_correct' => true]);

        // Pregunta 3
        $q3 = $questions[2];
        Answer::create(['question_id' => $q3->id, 'answer_text' => 'Vitamina D', 'is_correct' => true]);
        Answer::create(['question_id' => $q3->id, 'answer_text' => 'Vitamina C', 'is_correct' => false]);
    }
}