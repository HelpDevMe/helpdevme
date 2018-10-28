@extends('layouts.app')

@section('content')
    <section class="bg-white p-3 rounded">
        <private-chat :user="{{ auth()->user() }}" :owner_id="{{ $user_id ?? 0 }}"></private-chat>
    </section>
@endsection