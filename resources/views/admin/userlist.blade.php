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
                    <td>
                        <form action="{{ route('user', $user->id) }}">
                            <button class="small">Профиль</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
