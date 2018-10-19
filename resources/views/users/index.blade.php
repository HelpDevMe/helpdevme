@extends('layouts.app')

@section('content')
    <div class="card-columns">
        @foreach($users as $user)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><a href="{{ route('users.show', $user) }}">{{ $user->name }}</a></h5>
                    <p class="card-text">{{ $user->email }}</p>
                </div>
            </div>
        @endforeach
    </div>
@endsection