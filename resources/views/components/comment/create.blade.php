@cannot('comment', $question)
    <div class="card-footer">
        <form method="POST" action="{{ route('posts.store') }}">
            @csrf
            <input type="hidden" name="question_id" value="{{ $question->id }}">
            <input type="hidden" name="receiver_id" value="{{ $question->user->id }}">
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            <div class="form-row align-items-center">
                <div class="input-group">
                    <textarea name="body" placeholder="Escreva uma mensagem..." rows="1" class="form-control" required></textarea>
                    <input type="number" class="form-control col-2" name="budget" placeholder="Orçamento"/>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary btn-block">Enviar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endcannot