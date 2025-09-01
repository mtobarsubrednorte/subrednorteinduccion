<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\QuizAttempt;

class QuizController extends Controller {
    public function show(Quiz $quiz) {
        $quiz->load('questions.answers');
        return view('quiz.show', compact('quiz'));
    }

    public function submit(Request $request, Quiz $quiz) {
        $user = Auth::user();
        $score = 0;
        $total = $quiz->questions->count();

        foreach ($quiz->questions as $question) {
            $answer_id = $request->input('question_'.$question->id);
            if ($answer_id) {
                $answer = $question->answers->where('id', $answer_id)->first();
                if ($answer && $answer->is_correct) {
                    $score++;
                }
            }
        }

        $percentage = $total > 0 ? round(($score / $total) * 100) : 0;
        $passed = $percentage >= $quiz->min_score;

        QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'user_id' => $user->id,
            'score' => $percentage,
            'passed' => $passed,
        ]);

        return redirect()->route('quiz.show', $quiz->id)
                         ->with('success', 'Resultado: '.$percentage.'%. '.($passed ? 'Aprobado' : 'No aprobado'));
    }
}