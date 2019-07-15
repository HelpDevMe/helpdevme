@extends('layouts.app')

@section('content')
<div class="row align-items-center">
    <div class="col-lg-2">
        <img class="img-fluid avatar" src="{{ asset('storage/img/avatars/' . $user->avatar) }}"
            alt="{{ $user->avatar }}" title="{{ $user->avatar }}">
    </div>
    <div class="col">
        <h1 class="display-4">{{ $user->name }}</h1>
        <p class="lead">{{ $user->email }}</p>
    </div>
</div>
@endsection