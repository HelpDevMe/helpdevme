@extends('layouts.app')

@section('content')
    <h1>Talks</h1>
    @foreach($talks as $talk)
        @php ($opposite = auth()->id() === $talk->user->id ? $talk->receiver : $talk->user)
        <div class="card my-4">
            <div class="card-body">
                <a href="{{ route('talks.show', $talk) }}">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-lg-1">
                            @avatar(['user' => $opposite])
                            @endavatar
                        </div>
                        <div class="col">
                            <p>
                                <span>Conversa com - </span>
                                {{ $opposite->name }}
                            </p>
                            <span class="small">Em - {{ $talk->question->title }}</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    @endforeach
@endsection