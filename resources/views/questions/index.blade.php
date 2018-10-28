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
        <div class="card mb-5">
            <div class="card-body">
                <form method="post" action="{{ route('questions.store') }}">
                    <div class="form-group">
                        @csrf
                        <input type="text" class="form-control" name="title" placeholder="Título" required/>
                    </div>
                    <div class="form-group">
                        <textarea name="body" class="form-control" placeholder="Pergunta" required></textarea>
                    </div>
                    <div class="form-row justify-content-end">
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-success btn-block">Enviar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        @foreach($questions as $question)
            <div class="card mb-4">
                <div class="card-body">
                    <address class="author">
                        <a rel="author" href="{{ route('users.show', $question->user) }}">{{ $question->user->name }}</a>
                    </address>
                    <h3>
                        <a href="{{ route('questions.show', $question) }}">{{ $question->title }}</a>
                    </h3>
                    <span class="badge badge-secondary">
                        @lang('questions.status.' . $question->status_id)
                    </span>
                    <p>{{ $question->body }}</p>
                    <div class="row">
                        <div class="col">
                            <hr>
                            <p>{{ count($question->posts) }} resposta(s)</p>
                            <div class="d-flex flex-column">
                                @foreach($question->posts as $post)
                                    @comment(['post' => $post])
                                    @endcomment
                                @endforeach
                            </div>
                            <hr>
                        </div>
                    </div>
                    @cannot('comment', $question)
                        <form method="POST" action="{{ route('posts.store') }}" class="mt-3">
                            @csrf
                            <input type="hidden" name="question_id" value="{{ $question->id }}">
                            <input type="hidden" name="receiver_id" value="{{ $question->user->id }}">
                            <div class="form-row align-items-center">
                                <div class="col-7 form-group">
                                    <textarea name="body" placeholder="Escreva uma mensagem" class="form-control" required></textarea>
                                </div>
                                <div class="col-3 form-group">
                                    <input type="number" class="form-control" name="budget" placeholder="Orçamento"/>
                                </div>
                                <div class="col form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Enviar</button>
                                </div>
                            </div>
                        </form>
                    @endcannot
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection