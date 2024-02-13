@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ asset('resources/css/list.css') }}">
@endsection

@section('content')
    <h1 class="text-center">@yield('title')</h1>

    <div class="list-header">
        <form action="#">
            <button>Добавить</button>
        </form>

        <form class="search-form">
            <input type="text" name="search" placeholder="Поиск" value="{{ $searchString }}">
            <button>Поиск</button>
        </form>
    </div>

    <div class="list-container">
        @yield('list')
    </div>

    <div class="list-pagination">
        {{ $list->onEachSide(2)->links('components.pagination') }}
    </div>
@endsection