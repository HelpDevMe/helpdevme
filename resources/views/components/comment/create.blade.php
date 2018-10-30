@cannot('comment', $question)
    <form method="POST" action="{{ route('posts.store') }}" class="mt-3">
        @csrf
        <input type="hidden" name="question_id" value="{{ $question->id }}">
        <input type="hidden" name="receiver_id" value="{{ $question->user->id }}">
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        <div class="form-row align-items-center">
            <div class="col-7 form-group">
                <textarea name="body" placeholder="Escreva uma mensagem" class="form-control" required></textarea>
            </div>
            <div class="col-3 form-group">
                <input type="number" class="form-control" name="budget" placeholder="Orçamento"/>
            </div>
            <div class="col form-group">
                <button type="submit" class="btn btn-primary btn-block">Enviar</button>
            </div>
        </div>
    </form>
@endcannot