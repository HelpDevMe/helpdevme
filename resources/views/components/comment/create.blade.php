@cannot('comment', $question)
    <div class="card-footer">
        <form method="POST" action="{{ route('posts.store') }}">
            @csrf
            <input type="hidden" name="question_id" value="{{ $question->id }}">
            <input type="hidden" name="receiver_id" value="{{ $question->user->id }}">
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            <div class="form-row">
                <div class="col-lg">
                    <textarea name="body" placeholder="Escreva uma mensagem..." rows="1" class="form-control" required></textarea>
                </div>
                <div class="col-lg-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">R$</span>
                        </div>
                        <input type="number" class="form-control" name="budget" placeholder="Orçamento"/>
                    </div>
                </div>
                <div class="col-lg-2">
                    <button type="submit" class="btn btn-primary btn-block">Enviar</button>
                </div>
            </div>
        </form>
    </div>
@endcannot