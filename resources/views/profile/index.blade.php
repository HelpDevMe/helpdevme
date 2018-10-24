@extends('layouts.app')

@section('content')
<ul class="nav nav-pills mb-5" id="pills-profile" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="pills-infos-tab" data-toggle="pill" href="#pills-infos" role="tab" aria-controls="pills-infos" aria-selected="true">Informações Pessoais</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="pills-password-tab" data-toggle="pill" href="#pills-password" role="tab" aria-controls="pills-password" aria-selected="false">Senha</a>
    </li>
</ul>
@if(session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif
<div class="tab-content" id="pills-profileContent">
    <div class="tab-pane fade show active" id="pills-infos" role="tabpanel" aria-labelledby="pills-infos-tab">
        <h2>Infos Pessoais</h2>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update', $user) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="form-group row">
                                <label for="avatar" class="col-md-4 col-form-label text-md-right">{{ __('Avatar') }}</label>
                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <div class="col-lg-2">
                                            <img class="img-fluid" src="/storage/avatars/{{ $user->avatar }}" alt="{{ $user->name }}" title="{{ $user->name }}">
                                        </div>
                                        <div class="col">
                                            <input type="file" class="form-control-file" name="avatar" id="avatarFile" aria-describedby="fileHelp">
                                            <small id="fileHelp" class="form-text text-muted">Please upload a valid image file. Size of image should not be more than 2MB.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
        
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name }}" required autofocus>
        
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
    </div>
    <div class="tab-pane fade" id="pills-password" role="tabpanel" aria-labelledby="pills-password-tab">
        <h2>Senha</h2>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update', $user) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach

                            <div class="form-group row">
                                <label for="current_password" class="col-md-4 col-form-label text-md-right">{{ __('Current Password') }}</label>
                                <div class="col-md-6">
                                    <input id="current_password" type="password" class="form-control" name="current_password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                                <div class="col-md-6">
                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
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
    </div>
</div>
@endsection