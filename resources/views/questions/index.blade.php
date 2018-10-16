@extends('layouts.app')

@section('submenu')
    <nav class="navbar navbar-dark bg-white shadow-sm">
        <div class="container">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="btn btn-primary" href="{{ route('questions.create') }}">Criar Pergunta</a>
                </li>
            </ul>
        </div>
    </nav>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            @foreach($questions as $question)
                <div class="card my-3 border-0 shadow-sm">
                    <div class="card-body">
                        <a href="#">
                            <h5>{{ $question->title }}</h5>
                        </a>
                        <p>{{ $question->body }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
