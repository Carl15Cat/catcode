{{--
    Основной шаблон приложения    
--}}

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'CATCODE')</title>

    <link rel="stylesheet" href="{{ asset('resources/css/app.css') }}">
    @yield('css')
</head>
<body>
    @include('components/header')

    @if ($errors->any())
        {{ $errors->all()[0] }}
    @endif

    <div class="container">
        <div class="max-width">
            @yield('content')
        </div>
    </div>

    @include('components/footer')

    @yield('js')
</body>
</html>