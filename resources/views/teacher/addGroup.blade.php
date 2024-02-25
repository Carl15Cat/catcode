@extends('app')

@section('title', 'Добавление группы')

@section('css')
    <link rel="stylesheet" href="{{ asset('resources/css/add_group.css') }}">
@endsection

@section('content')
    <h1 class="text-center">Добавление группы</h1>

    <form method="POST" class="add-group-form">
        @csrf
        <label class="add-group-label">
            <p>Название</p>
            <input class="add-group-input" type="text" name="name">
        </label>

        <button type="submit" class="add-group-btn">Добавить группу</button>
    </form>
@endsection