@extends('list')

@section('title', 'Дать задание')

@section('sidebtn')
    {{-- Без кнопки --}}
@endsection

@section('list')
<div class="grouplist">

</div>
    <div class="list">
        @foreach ($list as $group)
            <div class="list-item">
                <a class="list-link" href="{{ route('giveTask', [$taskId, $group->id]) }}">{{ $group->name }}</a>
            </div>
        @endforeach
    </div>
@endsection