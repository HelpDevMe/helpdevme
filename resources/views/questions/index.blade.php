@extends('layouts.app')

@section('submenu')
    <nav class="navbar navbar-dark bg-white shadow-sm">
        <div class="container">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="btn btn-primary" href="{{ route('questions.create') }}">Criar Pergunta</a>
                </li>
            </ul>
        </div>
    </nav>
@endsection

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col">
                @if(session()->get('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                @foreach($questions as $question)
                    <blockquote class="blockquote">
                        <h2 class="h5">
                            <a href="{{ route('questions.show', $question->id) }}">{{ $question->title }}</a>
                        </h2>
                        <p>{{ $question->body }}</p>
                        <footer class="blockquote-footer">
                            <cite title="{{ $question->user->name }}">{{ $question->user->name }}</cite>
                        </footer>
                    </blockquote>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection