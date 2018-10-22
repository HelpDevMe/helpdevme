@extends('layouts.app')

@section('content')
    @foreach($posts as $post)
        @if ($loop->first)
            <h1>Mensagens com {{ $post->user->id == Auth::id() ? $post->receiver->name : $post->user->name }}</h1>
        @endif
        <div class="d-flex {{ $post->user->id == Auth::id() ? 'flex-row-reverse' : '' }}">
            <a href="#">{{ $post->user->name }}</a>
            <span class="mx-1">{{ $post->body }}</span>
        </div>
    @endforeach
    <form method="POST" action="{{ route('posts.store') }}" class="mt-3">
        @csrf
        <input type="hidden" name="question_id" value="{{ $post->question->id }}">
        <input type="hidden" name="receiver_id" value="{{ $post->user->id == Auth::id() ? $post->receiver->id : $post->user->id }}">
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
@endsection