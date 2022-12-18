@extends('adminlte::page') @section('title', 'Dashboard')
@section('content_header')
<h1>課題編集</h1>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"></h3>
    </div>
    <form
        method="POST"
        action="{{ route('task.update', [$projectId, $taskId]) }}"
        enctype="multipart/form-data"
    >
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label>種別</label>
                <select
                    class="form-control"
                    control-id="ControlID-24"
                    name="type"
                    id="type"
                >
                @foreach ($taskOptions as $key => $value)
                    <option value="{{ $key }}" {{ $key == old('type', $task->type) ? 'selected' : '' }}>{{ $value }}</option>
                @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">タイトル</label>
                <input
                    type="text"
                    class="form-control"
                    name="title"
                    id="title"
                    value="{{ old('title', $task->title) }}"
                    control-id="ControlID-1"
                />
            </div>
            <div class="form-group">
                <label>担当者</label>
                <select
                    class="form-control"
                    control-id="ControlID-24"
                    name="user_id"
                    id="user_id"
                >
                    @foreach ($task->project->users as $projectUser)
                    <option value="{{ $projectUser->id }}" {{ $projectUser->
                        id == old('user_id') ? 'selected' : '' }}>{{ $projectUser->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>内容</label>
                <textarea
                    class="form-control"
                    name="description"
                    id="description"
                    rows="9"
                    control-id="ControlID-13"
                    >{{ old('description', $task->description) }}</textarea
                >
            </div>
            <div class="form-group">
                <label>状態</label>
                <select
                    class="form-control"
                    control-id="ControlID-24"
                    name="status"
                    id="status"
                >
                @foreach ($statusOptions as $key => $value)
                <option value="{{ $key }}" {{ $key == old('type', $task->type) ? 'selected' : '' }}>{{ $value }}</option>
                @endforeach
                </select>
            </div>
            <!-- 開始日 -->
            <div class="form-group">
                <label>開始日</label>
                <br />
                <input
                    type="date"
                    name="start_date"
                    id="start_date"
                    value="{{ old('start_date', $task->start_date) }}"
                />
            </div>

            <!-- 期限日 -->
            <div class="form-group">
                <label>期限日</label>
                <br />
                <input
                    type="date"
                    name="end_date"
                    id="end_date"
                    value="{{ old('end_date',$task->end_date) }}"
                />
            </div>
            <div class="form-group">
                <label for="exampleInputFile">ファイル選択</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input
                            type="file"
                            class="custom-file-input"
                            control-id="ControlID-3"
                            name="file"
                            id="file"
                            accept="image/png, image/jpeg image/jpg"
                            value=""
                        />
                        <label class="custom-file-label" for="exampleInputFile"
                            >Choose file</label
                        >
                    </div>
                    <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button
                type="submit"
                class="btn btn-primary"
                control-id="ControlID-5"
            >
                編集完了
            </button>
        </div>
    </form>
</div>
@stop @section('content') @stop @section('css')
<link rel="stylesheet" href="/css/admin_custom.css" />
@stop @section('js')
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
<script>
    bsCustomFileInput.init();
</script>

@stop
