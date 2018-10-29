@extends('layouts.app')

@section('content')
    <div>auth_id: {{ auth()->id() }}</div>
    <div>user_id: {{ $post->user_id }}</div>
    <div>receiver_id: {{ $post->receiver_id }}</div>
    <section class="bg-white p-3 rounded">
        <private-chat :user="{{ auth()->user() }}" :question="{{ $post->question }}" :post="{{ $post }}"></private-chat>
    </section>
@endsection