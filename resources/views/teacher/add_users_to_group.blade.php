@extends('list')

@section('title', $group->name.": добавить студентов")

@section('sidebtn')
    <form action="{{ route('group', $group->id) }}">
        <button>Назад</button>
    </form>   
@endsection

@section('list')
    <table class="userslist-table">
        <tbody>
            <tr>
                <td>ФИО</td>
                <td>Логин</td>
            </tr>
            @foreach ($list as $user)
                <tr>
                    <td>{{ $user->lastname }} {{ $user->firstname }} {{ $user->patronymic }}</td>
                    <td>{{ $user->login }}</td>
                    <td>
                        <form action="{{ route('addUserToGroup', [$group->id, $user->id]) }}" method="post">
                            @csrf
                            <button class="small">Добавить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection