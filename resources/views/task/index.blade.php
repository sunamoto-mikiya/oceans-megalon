@extends('adminlte::page') @section('title', '課題一覧')
@section('content_header')
<h3 class="title">課題一覧</h3>
<div class="card">
    <div class="card-header border-transparent">
        <div class="card-tools">
            <a
                href="{{ route('task.create', ['projectId' => $projectId]) }}"
                class="btn btn-sm btn-secondary float-right"
                >新規課題作成</a
            >
        </div>
    </div>
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
                    <th>
                        <a
                            href="{{ route('task.show', [$projectId, $task->id]) }}"
                            >{{ $task->title }}</a
                        >
                    </th>
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
</div>
@stop @section('css')
<link rel="stylesheet" href="/css/admin_custom.css" />
@stop @section('js')
<script>
    console.log("Hi!");
</script>
@stop
