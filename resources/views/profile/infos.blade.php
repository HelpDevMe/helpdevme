@php ($user = auth()->user())

@extends('layouts.app')

@section('content')

    <ul class="nav nav-pills mb-5">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('profile.infos') }}">Informações Pessoais</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('profile.password') }}">Senha</a>
        </li>
    </ul>

    @if(session()->get('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif

    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">
            {{ $error }}
        </div>
    @endforeach

    <h2 class="display-4 my-5">Informações Pessoais</h2>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', $user) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group row">
                            <label for="avatar" class="col-md-4 col-form-label text-md-right">{{ __('Avatar') }}</label>
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <div class="col-lg-2">
                                        <img class="img-fluid avatar" src="{{ asset('storage/img/avatars/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->avatar }}" title="{{ auth()->user()->avatar }}">
                                    </div>
                                    <div class="col">
                                        <input type="file" class="form-control-file" name="avatar" id="avatarFile">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name }}" required>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $user->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Salvar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
