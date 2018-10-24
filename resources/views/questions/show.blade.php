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
                            <div class="d-flex flex-column">
                                @foreach($question->posts as $post)
                                    @comment(['post' => $post])
                                    @endcomment
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </article>
    </div>
</div>
@endsection