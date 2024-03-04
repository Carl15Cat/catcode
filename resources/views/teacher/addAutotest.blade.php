@extends('app')

@section('title', 'Создать автотест')

@section('css')
    <link rel="stylesheet" href="{{ asset('resources/css/add_autotest.css') }}">
@endsection

@section('content')
    <h1 class="page-title">Создать автотест</h1>
    <div class="btns-container">
        <form action="{{ route('task', $task) }}">
            <button>К заданию</button>
        </form>
        <form action="{{ route('autotestlist', $task) }}">
            <button>К списку</button>
        </form>
    </div>
    <div class="space-between">
        <div class="task-description">
            <h2>{{ $task->name }}</h2>
            <p>{{ $task->description }}</p>
        </div>
        <div class="form-container">
            <form action="{{ route('addAutotest', $task->id) }}" method="POST" class="add-autotest-form">
                @csrf
                <label>
                    <h3>Название</h3>
                    <input type="text" placeholder="Без названия" name="name">
                </label>
                <h3>Переменные</h3>
                @foreach ($task->variables() as $name => $type)
                    <label>
                        <p>{{ $name }} ({{ $type }})</p>
                        <input type="text" name="variables[{{ $name }}]">
                    </label>
                @endforeach
                <label>
                    <h3>Ожидаемый результат</h3>
                    <input type="text" name="expected_output">
                </label>
                <div>
                    <button>Добавить</button>
                </div>
            </form>
        </div>
    </div>
@endsection