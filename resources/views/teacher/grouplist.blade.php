@extends('list')

@section('title', 'Список групп')

@section('list')
<div class="grouplist">

</div>
    <div class="list">
        @foreach ($list as $group)
            <div class="list-item">
                <a class="list-link" href="#">{{ $group->name }}</a>
            </div>
        @endforeach
    </div>
@endsection