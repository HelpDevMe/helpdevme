@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col">
        <article>
            <header>
                <h1 class="display-4">{{ $question->title }}</h1>
            </header>
            @include('shared.questions.status', ['status' => $question->status])
            <p class="lead">{{ $question->body }}</p>
            <div class="row">
                <div class="col">
                    <p class="small">{{ count($question->comments()) }} resposta(s)</p>
                </div>
                <div class="col text-right">
                    <div class="small mb-3">
                        <span>{{ $question->created_at->diffForHumans() }} por</span>
                        <a href="{{ route('users.show', $question->user) }}">{{ $question->user->name }}</a>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    @foreach($question->tags as $tag)
                        <a href="{{ route('tags.show', $tag) }}" class="badge badge-primary">{{ $tag->title }}</a>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <div class="d-flex flex-column">
                                @each('shared.comments.show', $question->talks, 'talk')
                            </div>
                        </div>
                    </div>
                    @includeWhen($question->status == 0, 'shared.comments.create', ['question' => $question])
                </div>
            </div>
        </article>
    </div>
</div>
@endsection
