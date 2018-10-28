@extends('layouts.app')

@section('content')
    <h1 class="display-4">Minhas Atividades como Freelancer</h1>
    @foreach($posts as $post)
        <div class="card">
            <div class="card-body">
                <address class="author">
                    <a rel="author" href="{{ route('users.show', $post->receiver) }}">{{ $post->receiver->name }}</a>
                </address>
                <h3 class="h5">
                    <a href="{{ route('questions.show', $post->question) }}">{{ $post->question->title }}</a>
                </h3>
                <p>{{ count($post->question->posts) }} resposta(s)</p>
                <span class="badge badge-secondary">
                    @lang('questions.status.' . $post->question->status_id)
                </span>
                <span class="badge badge-success">
                    @budget(['budget' => $post->budget])
                    @endbudget
                </span>
            </div>
        </div>
    @endforeach
@endsection