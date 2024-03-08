@extends('app')

@section('title', 'Дать задание')

@section('css')
    <link rel="stylesheet" href="{{ asset('resources/css/giveTask.css') }}">
@endsection

@section('js')
    {{-- <script src="{{ asset('resources/js/giveTask.js') }}"></script> --}}
@endsection

@section('content')
    <h1 class="page-title">Дать задание</h1>
    <form action="#" method="post">
        @csrf
        <div class="center">
            <div>
                <label>
                    <p>Задание</p>
                    <input type="text" value="{{ $task->name }}" disabled>
                </label>
                <label>
                    <p>Группа</p>
                    <input type="text" value="{{ $group->name }}" disabled>
                </label>
                <label>
                    <p>Срок сдачи</p>
                    <input type="date" name="deadline_date">
                    <input type="time" name="deadline_time">
                </label>
                <div class="btn-container">
                    <button>Сохранить</button>
                </div>
            </div>
            {{-- <div>
                <h2>Доступные языки</h2>
                <label class="language-label">
                    <input type="checkbox" id="select-all-checkbox">
                    <span>Выбрать все</span>
                </label>
                <div id="languages-list" class="languages-list">
                    @foreach ($programmingLanguages as $language)
                        <label class="language-label">
                            <input type="checkbox" class="language-checkbox" name="languages[{{ $language->id }}]">
                            <span>{{ $language->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div> --}}
        </div>

    </form>
@endsection