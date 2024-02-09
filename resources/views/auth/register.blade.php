@extends('app')

@section('title', 'Вход')

@section('css')
    <link rel="stylesheet" href="{{ asset('resources/css/register.css') }}">
@endsection

@section('content')
    <form method="POST" class="register-form">
        @csrf
        <h1 class="text-center">Регистрация</h1>

        <label class="register-label">
            <p>Имя</p>
            <input class="register-input" type="text" name="firstname">
        </label>
        <label class="register-label">
            <p>Фамилия</p>
            <input class="register-input" type="text" name="lastname">
        </label>
        <label class="register-label">
            <p>Отчество</p>
            <input class="register-input" type="text" name="patronymic">
        </label>
        <label class="register-label">
            <p>Логин</p>
            <input class="register-input" type="text" name="login">
        </label>
        <label class="register-label">
            <p>Пароль</p>
            <input class="register-input" type="password" name="password">
        </label>
        <label class="register-label">
            <p>Повтор пароля</p>
            <input class="register-input" type="password" name="password-repeat">
        </label>

        <button type="submit" class="register-btn">Регистрация</button>
    </form>
@endsection