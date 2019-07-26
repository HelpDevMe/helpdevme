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
        <create-question :user="{{ auth()->check() ? auth()->user() : '{}' }}"></create-question>
    </div>
</div>
<div class="row">
    <div class="col">
        <list-new-questions></list-new-questions>
        @foreach($questions as $question)
        <div class="card mb-4 question">
            <div class="card-body">
                <div class="row">
                    <div class="col flex-grow-0">
                        <votes-question :initi-votes="{{ count($question->votes) }}" :question="{{ $question }}">
                        </votes-question>
                    </div>
                    <div class="col">
                        <h3 class="h5">
                            <a href="{{ route('questions.show', $question) }}">{{ $question->title }}</a>
                        </h3>
                        @include('shared.questions.status', ['status' => $question->status])
                        <p>{{ $question->body }}</p>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col text-right">
                        <div class="small mb-3">
                            <span>{{ $question->created_at->diffForHumans() }} por</span>
                            <a href="{{ route('users.show', $question->user) }}">
                                <div class="d-flex align-items-center justify-content-end py-2">
                                    <span class="mr-2">{{ $question->user->name }}</span>
                                    @include('shared.avatar', ['user' => $question->user])
                                </div>
                            </a>
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
                <comments :question="{{ $question }}"></comments>
                {{-- <div class="row">
                    <div class="col">
                        <div class="d-flex flex-column">
                            @each('shared.comments.show', $question->talks, 'talk')
                        </div>
                    </div>
                </div> --}}
            </div>
            {{-- @includeWhen($question->status == 0, 'shared.comments.create', ['question' => $question]) --}}
        </div>
        @endforeach
    </div>
</div>
@endsection
