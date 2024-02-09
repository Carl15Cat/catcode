<header>
    <div class="header-container max-width">
        <div class="header-group">
            <a href="{{ route('/') }}">
                <img src="{{ asset('resources/img/logo.svg') }}" alt="Logo" class="logo">
            </a>
            <a href="{{ route('/') }}" class="branding">
                CATCODE
            </a>
        </div>
        <div class="header-group">
            @guest
                <a class="nav-link" href="{{ route('login') }}">Вход</a>
                <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
            @endguest

            @auth
                <a class="nav-link" href="#">{{ Auth::user()->lastname }} {{ Auth::user()->firstname }}</a>
                <a class="nav-link" href="{{ route('logout') }}">Выход</a>
            @endauth
        </div>
    </div>
</header>