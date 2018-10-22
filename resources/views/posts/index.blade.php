@extends('layouts.app')

@section('content')
    <private-chat :user="{{ auth()->user() }}"></private-chat>
    {{-- <h1>Posts</h1>
    <ul class="nav flex-column">
        @foreach($posts as $post)
            <li class="nav-item">
                <a href="{{ route('posts.show', $post) }}" class="nav-link">
                    <div class="card">
                        <div class="card-body">
                            <span>Conversa com </span>
                            <span>{{ $post->user->id == Auth::id() ? $post->receiver->name : $post->user->name }}</span>
                            <div class="text-muted small">
                                <span>Em </span>
                                <span>{{ $post->question->title }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
        @endforeach
    </ul> --}}
@endsection