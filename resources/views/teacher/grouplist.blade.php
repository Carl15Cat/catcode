@extends('list')

@section('title', 'Список групп')

@section('list')
    <table>
        <tbody>
            @foreach ($list as $group)
                <tr>
                    <td>{{ $group->name }}</td>
                    <td>{{ $group->users()->count() }} чел.</td>
                    <td>
                        <form action="{{ route('group', $group->id) }}" method="get">
                            <button class="small">Информация</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('journalGroup', $group->id) }}" method="get">
                            <button class="small">Журнал</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection