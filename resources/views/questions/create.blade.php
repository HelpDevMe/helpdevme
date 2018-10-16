@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="nav flex-column">
                        @foreach ($errors->all() as $error)
                            <li class="nav-item">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card">
                <div class="card-header">Nova Pergunta</div>

                <div class="card-body">
                    <form method="post" action="{{ route('questions.store') }}">
                        <div class="form-group">
                            @csrf
                            <label for="title">Título</label>
                            <input type="text" class="form-control" name="title" id="title"/>
                        </div>
                        <div class="form-group">
                            <label for="body">Pergunta</label>
                            <textarea name="body" id="body" rows="10" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
