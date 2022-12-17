@extends('adminlte::page') @section('title', 'Dashboard')
@section('content_header')
<h1>課題詳細</h1>
@stop @section('content')
<div>
    <p>{{ $taskOptions[$task->type] }}</p>
    <p>{{ $task->title }}</p>
    <p>{{ $task->user?->name }}</p>
    <p>{{ $task->description }}</p>
    <p>{{ $statusOptions[$task->status] }}</p>
    <p>{{ $task->start_date }}</p>
    <p>{{ $task->end_date }}</p>
</div>
@stop @section('css')
<link rel="stylesheet" href="/css/admin_custom.css" />
@stop @section('js')
<script>
    console.log("Hi!");
</script>
@stop
