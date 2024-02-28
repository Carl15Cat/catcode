@extends('app')

@section('title', 'Компилятор')

@section('css')
    <link rel="stylesheet" href="{{ asset('/resources/prism/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('/resources/css/compiler.css') }}">
@endsection

@section('js')
    <script src="{{ asset('/resources/prism/prism.js') }}"></script>
    <script src="{{ asset('/resources/js/compiler.js') }}"></script>
@endsection

@section('content')
    <div class="compiler-container">
        <div class="input-container">
            <div class="window-title language-name">
                <p>Компилятор PHP 7.4.1</p>
                <p class="execute">Запустить</p>
            </div>
            <div class="code-container">
                <textarea name="" id="code" spellcheck="false"></textarea>
                <pre id="highlighting"><code class="language-php" id="highlighting-content"></code></pre>
            </div>
        </div>

        <div class="output-container">
            <div class="window-title">
                Вывод программы
            </div>
            <div class="output-content">
                <p class="default-text">Вывод программы будет отображён здесь</p>
            </div>
        </div>
    </div>
@endsection