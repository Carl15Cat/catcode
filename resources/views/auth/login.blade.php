@extends('app')

@section('title', 'Вход')

@section('css')
    <link rel="stylesheet" href="{{ asset('resources/css/login.css') }}">
@endsection

@section('content')
    <form method="POST" class="login-form">
        @csrf
        <h1 class="text-center">Вход в систему</h1>

        <label class="login-label">
            <p>Логин</p>
            <input class="login-input" type="text" name="login">
        </label>
        <label class="login-label">
            <p>Пароль</p>
            <input class="login-input" type="password" name="password">
        </label>
        
        <button type="submit" class="login-btn">Вход</button>
    </form>
@endsection