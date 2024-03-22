@extends('app')

@section('title', 'Компилятор')

@section('css')
    <link rel="stylesheet" href="{{ asset('/resources/prism/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('/resources/css/compiler.css') }}">
@endsection

@section('js')
    <script src="{{ asset('/resources/prism/prism.js') }}"></script>
    <script src="{{ asset('/resources/js/compiler.js') }}"></script>
    <script src="{{ asset('/resources/js/free_compiler.js') }}"></script>
@endsection

@section('content')
    <div class="compiler-container">
        <div class="inputs-container">
            <div class="input-container">
                <div class="window-title">
                    <select class="language-name" name="language_id" id="language_select">
    
                    </select>
                    <p class="execute" id="executeButton">Запустить</p>
                </div>
                <div class="code-container">
                    <textarea name="" id="code" spellcheck="false"></textarea>
                    <pre id="highlighting"><code id="highlighting-content"></code></pre>
                </div>
            </div>
            <div class="input-container">
                <div class="window-title">
                    <p class="window-name">Ввод</p>
                </div>
                <div class="code-container">
                    <textarea name="" id="input" cols="30" rows="10"></textarea>
                </div>
            </div>
        </div>

        <div class="output-container">
            <div class="window-title">
                Вывод программы
            </div>
            <div class="output-content">
                <p class="default-text" id="output_field">Вывод программы будет отображён здесь</p>
            </div>
        </div>
    </div>
@endsection