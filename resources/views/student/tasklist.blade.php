@extends('list')

@section('title', 'Список заданий')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('resources/css/student_tasklist.css') }}">
@endsection

@section('sidebtn')
    {{-- Скрыть кнопку --}}
    {{-- Можно будет сделать тут фильтрацию --}}
@endsection

@section('list')
    <div class="list">
        @foreach ($list as $solution)
            <div class="list-item">
                <div class="space-between">
                    <div class="text">
                        <h2>{{ $solution->task()->name }}</h2>
                        <h3>Крайний срок: {{ $solution->assignment()->deadline() }}</h3>
                        <p>Язык программирования: {{ $solution->task()->programmingLanguage()->name }}</p>
                        <p>Группа: {{ $solution->assignment()->group()->name }}</p>
                    </div>
                    <div class="buttons">
                        <form action="{{ route('solutionStudent', $solution->id) }}">
                            <button>К заданию</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection