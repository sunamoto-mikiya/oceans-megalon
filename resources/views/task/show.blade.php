@extends('adminlte::page') @section('title', 'Dashboard')
@section('content_header')
<div class="card-header border-transparent">
    <h1 class="card-title">課題詳細</h1>
    <div class="card-tools">
        <a
            href="{{ route('task.edit',['projectId'=>$projectId,'taskId'=>$task->id]) }}"
            class="btn btn-m btn-secondary float-right m-2"
            >編集</a
        >
    </div>
    <div class="card-tools">
        <form
            class="col s12"
            method="POST"
            action="{{ route('task.delete',['projectId'=>$projectId,'taskId'=>$task->id]) }}"
        >
            @csrf @method('DELETE')
            <button
                type="submit"
                class="btn btn-m btn-secondary float-right m-2"
            >
                削除
            </button>
        </form>
    </div>
</div>

@stop @section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $task->title }}</h3>
    </div>

    <div class="card-body">
        <strong><i class="fas fa-book mr-1"></i> タスクタイプ</strong>
        <p class="text-muted">
            {{ $taskOptions[$task->type] }}
        </p>
        <hr />
        <strong><i class="far fa-file-alt mr-1"></i> 詳細</strong>
        <p class="text-muted">{{ $task->description }}</p>
        <hr />
        <strong><i class="fas fa-people-arrows mr-1"></i> 担当者</strong>
        <p>{{ $task->user?->name }}</p>
        <hr />
        <strong><i class="fas fa-pencil-alt mr-1"></i> 進捗</strong>
        <p>{{ $statusOptions[$task->status] }}</p>
        <hr />
        <strong><i class="fas fa-calendar-day mr-1"></i> 開始日〜終了日</strong>
        <p>{{ $task->start_date }}〜{{ $task->end_date }}</p>
    </div>
</div>
@stop @section('css')
<link rel="stylesheet" href="/css/admin_custom.css" />
@stop @section('js')
<script>
    console.log("Hi!");
</script>
@stop
