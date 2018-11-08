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
        <div class="card mb-5 shadow">
            <div class="card-body">
                <form method="post" action="{{ route('questions.store') }}">
                    <div class="form-group">
                        @csrf
                        <input type="text" class="form-control form-control-lg" name="title" placeholder="Como podemos te ajudar?" required/>
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
                    <h3 class="h5">
                        <a href="{{ route('questions.show', $question) }}">{{ $question->title }}</a>
                    </h3>
                    <span class="badge badge-secondary">
                        @lang('questions.status.' . $question->status_id)
                    </span>
                    <p>{{ $question->body }}</p>
                    <div class="row">
                        <div class="col text-right">
                            <div class="small">
                                <span>{{ $question->created_at->diffForHumans() }} por</span>
                                <a href="{{ route('users.show', $question->user) }}">{{ $question->user->name }}</a>
                            </div>
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