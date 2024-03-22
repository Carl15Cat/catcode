@extends('app')

@section('title', 'Дать задание')

@section('css')
    <link rel="stylesheet" href="{{ asset('resources/css/giveTask.css') }}">
@endsection

@section('content')
    <h1 class="page-title">Дать задание</h1>
    <form action="#" method="post">
        @csrf
        <div class="center">
            <div>
                <label>
                    <p>Задание</p>
                    <input type="text" value="{{ $assignment->task()->name }}" disabled>
                </label>
                <label>
                    <p>Группа</p>
                    <input type="text" value="{{ $assignment->group()->name }}" disabled>
                </label>
                <label>
                    <p>Срок сдачи</p>
                    <input type="date" name="deadline_date" value="{{ $assignment->deadline('date-reversed') }}">
                    <input type="time" name="deadline_time" value="{{ $assignment->deadline('time') }}">
                </label>
                <div class="btn-container">
                    <button>Сохранить</button>
                </div>
            </div>
        </div>

    </form>
@endsection