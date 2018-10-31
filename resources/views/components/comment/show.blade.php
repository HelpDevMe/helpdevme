@foreach ($talk->posts as $post)
    @if($post->comment === 1)
        <div class="py-3">
            <div class="mb-3">
                <a href="{{ route('users.show', $talk->user) }}">{{ $talk->user->name }}</a>
                <span>{{ $post->body }}</span>
                @if ($post->budget)
                    <span class="badge badge-success">
                        @budget(['budget' => $post->budget])
                        @endbudget
                    </span>
                @endif
            </div>
            @if (Auth::check() && $post->budget && Auth::user()->can('view', $talk->question))
                @can('update', $post)
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#confirmModal{{ $post->id }}">Aceitar</button>
                    <!-- Modal -->
                    <div class="modal fade" id="confirmModal{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel{{ $post->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form class="modal-content" method="POST" action="{{ route('posts.accept', $post->id) }}">
                                @csrf
                                @method('PATCH')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmModalLabel{{ $post->id }}">Você está prestes a aceitar uma proposta para sua pergunta</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="font-weight-bold">{{ $talk->user->name }}</div>
                                    <div>{{ $post->body }}</div>
                                    <div class="text-success">
                                        @budget(['budget' => $post->budget])
                                        @endbudget
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-success">Aceitar e Pagar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <a href="{{ route('talks.show', $talk) }}" class="btn btn-secondary">Conversar</a>
                @endcan
            @endif
        </div>
    @endif
@endforeach