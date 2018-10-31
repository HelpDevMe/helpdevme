@extends('layouts.app')

@section('content')
    @php ($opposite = auth()->id() === $talk->user->id ? $talk->receiver : $talk->user)
    <h1>{{ $talk->question->title }}</h1>
    <private-chat :user="{{ auth()->user() }}" :talk="{{ $talk }}" :posts="{{ $talk->posts }}" :opposite="{{ $opposite }}"></private-chat>
@endsection