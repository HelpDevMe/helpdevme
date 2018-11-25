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
        <create-question></create-question>
    </div>
</div>
<div class="row">
    <div class="col">
        @foreach($questions as $question)
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col flex-grow-0">
                            <votes-question :initi-votes="{{ count($question->votes) }}" :question="{{ $question }}"></votes-question>
                        </div>
                        <div class="col">
                            <h3 class="h5">
                                <a href="{{ route('questions.show', $question) }}">{{ $question->title }}</a>
                            </h3>
                            @status(['status' => $question->status])
                            @endstatus
                            <p>{{ $question->body }}</p>
                        </div>
                    </div>
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
                            @foreach($question->tags as $tag)
                                <a href="{{ route('tags.show', $tag) }}" class="badge badge-primary">{{ $tag->title }}</a>
                            @endforeach
                        </div>
                    </div>
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
                </div>
                @formComment(['question' => $question])
                @endformComment
            </div>
        @endforeach
    </div>
</div>
@endsection