@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center users-show-user">
    @include('shared.avatar', ['user' => $user])
    <div class="px-3">
        <h1 class="display-4">{{ $user->name }}</h1>
        <p class="lead">{{ $user->email }}</p>
    </div>
</div>
@endsection
