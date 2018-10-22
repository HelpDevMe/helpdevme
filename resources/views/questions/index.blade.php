@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="nav flex-column">
                    @foreach ($errors->all() as $error)
                        <li class="nav-item">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card mb-5">
            <div class="card-body">
                <form method="post" action="{{ route('questions.store') }}">
                    <div class="form-group">
                        @csrf
                        <input type="text" class="form-control" name="title" placeholder="Título" required/>
                    </div>
                    <div class="form-group">
                        <textarea name="body" class="form-control" placeholder="Pergunta" required></textarea>
                    </div>
                    <div class="form-row justify-content-end">
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-success btn-block">Enviar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
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
                                                {{ $post->body }}
                                                @if ($post->budget)
                                                    <span class="badge badge-success">R$ {{ number_format($post->budget, 2, ',', '.') }}</span>
                                                @endif
                                            </div>
                                            <ul class="nav small">
                                                <li class="nav-item">
                                                    <a href="#" class="nav-link">Curtir</a>
                                                </li>
                                                @if (Auth::check() && Auth::user()->can('view', $question))
                                                    @if ($post->budget)
                                                        <li class="nav-item">
                                                            <a href="#" class="nav-link text-success">Aceitar</a>
                                                        </li>
                                                    @endif
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link">Conversar</a>
                                                    </li>
                                                @endif
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
                @cannot('view', $question)
                    <form method="POST" action="{{ route('posts.store') }}" class="mt-3">
                        @csrf
                        <input type="hidden" name="question_id" value="{{ $question->id }}">
                        <input type="hidden" name="receiver_id" value="{{ $question->user->id }}">
                        <div class="form-row align-items-center">
                            <div class="col-7 form-group">
                                <textarea name="body" placeholder="Escreva uma mensagem" class="form-control" required></textarea>
                            </div>
                            <div class="col-3 form-group">
                                <input type="number" class="form-control" name="budget" placeholder="Orçamento"/>
                            </div>
                            <div class="col form-group">
                                <button type="submit" class="btn btn-primary btn-block">Enviar</button>
                            </div>
                        </div>
                    </form>
                @endcannot
            </blockquote>
        @endforeach
    </div>
</div>
@endsection