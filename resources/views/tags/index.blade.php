@extends('layouts.app')

@section('content')
    <h1 class="display-4">Tags</h1>
    <div class="card-columns">
        @foreach ($tags as $tag)
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('tags.show', $tag) }}">
                        <h2 class="h5 card-title">{{ $tag->title }}</h2>
                    </a>
                    <div class="card-text">
                        <small class="text-muted">usada em {{ count($tag->questions) }} perguntas</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
