@extends('layouts.app')

@section('content')
    <h1 class="display-4">Minhas Atividades como Freelancer</h1>
    @foreach($talks as $talk)
        {{ $talk->posts }}
        <div class="card">
            <div class="card-body">
                <address class="author">
                    <a rel="author" href="{{ route('users.show', $talk->user_id) }}">{{ $talk->user->name }}</a>
                </address>
                <h3 class="h5">
                    <a href="{{ route('questions.show', $talk->question) }}">{{ $talk->question->title }}</a>
                </h3>
                <p>{{ count($talk->question->talks) }} resposta(s)</p>
                <span class="badge badge-secondary">
                    @lang('questions.status.' . $talk->question->status_id)
                </span>
                {{-- <span class="badge badge-success">
                    @budget(['budget' => $post->budget])
                    @endbudget
                </span> --}}
            </div>
        </div>
    @endforeach
@endsection