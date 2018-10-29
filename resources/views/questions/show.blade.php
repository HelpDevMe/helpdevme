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
            <div>{{ $question->body }}</div>
            <div class="row">
                <div class="col">
                    <hr>
                    <p>{{ count($question->posts) }} resposta(s)</p>
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
                    @formComment(['question' => $question])
                    @endformComment
                </div>
            </div>
        </article>
    </div>
</div>
@endsection