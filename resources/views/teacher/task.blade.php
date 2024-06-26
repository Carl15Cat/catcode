@extends('app')

@section('title', $task->name)

@section('css')
    <link rel="stylesheet" href="{{ asset('/resources/css/task.css') }}">
@endsection

@section('js')
    <script src="{{ asset('/resources/js/task.js') }}"></script>
@endsection

@section('content')
    <h1 class="page-title">{{ $task->name }}</h1>

    <div class="space-between">
        <div>
            <div class="task-info">
                <h2>Выдано:</h2>
                <div class="list-container" id="list_container">
                    <div class="space-between" style="width: 100%">
                        <div style="width: max-content">{{ $task->assignments()->count() }} групп</div>
                        <div class="space-between">
                            <form action="{{ route('searchGroupToGiveTask', $task->id) }}">
                                <button class="small">Задать</button>
                            </form>
                            <select class="small" id="task_type_select">
                                <option value="all">Все</option>
                                <option value="open">Открытые</option>
                                <option value="closed">Закрытые</option>
                            </select>
                        </div>
                    </div>
                    <table class="group-list" id="group_table">
                        <tbody id="group_tbody">
                            @foreach ($task->assignments()->orderBy('deadline')->get() as $assignment)
                                <tr class="{{ $assignment->deadline > date('Y-m-d H:i:s') ? 'open' : 'closed' }}">
                                    <td><a href="{{ route('group', $assignment->group_id) }}">{{ $assignment->group()->name }}</a></td>
                                    <td class="deadline">{{ date_create_from_format('Y-m-d H:i:s', $assignment->deadline)->format('H:i d.m.Y') }}</td>
                                    <td>
                                        <div class="group-btns">
                                            <form action="{{ route('journalTask', $assignment->id) }}">
                                                <button class="small">Журнал</button>
                                            </form>
    
                                            <form action="{{ route('editAssignment', $assignment->id) }}">
                                                <button class="small">Изменить</button>
                                            </form>
    
                                            <form action="{{ route('cancelTask', ['taskId' => $task->id, 'groupId' => $assignment->group_id]) }}" method="POST">
                                                @csrf
                                                <button class="small danger">Отменить</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="task-info">
            <div>
                <p>Описание:</p>
                <p>{{ $task->description }}</p>
            </div>
            <div class="btns-container">
                <h2>{{ $task->autotests()->count() }} автотестов</h2>
                @if ($task->autotests()->count() > 0)
                    <form action="{{ route('autotestlist', $task->id) }}">
                        <button>Просмотреть автотесты</button>
                    </form>
                @else
                    <form action="{{ route('addAutotest', $task->id) }}">
                        <button>Добавить автотест</button>
                    </form>
                @endif
                <form action="{{ route('editTask', $task->id) }}">
                    <button>Изменить задание</button>
                </form>
                <form action="{{ route('deleteTask', $task->id) }}" method="POST">
                    @csrf
                    <button class="danger">Удалить задание</button>
                </form>
            </div>
        </div>
    </div>
@endsection