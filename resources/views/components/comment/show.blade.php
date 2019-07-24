@foreach ($talk->posts as $post)
    @if($post->type === App\Post::types['comment'])
        <div class="py-3 border-top comment">
            <a href="{{ route('users.show', $talk->user) }}">
                @include('components.avatar', ['user' => $talk->user])
                <span>{{ $talk->user->name }}</span>
            </a>
            <span>{{ $post->body }}</span>
            @if ($post->budget)
                <span class="badge badge-success">
                    @budget(['budget' => $post->budget])
                    @endbudget
                </span>
            @endif
            @if (Auth::check() && $post->budget && Auth::user()->can('view', $talk->question))
                @can('update', $post)
                    <div class="pt-3">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#confirmModal{{ $post->id }}">Aceitar</button>
                        <!-- Modal -->
                        <div class="modal fade" id="confirmModal{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel{{ $post->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
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
                                        <a href="{{ route('posts.accept', $post->id) }}" class="btn btn-success">Aceitar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('talks.show', $talk) }}" class="btn btn-secondary">Conversar</a>
                    </div>
                @endcan
            @endif
        </div>
    @endif
@endforeach
