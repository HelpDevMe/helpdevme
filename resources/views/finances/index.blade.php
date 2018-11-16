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
                            <th scope="row">{{ $finance->created_at->format('d M Y') }}</th>
                            <td>{{ $finance->description }}</td>
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
                            <td>
                                @budget(['budget' => $finance->post->budget])
                                @endbudget
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection