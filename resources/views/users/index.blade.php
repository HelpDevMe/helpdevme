@extends('layouts.app')

@section('content')
    <div class="row">
        @foreach($users as $user)
            <div class="col-lg-6">
                <div class="card my-3 users-index-user">
                    <div class="card-body">
                        <div class="d-flex">
                            @include('shared.avatar', ['user' => $user])
                            <div class="px-3">
                                <h5 class="card-title">
                                    <a href="{{ route('users.show', $user) }}">{{ $user->name }}</a>
                                </h5>
                                <p class="card-text">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
