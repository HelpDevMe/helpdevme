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
                {{ $question->tags }}
            </header>
            <div>{{ $question->body }}</div>
            <div class="row">
                <div class="col">
                    <hr>
                    <div class="row">
                        <div class="col">
                            <div class="d-flex flex-column">
                                @foreach($question->talks as $talk)
                                    @comment(['talk' => $talk])
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