@extends('layouts.app')

@section('content')
    <h1 class="display-4">Minhas Atividades como Cliente</h1>
    @foreach($questions as $question)
        <div class="card">
            <div class="card-body">
                <address class="author">
                    <a rel="author" href="{{ route('users.show', $question->user) }}">{{ $question->user->name }}</a>
                </address>
                <h3 class="h5">
                    <a href="{{ route('questions.show', $question) }}">{{ $question->title }}</a>
                </h3>
                <p>{{ count($question->posts) }} resposta(s)</p>
                <span class="badge badge-secondary">
                    @lang('questions.status.' . $question->status_id)
                </span>
            </div>
        </div>
    @endforeach
@endsection