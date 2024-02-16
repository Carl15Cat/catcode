@extends('app')

@section('title', $group->name)

@section('css')
    <link rel="stylesheet" href="{{ asset('resources/css/group.css') }}">
@endsection

@section('content')
    <h1 class="page-title">Группа {{ $group->name }}</h1>
    <div class="space-between">
        <div class="user-list">
            <div class="space-between user-list-header">
                <p>0 студентов</p>
                <div class="space-between">
                    <form action="#">
                        <button>Добавить</button>
                    </form>
                    <form action="">
                        <button>В журнал</button>
                    </form>
                </div>
            </div>
            <div>
                Тут будет список
            </div>
        </div>
        <div class="btns-container">
            <form action="#">
                <label>
                    <p>Изменить название:</p>
                    <input type="text" name="name" value="{{ $group->name }}">
                </label>
                <button>Сохранить</button>
            </form>
            <form action="#">
                <button class="danger">Удалить группу</button>
            </form>
        </div>
    </div>
@endsection