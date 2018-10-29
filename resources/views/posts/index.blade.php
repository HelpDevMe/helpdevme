@extends('layouts.app')

@section('content')
    <h1>Listar todas conversas <span class="badge badge-secondary">{{ count($posts) }}</span></h1>
    @foreach($posts as $post)
        @php ($opposite = auth()->id() === $post->user->id ? $post->receiver : $post->user)
        <div class="card my-4">
            <div>
                de: {{ $post->user->name }}
            </div>
            <div>
                para: {{ $post->receiver->name }}
            </div>
            {{-- href="{{ route('posts.show', $post->question->id) }}" --}}
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-2 col-lg-1">
                        @avatar(['user' => $opposite])
                        @endavatar
                    </div>
                    <div class="col">
                        <div class="text-muted">{{ $post->body }}</div>
                        <p>
                            <span>Conversa com - </span>
                            {{ $opposite->name }}
                        </p>
                        <span class="small">Em - {{ $post->question->title }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection