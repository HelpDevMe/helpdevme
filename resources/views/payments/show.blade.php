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
    <h2 class="text-muted font-weight-light h4 mt-5">Selecione o método de pagamento que deseja utilizar</h2>
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="m-0">Paypal</h4>
                </div>
                <div class="col text-center">
                    <!-- PayPal Logo -->
                    <a href="https://www.paypal.com/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;"><img src="https://www.paypalobjects.com/digitalassets/c/website/marketing/na/us/logo-center/9_bdg_secured_by_pp_2line.png" border="0" alt="Secured by PayPal"></a>
                </div>
                <div class="col text-right">
                    <div class="form-group">
                        <form action="{{ route('payments.paypal.pay') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $post->id }}">
                            <input type="hidden" name="budget" value="{{ $post->budget }}">
                            <input type="hidden" name="title" value="{{ $post->talk->question->title }}">
                            <button type="submit" class="btn btn-success px-5">Pagar</button>
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