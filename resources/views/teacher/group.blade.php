@extends('app')

@section('title', $group->name)

@section('css')
    <link rel="stylesheet" href="{{ asset('resources/css/group.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/list.css') }}">
@endsection

@php
    $users = $group->users();
@endphp

@section('content')
    <h1 class="page-title">Группа {{ $group->name }}</h1>
    <div class="space-between">
        <div class="user-list">
            <div class="space-between user-list-header">
                <p>{{ count($users) }} студентов</p>
                <div class="space-between">
                    <form action="#">
                        <button>Добавить</button>
                    </form>
                    <form action="">
                        <button>В журнал</button>
                    </form>
                </div>
            </div>
            <div>
                <table class="userslist-table">
                    <tbody>
                        <tr>
                            <td>ФИО</td>
                            <td>Роль</td>
                            <td>Логин</td>
                        </tr>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->lastname }} {{ $user->firstname }} {{ $user->patronymic }}</td>
                                <td>{{ $user->role()->name }}</td>
                                <td>{{ $user->login }}</td>
                                <td>
                                    <form method="POST" action="{{ route('deleteUserFromGroup', [$group->id, $user->id]) }}">
                                        @csrf
                                        <button class="danger small">Удалить</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="btns-container">
            <form method="POST" action="{{ route('editGroup', $group->id) }}">
                @csrf
                <label>
                    <p>Изменить название:</p>
                    <input type="text" name="name" value="{{ $group->name }}">
                </label>
                <button>Сохранить</button>
            </form>
            <form method="POST" action="{{ route('deleteGroup', $group->id) }}">
                @csrf
                <button class="danger">Удалить группу</button>
            </form>
        </div>
    </div>
@endsection