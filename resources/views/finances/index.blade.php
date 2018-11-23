@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="display-4">Finanças</h1>
        <div class="text-right">
            <h2 class="text-success">
                @budget(['budget' => $balance])
                @endbudget
            </h2>
            <span>Saldo Atual</span>
        </div>
    </div>
    <div class="row mt-3 mb-5">
        <div class="col text-right">
            <a href="#" class="btn btn-secondary">Opções de Saque</a>
            <a href="#" class="btn btn-success">Adicionar Crédito</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Data</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Usuário</th>
                            <th scope="col">Projeto</th>
                            <th scope="col" class="text-right">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($finances as $finance)
                            <tr>
                                <th scope="row">{{ $finance->created_at->format('d M Y') }}</th>
                                <td>@lang('finances.types.' . $finance->type)</td>
                                <td>
                                    <a href="{{ route('users.show', $finance->post->user) }}">
                                        {{ $finance->post->user->name }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('questions.show', $finance->post->talk->question) }}">
                                        {{ $finance->post->talk->question->title }}
                                    </a>
                                </td>
                                <td class="text-right">
                                    <span class="{{ $finance->type == App\Finance::types['received'] ? 'text-success' : 'text-danger' }}">
                                        @budget(['budget' => $finance->post->budget])
                                        @endbudget
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection