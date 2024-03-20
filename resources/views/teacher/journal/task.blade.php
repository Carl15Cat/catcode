@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ asset('resources/css/journal.css') }}">
@endsection

@section('content')
    <h1 class="page-title">{{ $assignment->task()->name }} - {{ $assignment->group()->name }}</h1>
    <h2 class="page-title">Крайний срок: <p class="{{ $assignment->isExpired() ? 'error' : '' }}">{{ $assignment->deadline() }}</h2>
    <div class="table-container">
        <table class="journal-table">
            <tbody>
                <tr>
                    <th>Студент</th>
                    <th>Статус</th>
                    <th>Оценка</th>
                    <th>Решение</th>
                </tr>
                @foreach ($assignment->group()->users()->get() as $student)
                    <tr>
                        @php
                            $solution = $assignment->getSolution($student->id);
                        @endphp

                        <td>{{ $student->lastname }} {{ $student->firstname }}</td>
                        <td><p class="{{ $solution->is_complete ? 'success' : 'error' }}">{{ $solution->is_complete ? 'Завершено' : 'Не завершено' }}</p></td>
                        <td><p class="grade-{{ $solution->grade }}">{{ is_null($solution->grade) ? "*" : $solution->grade }}</p></td>
                        <td><form action="#"><button class="small">Перейти</button></form></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection