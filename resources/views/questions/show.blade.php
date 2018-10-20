@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col">
        <article>
            <header>
                <h1>{{ $question->title }}</h1>
                <address class="author">
                    <a rel="author" href="{{ route('users.show', $question->user) }}">{{ $question->user->name }}</a>
                </address>
            </header>
            <p>{{ $question->body }}</p>
            <div class="row">
                <div class="col">
                    <hr>
                    <div class="mb-4">{{ count($question->posts) }} resposta(s)</div>
                    <div class="row">
                        <div class="col">
                            <ul class="nav flex-column small">
                                @foreach($question->posts as $post)
                                    <li class="nav-item py-3">
                                        <div>
                                            <a href="{{ route('users.show', $post->user) }}">{{ $post->user->name }}</a>
                                            {{ $post->answer }}
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
                    </div>
                    <hr>
                </div>
            </div>
        </article>
    </div>
</div>
@endsection