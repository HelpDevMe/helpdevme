@extends('layouts.app')

@section('content')
    <h1 class="display-4">Finanças</h1>
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">Data</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Freelancer</th>
                    <th scope="col">Projeto</th>
                    <th scope="col">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($finances as $finance)
                        <tr>
                            <th scope="row">{{ $finance->created_at }}</th>
                            <td>{{ $finance->description }}</td>
                            <td>{{ $finance->post->user->name }}</td>
                            <td>{{ $finance->post->budget }}</td>
                            <td>{{ $finance->post->budget }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection