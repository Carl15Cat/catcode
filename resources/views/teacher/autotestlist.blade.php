@extends('app')

@section('title', 'Автотесты')

@section('css')
    <link rel="stylesheet" href="{{ asset('resources/css/autotests.css') }}">
@endsection

@section('content')
    <h1 class="page-title">Автотесты {{ $task->name }}</h1>
    <div class="btns-container">
        <form action="{{ route('task', $task) }}">
            <button>К заданию</button>
        </form>
        <form action="{{ route('addAutotest', $task) }}">
            <button>Создать</button>
        </form>
    </div>
    <div class="autotest-list">
        @foreach ($task->autotests()->get() as $autotest)
            <div class="autotest">
                <h2>{{ $autotest->name }}</h2>
                <h3>Ввод:</h3>
                <p>{{ $autotest->input }}</p>
                <h3>Ожидаемый результат:</h3>
                <p>{{ $autotest->expected_output }}</p>
                <form method="POST" action="{{ route('deleteAutotest', [$task, $autotest]) }}" class="delete-autotest-form">
                    @csrf
                    <button class="small danger">Удалить</button>
                </form>
            </div>
        @endforeach
    </div>
@endsection