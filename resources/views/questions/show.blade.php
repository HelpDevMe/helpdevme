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
        </article>
    </div>
</div>
@endsection