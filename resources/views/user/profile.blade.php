@extends('app')

@section('title', "Профиль")

@section('css')
    <link rel="stylesheet" href="{{ asset('resources/css/profile.css') }}">
@endsection

@section('content')
    <h1 class="text-center">Мой профиль</h1>
    <div class="space-between">
        <table class="user-table">
            <tbody>
                <tr>
                    <td>Фамилия:</td>
                    <td>{{ $user->lastname }}</td>
                </tr>
                <tr>
                    <td>Имя:</td>
                    <td>{{ $user->firstname }}</td>
                </tr>
                <tr>
                    <td>Отчество:</td>
                    <td>{{ $user->patronymic ?? '' }}</td>
                </tr>
                <tr>
                    <td>Роль:</td>
                    <td>{{ $user->role()->name }}</td>
                </tr>
            </tbody>
        </table>
        <div class="btns-container">
            {{-- Может быть как /user/{id}/edit, так и /me/edit, поэтому через url()->current()  --}}
            <form action="{{ url()->current() }}/edit">
                <button>Изменить данные</button>
            </form>
            @if (Auth::user() == $user)
                <form action="{{ route('logout') }}">
                    <button class="danger">Выйти из аккаунта</button>
                </form>
            @endif
        </div>
    </div>
@endsection