@extends('adminlte::page') @section('title', '課題一覧')
@section('content_header')
<h1>課題一覧</h1>
@stop @section('content')
<!-- <div>
    @foreach ($tasks as $task)
    <div>
        <p>{{ $taskOptions[$task->type] }}</p>
        <a href="{{ route('task.show', [$projectId, $task->id]) }}">{{ $task->title }}</a>
        <p>{{ $task->user->name }}</p>
        <p>{{ $task->description }}</p>
        <p>{{ $statusOptions[$task->status] }}</p>
        <p>{{ $task->start_date }}</p>
        <p>{{ $task->end_date }}</p>
    </div>
    @endforeach
</div> -->
<div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <thead>
            <tr>
                <th>種別</th>
                <th>件名</th>
                <th>担当者</th>
                <th>状態</th>
                <th>開始日</th>
                <th>期限日</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
            <tr>
                <!-- <a href="{{ route('task.show', [$projectId, $task->id]) }}"> -->
                <th>{{ $taskOptions[$task->type] }}</th>
                <!-- <a href="{{ route('task.show', [$projectId, $task->id]) }}">{{ $task->title }}</a> -->
                <th><a href="{{ route('task.show', [$projectId, $task->id]) }}">{{ $task->title }}</a></th>
                <th>{{ $task->user->name }}</th>
                <th>{{ $statusOptions[$task->status] }}</th>
                <!-- <th>{{ $task->description }}</th> -->
                <th>{{ $task->start_date }}</th>
                <th>{{ $task->end_date }}</th>
                <!-- </a> -->
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop @section('css')
<link rel="stylesheet" href="/css/admin_custom.css" />
@stop @section('js')
<script>
    console.log("Hi!");
</script>
@stop
