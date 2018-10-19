@extends('layouts.app')

@section('submenu')
    <nav class="navbar navbar-dark bg-white shadow-sm">
        <div class="container">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="btn btn-success" href="{{ route('questions.create') }}">Criar Pergunta</a>
                </li>
            </ul>
        </div>
    </nav>
@endsection

@section('content')
<div class="row">
    <div class="col">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        @foreach($questions as $question)
            <blockquote class="blockquote mb-5 p-3 rounded border bg-white">
                <address class="author small">
                    <a rel="author" href="{{ route('users.show', $question->user) }}">{{ $question->user->name }}</a>
                </address>
                <h3>
                    <a href="{{ route('questions.show', $question) }}">{{ $question->title }}</a>
                </h3>
                <p>{{ $question->body }}</p>
                <div class="row">
                    <div class="col">
                        <hr>
                        <div class="row">
                            <div class="col">
                                <ul class="nav flex-column small">
                                    @foreach($question->posts as $post)
                                        <li class="nav-item py-3">
                                            <div>
                                                <a href="{{ route('users.show', $post->user) }}">{{ $post->user->name }}</a>
                                                {{ $post->answer }}
                                                @if ($post->budget)
                                                    <span class="badge badge-success">@money($post->budget)</span>
                                                @endif
                                            </div>
                                            <ul class="nav small">
                                                <li class="nav-item">
                                                    <a href="#" class="nav-link">Curtir</a>
                                                </li>
                                                @if ($post->budget)
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link">Aceitar</a>
                                                    </li>
                                                @endif
                                                <li class="nav-item">
                                                    <a href="#" class="nav-link">Conversar</a>
                                                </li>
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-lg-2 text-right">
                                <small>{{ count($question->posts) }} resposta(s)</small>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
                @if (Auth::id() != $question->user->id)
                    <form method="post" action="{{ route('posts.store') }}" class="mt-3">
                        @csrf
                        <input type="hidden" name="question_id" value="{{ $question->id }}">
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        @if ($errors->has('user_id'))
                            <div class="alert alert-danger small">
                                {!! $errors->first('user_id', 'É preciso fazer <a href="' . route('login') . '" class="alert-link">login</a>') !!}
                            </div>
                        @endif
                        <div class="form-group">
                            <textarea name="answer" placeholder="Escreva uma mensagem" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control" name="budget" placeholder="Orçamento"/>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                @endif
            </blockquote>
        @endforeach
    </div>
</div>
@endsection