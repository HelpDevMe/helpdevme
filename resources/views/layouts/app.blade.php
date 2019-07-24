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
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32.228"
                        height="32.228" viewBox="0 0 32.228 32.228">
                        <defs>
                            <clipPath id="a">
                                <rect width="32.228" height="32.228" transform="translate(93)" fill="#fff"
                                    stroke="#707070" stroke-width="1" />
                            </clipPath>
                        </defs>
                        <g transform="translate(-93)" clip-path="url(#a)">
                            <g transform="translate(94.194)">
                                <path
                                    d="M18.624,0A14.937,14.937,0,0,0,3.7,14.92a.6.6,0,0,0,1.194,0,2.984,2.984,0,1,1,5.968,0,.6.6,0,0,0,1.194,0,2.984,2.984,0,1,1,5.968,0,.6.6,0,1,0,1.194,0,2.984,2.984,0,1,1,5.968,0,.6.6,0,0,0,1.194,0,2.984,2.984,0,1,1,5.968,0,.6.6,0,0,0,1.194,0A14.936,14.936,0,0,0,18.624,0Z"
                                    transform="translate(-3.704)" fill="#e7e5ef" />
                                <path
                                    d="M32.708,13.253a4.18,4.18,0,0,0-3.581,2.028,4.176,4.176,0,0,0-7.162,0,4.176,4.176,0,0,0-7.162,0,4.173,4.173,0,0,0-6.17-1.127,13.729,13.729,0,0,1,26.663,0A4.156,4.156,0,0,0,32.708,13.253Z"
                                    transform="translate(-7.045 -2.51)" fill="#314e55" />
                                <path d="M48.622,83.57a2.089,2.089,0,1,0-2.089,2.089A2.091,2.091,0,0,0,48.622,83.57Z"
                                    transform="translate(-31.315 -55.222)" fill="#e7e5ef" />
                                <path d="M.9,0A.9.9,0,1,1,0,.9.9.9,0,0,1,.9,0Z" transform="translate(14.323 27.453)"
                                    fill="#314e55" />
                                <g transform="translate(1.194 15.729)">
                                    <path
                                        d="M56.266,89.064l-2.387,2.387a.6.6,0,1,0,.844.844l2.387-2.387a.6.6,0,1,0-.844-.844Z"
                                        transform="translate(-38.783 -75.971)" fill="#e7e5ef" />
                                    <path d="M38.056,89.064a.6.6,0,0,0-.844.844L39.6,92.295a.6.6,0,1,0,.844-.844Z"
                                        transform="translate(-27.488 -75.971)" fill="#e7e5ef" />
                                    <path
                                        d="M18.28,60.9a.6.6,0,0,0,.41-1.03L8.414,50.164a.6.6,0,1,0-.82.867l10.275,9.71A.6.6,0,0,0,18.28,60.9Z"
                                        transform="translate(-7.407 -49.616)" fill="#e7e5ef" />
                                    <path
                                        d="M68.785,50.164l-10.276,9.71a.6.6,0,1,0,.82.867l10.276-9.71a.6.6,0,1,0-.82-.867Z"
                                        transform="translate(-41.914 -49.616)" fill="#e7e5ef" />
                                    <path
                                        d="M27.353,48.905a.6.6,0,0,0-.168.827l5.72,8.651a.6.6,0,0,0,1-.659l-5.72-8.651A.6.6,0,0,0,27.353,48.905Z"
                                        transform="translate(-20.743 -48.806)" fill="#e7e5ef" />
                                    <path
                                        d="M53.374,58.651a.6.6,0,0,0,.5-.268l5.72-8.651a.6.6,0,0,0-1-.659l-5.72,8.651a.6.6,0,0,0,.5.926Z"
                                        transform="translate(-38.156 -48.806)" fill="#e7e5ef" />
                                    <path
                                        d="M48.745,59.191a.6.6,0,0,0,.6-.6V52.176a.6.6,0,1,0-1.194,0v6.419A.6.6,0,0,0,48.745,59.191Z"
                                        transform="translate(-35.018 -50.685)" fill="#e7e5ef" />
                                </g>
                            </g>
                        </g>
                    </svg>
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
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" title="Minha Conta" href="#"
                                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-fluid avatar"
                                    src="{{ asset('storage/img/avatars/' . auth()->user()->avatar) }}"
                                    alt="{{ auth()->user()->avatar }}">
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
                            <a id="navbarDropdownTalks" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="nav-link dropdown-toggle" href="#"
                                title="@lang('layouts.navbar.posts')">
                                <svg width="25" viewBox="0 -26 512 512" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="m256 100c-5.519531 0-10 4.480469-10 10s4.480469 10 10 10 10-4.480469 10-10-4.480469-10-10-10zm0 0" />
                                    <path
                                        d="m90 280c5.519531 0 10-4.480469 10-10s-4.480469-10-10-10-10 4.480469-10 10 4.480469 10 10 10zm0 0" />
                                    <path
                                        d="m336 0c-90.027344 0-163.917969 62.070312-169.632812 140.253906-85.738282 4.300782-166.367188 66.125-166.367188 149.746094 0 34.945312 13.828125 68.804688 39 95.632812 4.980469 20.53125-1.066406 42.292969-16.070312 57.296876-2.859376 2.859374-3.714844 7.160156-2.167969 10.898437 1.546875 3.734375 5.191406 6.171875 9.238281 6.171875 28.519531 0 56.003906-11.183594 76.425781-30.890625 19.894531 6.78125 45.851563 10.890625 69.574219 10.890625 90.015625 0 163.898438-62.054688 169.628906-140.222656 20.9375-.929688 42.714844-4.796875 59.945313-10.667969 20.421875 19.707031 47.90625 30.890625 76.425781 30.890625 4.046875 0 7.691406-2.4375 9.238281-6.171875 1.546875-3.738281.691407-8.039063-2.167969-10.898437-15.003906-15.003907-21.050781-36.765626-16.070312-57.296876 25.171875-26.828124 39-60.6875 39-95.632812 0-86.886719-86.839844-150-176-150zm-160 420c-23.601562 0-50.496094-4.632812-68.511719-11.800781-3.859375-1.539063-8.269531-.527344-11.078125 2.539062-12.074218 13.199219-27.773437 22.402344-44.878906 26.632813 9.425781-18.058594 11.832031-39.347656 6.097656-59.519532-.453125-1.589843-1.292968-3.042968-2.445312-4.226562-22.6875-23.367188-35.183594-53.066406-35.183594-83.625 0-70.46875 71.4375-130 156-130 79.851562 0 150 55.527344 150 130 0 71.683594-67.289062 130-150 130zm280.816406-186.375c-1.152344 1.1875-1.992187 2.640625-2.445312 4.226562-5.734375 20.171876-3.328125 41.460938 6.097656 59.519532-17.105469-4.226563-32.804688-13.433594-44.878906-26.632813-2.808594-3.0625-7.21875-4.078125-11.078125-2.539062-15.613281 6.210937-37.886719 10.511719-58.914063 11.550781-2.921875-37.816406-21.785156-73.359375-54.035156-99.75h130.4375c5.523438 0 10-4.476562 10-10s-4.476562-10-10-10h-161.160156c-22.699219-11.554688-48.1875-18.292969-74.421875-19.707031 5.746093-67.164063 70.640625-120.292969 149.582031-120.292969 84.5625 0 156 59.53125 156 130 0 30.558594-12.496094 60.257812-35.183594 83.625zm0 0" />
                                    <path
                                        d="m256 260h-126c-5.523438 0-10 4.476562-10 10s4.476562 10 10 10h126c5.523438 0 10-4.476562 10-10s-4.476562-10-10-10zm0 0" />
                                    <path
                                        d="m256 320h-166c-5.523438 0-10 4.476562-10 10s4.476562 10 10 10h166c5.523438 0 10-4.476562 10-10s-4.476562-10-10-10zm0 0" />
                                    <path
                                        d="m422 100h-126c-5.523438 0-10 4.476562-10 10s4.476562 10 10 10h126c5.523438 0 10-4.476562 10-10s-4.476562-10-10-10zm0 0" />
                                </svg>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right my-0 py-0"
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
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="33.772" height="33.772" viewBox="0 0 33.772 33.772"><defs><clipPath id="a"><rect width="33.772" height="33.772" transform="translate(93)" fill="#fff" stroke="#707070" stroke-width="1"/></clipPath></defs><g transform="translate(-93)" clip-path="url(#a)"><g transform="translate(94.251)"><path d="M19.339,0A15.653,15.653,0,0,0,3.7,15.635a.625.625,0,1,0,1.251,0,3.127,3.127,0,1,1,6.254,0,.625.625,0,1,0,1.251,0,3.127,3.127,0,1,1,6.254,0,.625.625,0,1,0,1.251,0,3.127,3.127,0,0,1,6.254,0,.625.625,0,0,0,1.251,0,3.127,3.127,0,1,1,6.254,0,.625.625,0,0,0,1.251,0A15.652,15.652,0,0,0,19.339,0Z" transform="translate(-3.704)" fill="#314e55"/><path d="M33.861,13.71a4.38,4.38,0,0,0-3.752,2.125,4.376,4.376,0,0,0-7.5,0,4.376,4.376,0,0,0-7.5,0,4.374,4.374,0,0,0-6.465-1.181,14.387,14.387,0,0,1,27.941,0A4.355,4.355,0,0,0,33.861,13.71Z" transform="translate(-6.969 -2.453)" fill="#e7e5ef"/><path d="M48.822,83.67a2.189,2.189,0,1,0-2.189,2.189A2.192,2.192,0,0,0,48.822,83.67Z" transform="translate(-30.685 -53.963)" fill="#314e55"/><circle cx="0.938" cy="0.938" r="0.938" transform="translate(15.01 28.769)" fill="#e7e5ef"/><g transform="translate(1.251 16.483)"><path d="M56.389,89.072l-2.5,2.5a.625.625,0,1,0,.884.884l2.5-2.5a.625.625,0,0,0-.884-.884Z" transform="translate(-38.068 -75.352)" fill="#314e55"/><path d="M38.1,89.072a.625.625,0,0,0-.884.884l2.5,2.5a.625.625,0,1,0,.884-.884Z" transform="translate(-27.031 -75.352)" fill="#314e55"/><path d="M18.8,61.427a.625.625,0,0,0,.43-1.08L8.462,50.172a.625.625,0,1,0-.859.909L18.371,61.256A.624.624,0,0,0,18.8,61.427Z" transform="translate(-7.407 -49.597)" fill="#314e55"/><path d="M69.286,50.172,58.518,60.347a.625.625,0,1,0,.859.909L70.146,51.08a.625.625,0,1,0-.859-.909Z" transform="translate(-41.127 -49.597)" fill="#314e55"/><path d="M27.365,48.91a.625.625,0,0,0-.177.867l5.995,9.066a.625.625,0,0,0,1.043-.69l-5.995-9.066A.625.625,0,0,0,27.365,48.91Z" transform="translate(-20.439 -48.806)" fill="#314e55"/><path d="M53.4,59.123a.624.624,0,0,0,.522-.28l5.995-9.066a.625.625,0,0,0-1.043-.69l-5.995,9.066a.626.626,0,0,0,.521.971Z" transform="translate(-37.455 -48.806)" fill="#314e55"/><path d="M48.774,59.556a.625.625,0,0,0,.625-.625V52.2a.625.625,0,1,0-1.251,0v6.726A.625.625,0,0,0,48.774,59.556Z" transform="translate(-34.389 -50.642)" fill="#314e55"/></g></g></g></svg>
                    <span class="ml-3">© 2019 Help Dev</span>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
