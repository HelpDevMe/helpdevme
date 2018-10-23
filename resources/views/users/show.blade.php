@extends('layouts.app')

@section('content')
    @if(session()->get('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    <div class="row align-items-center">
        <div class="col-lg-2">
            <img class="img-fluid rounded-circle" src="/storage/avatars/{{ $user->avatar }}" alt="{{ $user->name }}" title="{{ $user->name }}">
        </div>
        <div class="col">
            <h1 class="display-4">{{ $user->name }}</h1>
            <p class="lead">{{ $user->email }}</p>
            @can('update', $user)
                <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">Editar Perfil</a>
            @endcan
        </div>
    </div>
@endsection