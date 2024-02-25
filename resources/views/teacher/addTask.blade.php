@extends('app')

@section('title', 'Добавление задания')

@section('css')
    <link rel="stylesheet" href="{{ asset('/resources/css/edit_task.css') }}">
@endsection

@section('js')
    <script src="{{ asset('/resources/js/edit_task.js') }}"></script>
@endsection

@section('content')
    <h1 class="text-center">Добавление задания</h1>

    <form method="POST" class="edit-task-form">
        @csrf
        <div>
            <div>
                <label class="edit-task-label">
                    <p>Название</p>
                    <input class="edit-task-input" type="text" name="name">
                </label>
        
                <label class="edit-task-label">
                    <p>Описание</p>
                    <textarea name="description" id="" cols="40" rows="10" class="edit-task-input"></textarea>
                </label>
            </div>
            <div class="variables-container">
                <h3 class="text-center">Переменные</h3>
                <button type="button" class="small" id="addVariableButton">Добавить</button>

                <div class="variables-list" id="variables_list">

                </div>
            </div>
        </div>


        <button type="submit" class="edit-task-btn">Добавить задание</button>
    </form>
@endsection