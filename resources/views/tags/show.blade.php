@extends('layouts.app')

@section('content')
    <h1 class="display-4">{{ $tag->title }}</h1>
    <p class="lead">usada em {{ count($tag->questions) }} perguntas</p>
    <hr>
    @foreach ($tag->questions as $question)
        <div class="card my-4">
            <div class="card-body">
                <a href="{{ route('questions.show', $question) }}">
                    <h2 class="h5 card-title">{{ $question->title }}</h2>
                </a>
                <div class="row card-text text-muted">
                    <div class="col">
                        <small>{{ count($question->comments()) }} resposta(s)</small>
                    </div>
                    <div class="col text-right">
                        <div class="small">
                            <span>{{ $question->created_at->diffForHumans() }} por</span>
                            <a href="{{ route('users.show', $question->user) }}">{{ $question->user->name }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
