<div class="py-3">
    <div>
        <a href="{{ route('users.show', $post->user) }}">{{ $post->user->name }}</a>
        {{ $post->body }}
        @if ($post->budget)
            <span class="badge badge-success">R$ {{ number_format($post->budget, 2, ',', '.') }}</span>
        @endif
    </div>
    <ul class="nav small">
        <li class="nav-item">
            <a href="#" class="nav-link">Curtir</a>
        </li>
        @if (Auth::check() && Auth::user()->can('view', $post->question))
            @if ($post->budget)
                <li class="nav-item">
                    <a href="#" class="nav-link text-success">Aceitar</a>
                </li>
            @endif
            <li class="nav-item">
                <a href="#" class="nav-link">Conversar</a>
            </li>
        @endif
    </ul>
</div>