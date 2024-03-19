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
            <div class="center">
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
                <div>
                    <p>Язык программирования</p>
                    <div class="language-box">
                        @foreach ($programmingLanguages as $progLang)
                            <label>
                                <input type="radio" name="language_id" value="{{ $progLang->id }}" {{ $progLang->id == $task->programming_language_id ? 'checked' : '' }}>
                                <span>{{ $progLang->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="edit-task-btn">Сохранить изменения</button>
    </form>
@endsection