@extends('app')

@section('title', 'Управление пользователями')

@section('css')
    <link rel="stylesheet" href="{{ asset('resources/css/list.css') }}">
@endsection

@section('content')
    <h1 class="text-center">Список пользователей</h1>

    <div class="list-header">
        <form action="#">
            <button>Добавить</button>
        </form>

        <form class="search-form">
            <input type="text" name="search" placeholder="Поиск" value="{{ $searchString }}">
            <button>Поиск</button>
        </form>
    </div>

    <div class="list-container">
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
                        <td><a href="#" class="list-link">Перейти</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="list-pagination">
        {{ $users->onEachSide(2)->links('components.pagination') }}
    </div>
@endsection