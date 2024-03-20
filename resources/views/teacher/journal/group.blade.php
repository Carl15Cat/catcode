@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ asset('resources/css/journal.css') }}">
@endsection

@section('content')
    <h1 class="page-title">{{ $group->name }}</h1>
    <div class="table-container">
        <table class="journal-table">
            <tbody>
                <tr>
                    <th></th>
                    @foreach ($group->tasks()->get() as $assignment)
                        <th><a href="{{ route('journalTask', $assignment->id) }}">{{ $assignment->task()->name }}</a></th>
                    @endforeach
                </tr>
                <tr>
                    <th></th>
                    @foreach ($group->tasks()->get() as $assignment)
                        <th>{{ $assignment->deadline("date") }}</th>
                    @endforeach
                </tr>
                @foreach ($group->users()->get() as $student)
                    <tr>
                        <td class="inline"><p>{{ $student->lastname}} {{ $student->firstname }}</p></td>
                        @foreach ($group->tasks()->get() as $assignment)
                            @php
                                $solution = $assignment->getSolution($student->id);
                                if(is_null($solution)) continue;
                            @endphp

                            <td>
                                @if (is_null($solution->grade))
                                    @if ($solution->is_complete)
                                    <a href="{{ route('solutionTeacher', $solution->id) }}" class="waiting-for-grade">Ожидает</a>
                                    @else
                                        <a href="{{ route('solutionTeacher', $solution->id) }}" class="not-complete">*</a>
                                    @endif
                                @else
                                    <a href="{{ route('solutionTeacher', $solution->id) }}" class="grade-{{ $solution->grade }}">{{ $solution->grade }}</a>
                                @endif
                            </td>

                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection