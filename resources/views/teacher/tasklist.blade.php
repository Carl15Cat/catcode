@extends('list')

@section('title', 'Список заданий')

@section('list')
<div class="grouplist">

</div>
    <div class="list">
        @foreach ($list as $task)
            <div class="list-item">
                <a class="list-link" href="{{ route('task', $task->id) }}">{{ $task->name }}</a>
            </div>
        @endforeach
    </div>
@endsection