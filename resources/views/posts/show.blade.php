@extends('layouts.app')

@section('content')
    @php ($post = $question->posts[0])
    @php ($opposite = auth()->id() === $post->user->id ? $post->receiver : $post->user)
    <section class="bg-white p-3 rounded">
        <private-chat :user="{{ auth()->user() }}" :question="{{ $question }}" :opposite="{{ $opposite }}"></private-chat>
    </section>
@endsection