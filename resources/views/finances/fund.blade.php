@extends('layouts.app')

@section('content')
    <form action="{{ route('payments.paypal.fund') }}" method="POST">
        <h1>Adicionar crédito a minha conta</h1>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <label for="budget">Valor a adicionar</label>
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <span class="input-group-text">R$</span>
                            </div>
                            <input type="text" class="form-control" id="budget" name="budget" autofocus required/>
                        </div>
                    </div>
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
                        @csrf
                        <button type="submit" class="btn btn-success px-5">Pagar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection