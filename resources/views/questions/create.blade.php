@extends('layouts.app')

@section('content')
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
            <div class="card-body">
                <form method="post" action="{{ route('questions.store') }}">
                    <div class="form-group">
                        @csrf
                        <label for="title">Título</label>
                        <input type="text" class="form-control" name="title" id="title" required/>
                    </div>
                    <div class="form-group">
                        <label for="body">Pergunta</label>
                        <textarea name="body" id="body" rows="10" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection