<header>
    <div class="header-container max-width">
        <div class="header-group">
            <a href="{{ route('/') }}">
                <img src="{{ asset('resources/img/logo.svg') }}" alt="Logo" class="logo">
            </a>
            <a href="{{ route('/') }}" class="branding">
                CATCODE
            </a>

            @auth
                {{-- Студент --}}
                @if (Auth::user()->role_id == 3) 
                    <a class="nav-link" href="#">Мои задания</a>    
                @endif

                {{-- Преподаватель или Админ --}}
                @if (Auth::user()->role_id == 2 || Auth::user()->role_id == 1)
                    <a class="nav-link" href="#">Задания</a>
                    <a class="nav-link" href="#">Группы</a>
                    <a class="nav-link" href="#">Журнал</a>
                @endif

                {{-- Админ --}}
                @if (Auth::user()->role_id == 1)
                    <a class="nav-link" href="{{ route('userlist') }}">Управление пользователями</a>
                @endif
            @endauth
        </div>
        <div class="header-group">
            @guest
                <a class="nav-link" href="{{ route('login') }}">Вход</a>
                <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
            @endguest

            @auth
                <a class="nav-link" href="{{ route('myProfile') }}">{{ Auth::user()->lastname }} {{ Auth::user()->firstname }}</a>
                <a class="nav-link" href="{{ route('logout') }}">Выход</a>
            @endauth
        </div>
    </div>
</header>