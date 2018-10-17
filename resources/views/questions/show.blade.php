@extends('layouts.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-1">
                    <a href="{{ route('questions.index') }}" class="btn btn-secondary">Voltar</a>
                </div>
                <div class="col">
                    <article>
                        <header>
                            <h1>{{ $question->title }}</h1>
                            <address class="author">
                                <a rel="author" href="#">{{ $question->user->name }}</a>
                            </address>
                        </header>
                        <p>{{ $question->body }}</p>
                    </article>
                </div>
            </div>
        </div>
    </section>
@endsection