@extends('app')

@section('title', $solution->task()->name)

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
    <div class="content-container">
        <div>
            <div class="input-container">
                <div class="window-title">
                    <p>{{ $solution->task()->programmingLanguage()->name }}</p>
                    <p class="execute" id="executeButton">Запустить</p>
                </div>
                <div class="code-container">
                    <textarea name="" id="code" spellcheck="false" >{{ $solution->task()->programmingLanguage()->default_code }}</textarea>
                    <pre id="highlighting" class="language-{{ $solution->task()->programmingLanguage()->highlight_name }}"><code id="highlighting-content"></code></pre>
                </div>
            </div>
        </div>
        <div></div>
        <div class="task-info">
            <div>
                <h2>Описание:</h2>
                <p>{{ $solution->task()->description }}</p>
            </div>
            <div>
                <h2>Переменные:</h2>
                <table>
                    @foreach ($solution->task()->variables() as $name => $type)
                        <tr class="variable-row">
                            <td>
                                <p>{{ $name }}</p>
                            </td>
                            <td>
                                <p> - </p>
                            </td>
                            <td>
                                <p>{{ $type }}</p>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="autotest-container">
        <h2 class="page-title section-title">Автотесты:</h2>
        <div class="autotest-list">
            @foreach ($solution->task()->autotests()->get() as $test)
                <div class="autotest" id="autotest-{{ $test->id }}">
                    <h3>{{ $test->name }}</h3>

                    <h5>Переменные:</h5>
                    @foreach ($test->variables() as $name => $value)
                        <p>{{ $name }} = {{ $value }}</p>
                    @endforeach

                    <h5>Ожидаемый вывод:</h5>
                    <p>{{ $test->expected_output }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection