@extends('layouts.app')

@section('content')

    <ul class="nav nav-pills mb-5">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('activities.client') }}">Cliente</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('activities.freelancer') }}">Freelancer</a>
        </li>
    </ul>

    <h1 class="display-4 my-5">Minhas Atividades como Cliente</h1>

    @foreach($questions as $question)
        <div class="card mb-4">
            <div class="card-body">
                <h3 class="h5">
                    <a href="{{ route('questions.show', $question) }}">{{ $question->title }}</a>
                </h3>
                @include('shared.questions.status', ['status' => $question->status])
                <hr>
                <div class="row">
                    <div class="col">
                        <p class="small">{{ count($question->comments()) }} resposta(s)</p>
                    </div>
                    <div class="col text-right">
                        <div class="small">{{ $question->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
