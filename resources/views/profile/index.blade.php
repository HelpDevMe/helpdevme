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

@foreach ($errors->all() as $error)
    <div class="alert alert-danger">
        {{ $error }}
    </div>
@endforeach

<div class="tab-content" id="pills-profileContent">
    <div class="tab-pane fade show active" id="pills-infos" role="tabpanel" aria-labelledby="pills-infos-tab">
        @include('profile.children.infos')
    </div>
    <div class="tab-pane fade" id="pills-password" role="tabpanel" aria-labelledby="pills-password-tab">
        @include('profile.children.senha')
    </div>
</div>
@endsection