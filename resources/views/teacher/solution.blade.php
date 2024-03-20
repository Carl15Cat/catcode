@extends('app')

@section('title', $solution->task()->name)

@section('meta')
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/resources/prism/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('/resources/css/compiler.css') }}">
    <link rel="stylesheet" href="{{ asset('/resources/css/solution_teacher.css') }}">
@endsection

@section('js')
    <script src="{{ asset('/resources/prism/prism.js') }}"></script>
    <script src="{{ asset('/resources/js/compiler.js') }}"></script>
    <script src="{{ asset('/resources/js/solution_teacher.js') }}"></script>
@endsection

@section('content')
    <h1 class="page-title">{{ $solution->task()->name }}</h1>
    <div class="content-container">
        <div>
            <div class="input-container">
                <div class="window-title">
                    <p>{{ $solution->task()->programmingLanguage()->name }}</p>
                    <p class="execute" id="executeButton" data-solution-id="{{ $solution->id }}"></p>
                </div>
                <div class="code-container">
                    <textarea name="" id="code" spellcheck="false" disabled>{{ 
                        $solution->code ?? $solution->task()->programmingLanguage()->default_code 
                    }}</textarea>
                    <pre id="highlighting" class="language-{{ $solution->task()->programmingLanguage()->highlight_name }}"><code id="highlighting-content"></code></pre>
                </div>
            </div>
            <div class="autotest-container">
                <h2 class="page-title section-title">Автотесты:</h2>
                <div class="autotest-list" id="autotest_list">
                    @foreach ($solution->task()->autotests()->get() as $test)
                        <div class="autotest" id="autotest-{{ $test->id }}">
                            <h3>{{ $test->name }}</h3>
        
                            <h5>Ввод:</h5>
                            <p><pre>{{ $test->input }}</pre></p>
                            <h5>Ожидаемый вывод:</h5>
                            <p>{{ $test->expected_output }}</p>
                            <h5>Вывод:</h5>
                            <p class="output">*</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="task-info">
            <div class="buttons-container">
                <form action="{{ route('journalTask', $solution->assignment()->id) }}" method="get">
                    <button>Журнал задания</button>
                </form>
                <form action="{{ route('task', $solution->task()->id) }}" method="get">
                    <button>К заданию</button>
                </form>
                <form action="{{ route('journalGroup', $solution->assignment()->group_id) }}" method="get">
                    <button>Журнал группы</button>
                </form>
                {{-- Админ --}}
                @if (Auth::user()->role_id == 1)
                    <form action="{{ route('user', $solution->user_id) }}" method="get">
                        <button>К пользователю</button>
                    </form>
                @endif
            </div>
            <div>
                <form action="{{ route('grade', $solution->id) }}" method="post" class="grade-form">
                    @csrf
                    <h2>Оценка:</h2>
                    <select name="grade">
                        @for ($i = 2; $i <= 5; $i++)
                            @php
                                $selected = is_null($solution->grade) ?
                                ($solution->is_complete ? 
                                    ($i == 5 ? 'selected' : '') :
                                    ($i == 2 ? 'selected' : '')) :
                                ($i == $solution->grade ? 'selected' : '') 
                            @endphp

                            <option {{ $selected }}>{{ $i }}</option>
                        @endfor
                    </select>
                    <button>Сохранить</button>
                </form>
            </div>
            <div>
                <h3>Статус задания: {{ 
                    !is_null($solution->grade) ? 
                    "Оценено, оценка: ".$solution->grade : (
                    $solution->is_complete ? 
                    "Завершено" :
                    "Не завершено" )
                }}</h3>
            </div>
            <div>
                <h3>Крайний срок: {{ $solution->assignment()->deadline() }}</h3>
            </div>
            <div>
                <h2>Описание:</h2>
                <p>{{ $solution->task()->description }}</p>
            </div>
        </div>
    </div>

@endsection