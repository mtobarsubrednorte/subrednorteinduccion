@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Quiz: {{ $quiz->title }}</h2>
    <p>Puntaje mínimo requerido: {{ $quiz->min_score }}%</p>

    <form action="{{ route('quiz.submit', $quiz->id) }}" method="POST">
        @csrf
        @foreach($quiz->questions as $question)
            <div class="card my-3">
                <div class="card-body">
                    <h5>{{ $question->text }}</h5>
                    @foreach($question->answers as $answer)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" 
                                   name="question_{{ $question->id }}" 
                                   value="{{ $answer->id }}">
                            <label class="form-check-label">{{ $answer->text }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Enviar respuestas</button>
    </form>
</div>
@endsection
