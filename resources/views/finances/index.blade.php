@extends('layouts.app')

@section('content')
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
<div class="d-flex justify-content-between align-items-center">
    <h1 class="display-4">Finanças</h1>
    <div class="text-right">
        <h2 class="text-success">
            @include('shared.budget', ['budget' => auth()->user()->amount])
        </h2>
        <span>Saldo Atual</span>
    </div>
</div>
<div class="row mt-3 mb-5">
    <div class="col text-right">
        <a href="{{ route('finances.fund') }}" class="btn btn-success">Adicionar Crédito</a>
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
                        <th scope="col">Status</th>
                        <th scope="col" class="text-right">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($finances as $finance)
                    @php ($opposite = auth()->id() === $finance->user->id ? $finance->receiver : $finance->user)
                    <tr>
                        <th scope="row">{{ $finance->created_at->format('d M Y') }}</th>
                        <td>@lang('finances.types.' . $finance->type)</td>
                        @if ($finance->post)
                        <td>
                            <a href="{{ route('users.show', $opposite) }}">
                                {{ $opposite->name }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('questions.show', $finance->post->talk->question) }}">
                                {{ $finance->post->talk->question->title }}
                            </a>
                        </td>
                        <td>@lang('questions.status.' . $finance->post->talk->question->status)</td>
                        @else
                        <td>
                            <a href="{{ route('users.show', $finance->user) }}">
                                {{ $finance->user->name }}
                            </a>
                        </td>
                        <td></td>
                        <td></td>
                        @endif
                        <td class="text-right">
                            <span
                                class="{{ $finance->type == App\Finance::types['received'] || $finance->type == App\Finance::types['fund'] ? 'text-success' : 'text-danger' }}">
                                @include('shared.budget', ['budget' => $finance->budget])
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
