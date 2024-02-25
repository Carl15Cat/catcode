@extends('app')

@section('title', 'Изменение задания')

@section('css')
    <link rel="stylesheet" href="{{ asset('/resources/css/edit_task.css') }}">
@endsection

@section('js')
    <script src="{{ asset('/resources/js/edit_task.js') }}"></script>
@endsection

@section('content')
    <h1 class="text-center">Изменение задания</h1>

    <form method="POST" class="edit-task-form">
        @csrf
        <div>
            <div>
                <label class="edit-task-label">
                    <p>Название</p>
                    <input class="edit-task-input" type="text" name="name" value="{{ $task->name }}">
                </label>
        
                <label class="edit-task-label">
                    <p>Описание</p>
                    <textarea name="description" id="" cols="40" rows="10" class="edit-task-input">{{ $task->description }}</textarea>
                </label>
            </div>
            <div class="variables-container">
                <h3 class="text-center">Переменные</h3>
                <button type="button" class="small" id="addVariableButton">Добавить</button>

                <div class="variables-list" id="variables_list">
                    @php
                        $i = 0;
                    @endphp

                    @foreach ($task->variables() as $name => $selected_type)
                        <div class="variable" id="variable_{{ $i }}">
                            <label>
                                <p>Тип</p>
                                <select name="variable_type[{{ $i }}]">
                                    @foreach ($var_types as $current_type)
                                        <option {{ $current_type->name == $selected_type ? 'selected' : '' }}>{{ $current_type->name }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label>
                                <p>Название</p>
                                <input type="text" name="variable_name[{{ $i }}]" value="{{ $name }}">
                            </label>
                            <button type="button" class="danger small" onclick="delete_variable({{ $i }})">Удалить</button>
                        </div>

                        @php
                            $i++;
                        @endphp

                    @endforeach
                </div>
            </div>
        </div>

        <button type="submit" class="edit-task-btn">Сохранить изменения</button>
    </form>
@endsection