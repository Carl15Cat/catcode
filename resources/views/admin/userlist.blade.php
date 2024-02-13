@extends('list')

@section('title', 'Список пользователей')

@section('list')
    <table class="userslist-table">
        <tbody>
            <tr>
                <td>ФИО</td>
                <td>Роль</td>
                <td>Логин</td>
            </tr>
            @foreach ($list as $user)
                <tr>
                    <td>{{ $user->lastname }} {{ $user->firstname }} {{ $user->patronymic }}</td>
                    <td>{{ $user->role()->name }}</td>
                    <td>{{ $user->login }}</td>
                    <td><a href="{{ route('user', $user->id) }}" class="list-link">Перейти</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
