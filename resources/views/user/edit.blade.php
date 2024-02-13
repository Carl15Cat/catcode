@extends('app')

@section('title', 'Изменить пользователя')

@section('css')
    <link rel="stylesheet" href="{{ asset('resources/css/edit_user.css') }}">
@endsection

@section('content')
    <h1 class="text-center">Изменить пользователя</h1>

    <form method="POST" class="edit-user-form">
        @csrf

        <label class="edit-user-label">
            <p>Имя</p>
            <input class="edit-user-input" type="text" name="firstname" value="{{ $user->firstname }}">
        </label>
        <label class="edit-user-label">
            <p>Фамилия</p>
            <input class="edit-user-input" type="text" name="lastname" value="{{ $user->lastname }}">
        </label>
        <label class="edit-user-label">
            <p>Отчество</p>
            <input class="edit-user-input" type="text" name="patronymic" value="{{ $user->patronymic }}">
        </label>
        <label class="edit-user-label">
            <p>Роль</p>
            <select class="edit-user-input" name="role_id">
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ $role == $user->role() ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
        </label>
        <label class="edit-user-label">
            <p>Логин</p>
            <input class="edit-user-input" type="text" name="login" value="{{ $user->login }}">
        </label>
        <label class="edit-user-label">
            <p>Пароль</p>
            <input class="edit-user-input" type="password" name="password">
        </label>
        <label class="edit-user-label">
            <p>Повтор пароля</p>
            <input class="edit-user-input" type="password" name="password-repeat">
        </label>

        <button type="submit" class="edit-user-btn">Сохранить</button>
    </form>
@endsection