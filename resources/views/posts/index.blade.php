@extends('layouts.app')

@section('content')
    <section class="bg-white p-3 rounded">
        <private-chat :user="{{ auth()->user() }}"></private-chat>
    </section>
@endsection