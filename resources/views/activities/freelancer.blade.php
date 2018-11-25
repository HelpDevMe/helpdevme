@extends('layouts.app')

@section('content')
    
    <ul class="nav nav-pills mb-5">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('activities.client') }}">Cliente</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('activities.freelancer') }}">Freelancer</a>
        </li>
    </ul>

    <h1 class="display-4 my-5">Minhas Atividades como Freelancer</h1>
    
    @foreach($talks as $talk)
        
        @php ($question = $talk->question)

        <div class="card mb-4">
            <div class="card-body">
                <h3 class="h5">
                    <a href="{{ route('questions.show', $question) }}">{{ $question->title }}</a>
                </h3>
                @status(['status' => $question->status])
                @endstatus
                <hr>
                <div class="row">
                    <div class="col">
                        <p class="small">{{ count($question->comments()) }} resposta(s)</p>
                    </div>
                    <div class="col text-right">
                        <div class="small">
                            <span>Perguntado {{ $question->created_at->diffForHumans() }} por</span>
                            <a href="{{ route('users.show', $question->user) }}">{{ $question->user->name }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection