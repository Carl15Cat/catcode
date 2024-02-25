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
                <div class="space-between">
                    <label for="list-style-group">
                        <input type="radio" name="list-type" value="group" id="list-style-group" onchange="handleListChange(this)" checked>
                        <div class="button">Групповые</div>
                    </label>
                    <label for="list-style-solo">
                        <input type="radio" name="list-type" value="solo" id="list-style-solo" onchange="handleListChange(this)">
                        <div class="button">Индивидуальные</div>
                    </label>
                </div>
                <div class="list-container" id="list_container">
                    <div class="list" id="list_group">
                        <div class="list-header space-between">
                            <h3>0 групп</h3>
                            <form action="#">
                                <button class="small">Задать</button>
                            </form>
                        </div>
                    </div>
                    <div class="list no-display" id="list_solo">
                        <div class="list-header space-between">
                            <h3>0 студентов</h3>
                            <form action="#">
                                <button class="small">Задать</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="task-info">
            <div>
                <p>Описание:</p>
                <p>{{ $task->description }}</p>
            </div>
            <div>
                <p>Переменные:</p>
                <div>
                    @foreach ($task->variables() as $name => $type)
                        <div class="list-item">
                            <p>{{ $name }} {{ $type }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="btns-container">
                <h2>0 автотестов</h2>
                <form action="#">
                    <button>Просмотреть автотесты</button>
                </form>
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