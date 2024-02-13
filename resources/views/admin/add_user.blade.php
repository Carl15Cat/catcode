@extends('app')

@section('title', 'Добавление пользователя')

@section('css')
    <link rel="stylesheet" href="{{ asset('resources/css/add_user.css') }}">
@endsection

@section('content')
    <h1 class="text-center">Добавление пользователя</h1>

    <form method="POST" class="add-user-form">
        @csrf

        <label class="add-user-label">
            <p>Имя</p>
            <input class="add-user-input" type="text" name="firstname">
        </label>
        <label class="add-user-label">
            <p>Фамилия</p>
            <input class="add-user-input" type="text" name="lastname">
        </label>
        <label class="add-user-label">
            <p>Отчество</p>
            <input class="add-user-input" type="text" name="patronymic">
        </label>
        <label class="add-user-label">
            <p>Роль</p>
            <select class="add-user-input" name="role_id">
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </label>
        <label class="add-user-label">
            <p>Логин</p>
            <input class="add-user-input" type="text" name="login">
        </label>
        <label class="add-user-label">
            <p>Пароль</p>
            <input class="add-user-input" type="password" name="password">
        </label>
        <label class="add-user-label">
            <p>Повтор пароля</p>
            <input class="add-user-input" type="password" name="password-repeat">
        </label>

        <button type="submit" class="add-user-btn">Добавить пользователя</button>
    </form>
@endsection