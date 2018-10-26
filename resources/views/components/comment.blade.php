<div class="py-3">
    <div class="mb-3">
        <a href="{{ route('users.show', $post->user) }}">{{ $post->user->name }}</a>
        <div>{{ $post->body }}</div>
        @if ($post->budget)
            <span class="badge badge-success">R$ {{ number_format($post->budget, 2, ',', '.') }}</span>
        @endif
    </div>
    <a href="#" class="btn btn-primary">Curtir</a>
    @if (Auth::check() && Auth::user()->can('view', $post->question))
        @if ($post->budget)
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#confirmModal{{ $post->id }}">Aceitar</button>
        @endif
        <a href="#" class="btn btn-secondary">Conversar</a>
    @endif
</div>
<!-- Modal -->
<div class="modal fade" id="confirmModal{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel{{ $post->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content" method="POST" action="{{ route('questions.accept', $question->id) }}">
            @csrf
            @method('PATCH')
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel{{ $post->id }}">Você está prestes a aceitar uma proposta para sua pergunta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="font-weight-bold">{{ $post->user->name }}</div>
                <div>{{ $post->body }}</div>
                <div class="text-success">R$ {{ number_format($post->budget, 2, ',', '.') }}</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Aceitar e Pagar</button>
            </div>
        </form>
    </div>
</div>