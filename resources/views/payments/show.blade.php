@extends('layouts.app')

@section('content')
    @if(session()->get('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    <h1 class="display-4">Depósito em garantia para</h1>
    <p class="lead">{{ $post->talk->question->title }}</p>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Total</h5>
                <span>
                    @budget(['budget' => $post->budget])
                    @endbudget
                </span>
            </div>
        </div>
    </div>
    <h2 class="text-muted h4 mt-5">Selecione o método de pagamento que deseja utilizar</h2>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Paypal</h4>
                <div class="text-right">
                    <div class="form-group">
                        <form action="{{ route('payments.paypal') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $post->id }}">
                            <input type="hidden" name="budget" value="{{ $post->budget }}">
                            <input type="hidden" name="title" value="{{ $post->talk->question->title }}">
                            <button type="submit" class="btn btn-success">Pagar</button>
                        </form>
                    </div>
                    <h5 class="text-success">
                        @budget(['budget' => $post->budget])
                        @endbudget
                    </h5>
                </div>
            </div>
        </div>
    </div>
@endsection