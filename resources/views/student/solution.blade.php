@extends('app')

@section('title', $solution->task()->name)

@section('meta')
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/resources/prism/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('/resources/css/compiler.css') }}">
    <link rel="stylesheet" href="{{ asset('/resources/css/solution_student.css') }}">
@endsection

@section('js')
    <script src="{{ asset('/resources/prism/prism.js') }}"></script>
    <script src="{{ asset('/resources/js/compiler.js') }}"></script>
    <script src="{{ asset('/resources/js/solution_student.js') }}"></script>
@endsection

@section('content')
    <h1 class="page-title">{{ $solution->task()->name }}</h1>
    <div class="task-info">
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
    </div>
    <div class="content-container">
        <div>
            <div class="input-container">
                <div class="window-title">
                    <p>{{ $solution->task()->programmingLanguage()->name }}</p>
                    <p class="execute" id="executeButton" data-solution-id="{{ $solution->id }}">Запустить</p>
                </div>
                <div class="code-container">
                    <textarea name="" id="code" spellcheck="false" >{{ 
                        $solution->code ?? $solution->task()->programmingLanguage()->default_code 
                    }}</textarea>
                    <pre id="highlighting" class="language-{{ $solution->task()->programmingLanguage()->highlight_name }}"><code id="highlighting-content"></code></pre>
                </div>
            </div>
        </div>
        <div></div>
        <div class="task-desc">
            <div>
                <h2 class="page-title">Описание:</h2>
                <p>{{ $solution->task()->description }}</p>
            </div>
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
                    <h5>Ваш вывод:</h5>
                    <p class="output">*</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection