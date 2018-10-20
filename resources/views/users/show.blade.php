@extends('layouts.app')

@section('content')
    @if(session()->get('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    <h1>{{ $user->name }}</h1>
    <h2>{{ $user->email }}</h2>
    @can('update', $user)
        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">Editar Perfil</a>
    @endcan
@endsection