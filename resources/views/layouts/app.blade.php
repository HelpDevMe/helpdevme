<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- User ID -->
    <meta name="user-id" content="{{ Auth::id() }}">

    <title>{{ config('app.name', 'Help Dev') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-light h-100">
    <div id="app" class="d-flex flex-column justify-content-between h-100">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('index') }}">
                    @svg('logo-helpdev')
                    <span class="ml-1">{{ config('app.name', 'HelpDev.me') }}</span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="@lang('layouts.navbar.toggle_navigation')">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('questions.index') }}">@lang('layouts.navbar.questions')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.index') }}">@lang('layouts.navbar.users')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tags.index') }}">@lang('layouts.navbar.tags')</a>
                        </li>
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">@lang('layouts.navbar.login')</a>
                        </li>
                        <li class="nav-item">
                            @if (Route::has('register'))
                            <a class="nav-link" href="{{ route('register') }}">@lang('layouts.navbar.register')</a>
                            @endif
                        </li>
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown"
                                class="nav-link dropdown-toggle"
                                title="Minha Conta"
                                href="#"
                                role="button"
                                data-toggle="dropdown"
                                data-tooltip="tooltip"
                                aria-haspopup="true"
                                aria-expanded="false"
                                data-placement="bottom"
                            >
                                @include('shared.avatar', ['user' => auth()->user()])
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                <p class="text-muted px-4">Olá, <b>{{ Auth::user()->name }}</b>!</p>

                                <a class="dropdown-item" href="{{ route('profile.infos') }}">
                                    @lang('layouts.navbar.profile')
                                </a>

                                <a class="dropdown-item" href="{{ route('finances.index') }}">
                                    @lang('layouts.navbar.finances')
                                </a>

                                <div class="dropdown-divider"></div>

                                <small class="px-4 text-muted">Minhas Atividades</small>

                                <a class="dropdown-item" href="{{ route('activities.client') }}">Como Cliente</a>
                                <a class="dropdown-item" href="{{ route('activities.freelancer') }}">Como Freelancer</a>

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item text-muted" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                    @lang('layouts.navbar.logout')
                                </a>

                                <form id="logout-form" class="d-none" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdownTalks"
                                role="button"
                                data-toggle="dropdown"
                                data-tooltip="tooltip"
                                data-placement="bottom"
                                aria-haspopup="true"
                                aria-expanded="false"
                                class="nav-link dropdown-toggle"
                                href="#"
                                title="@lang('layouts.navbar.posts')"
                            >
                                <i class="fas fa-comments fa-2x"></i>
                            </a>
                            <div
                                class="dropdown-menu dropdown-menu-right my-0 py-0"
                                aria-labelledby="navbarDropdownTalks">
                                <list-chat></list-chat>
                                <a class="btn btn-link btn-block" href="{{ route('talks.index') }}">Ver Tudo</a>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main role="main">
            <section class="py-5">
                <div class="container">
                    @yield('content')
                </div>
            </section>
        </main>
        <footer>
            <div class="container">
                <div class="d-flex w-100 border-top py-3 justify-content-center align-items-center">
                    @svg('logo-secondary-helpdev')
                    <span class="ml-3">© 2019 Help Dev</span>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
