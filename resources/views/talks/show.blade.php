@extends('layouts.app')

@section('content')
    <h1>{{ $talk->question->title }}</h1>
    @php ($opposite = auth()->id() === $talk->user->id ? $talk->receiver : $talk->user)
    <section class="bg-white p-3 rounded">
        <private-chat :user="{{ auth()->user() }}" :question="{{ $talk->question }}" :opposite="{{ $opposite }}"></private-chat>
    </section>
@endsection