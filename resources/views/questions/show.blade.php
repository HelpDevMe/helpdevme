@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col">
        <article>
            <header>
                <h1 class="display-4">{{ $question->title }}</h1>
                {{ $question->tags }}
            </header>
            <span class="badge badge-secondary">
                @lang('questions.status.' . $question->status)
            </span>
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
            <div class="row">
                <div class="col">
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
                    @formComment(['question' => $question])
                    @endformComment
                </div>
            </div>
        </article>
    </div>
</div>
@endsection