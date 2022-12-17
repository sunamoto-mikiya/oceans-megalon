@extends('adminlte::page') @section('title', 'Dashboard')
@section('content_header')
<h1>課題編集</h1>
@stop @section('content')
<div>
    <form method="POST" action="{{ route('task.update', [$projectId, $taskId]) }}" enctype="multipart/form-data">
        @csrf

        <!-- 種別 -->
        <div>
            <select name="type" id="type">
                @foreach ($taskOptions as $key => $value)
                    <option value="{{ $key }}" {{ $key == old('type', $task->type) ? 'selected' : '' }}>{{ $value }}</option>
                @endforeach
            </select>
        </div>

        <!-- タイトル -->
        <div>
            <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}">
        </div>

        <!-- 担当者 -->
        <div>
            <select name="user_id" id="user_id">
                @foreach ($task->project->users as $projectUser)
                    <option value="{{ $projectUser->id }}" {{ $projectUser->id == old('user_id') ? 'selected' : '' }}>{{ $projectUser->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- 内容 -->
        <div>
            <textarea name="description" id="description" rows="9">{{ old('description', $task->description) }}</textarea>
        </div>

        <!-- 状態 -->
        <div>
            <select name="status" id="status">
                @foreach ($statusOptions as $key => $value)
                    <option value="{{ $key }}" {{ $key == old('type', $task->type) ? 'selected' : '' }}>{{ $value }}</option>
                @endforeach
            </select>
        </div>

        <!-- 開始日 -->
        <div>
            <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date', $task->start_date) }}">
        </div>

        <!-- 期限日 -->
        <div>
            <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date', $task->end_date) }}">
        </div>

        <!-- ファイル -->
        <div>
            <input type="file" name="file" id="file" accept="image/png, image/jpeg image/jpg">
        </div>

        <div>
            <button type="submit">編集</button>
        </div>

    </form>
</div>
@stop @section('css')
<link rel="stylesheet" href="/css/admin_custom.css" />
@stop @section('js')
<script>
    console.log("Hi!");
</script>
@stop
