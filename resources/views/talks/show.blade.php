@extends('layouts.app')

@section('content')
    @php ($opposite = auth()->id() === $talk->user->id ? $talk->receiver : $talk->user)
    @if(session()->get('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    <h1>{{ $talk->question->title }}</h1>
    <private-chat :user="{{ auth()->user() }}" :talk="{{ $talk }}" :posts="{{ $talk->posts }}" :opposite="{{ $opposite }}"></private-chat>
@endsection
