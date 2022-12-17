@extends('adminlte::page') @section('title', '課題作成')
@section('content_header')
<h1>課題作成</h1>
@stop @section('content')
<form method="POST" action="{{ route('task.store', [$projectId]) }}" enctype="multipart/form-data">
    @csrf
    <div class="card-body">
        <div class="form-group">
            <label for="type">種別</label>
            <select name="type" id="type">
                @foreach ($taskOptions as $key => $value)
                <option value="{{ $key }}" {{ $key == old('type') ? 'selected' : '' }}>{{ $value }}</option>
                @endforeach
            </select>
            @if ($errors->has('type'))
            <p>{{ $errors->first('type') }}</p>
            @endif
        </div>
        <div class="form-group">
            <!-- タイトル -->
            <div>
                <label for="title">件名</label>
                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">
                @if ($errors->has('title'))
                <p>{{ $errors->first('title') }}</p>
                @endif
            </div>
        </div>
        <div class="form-group">
            <!-- 担当者 -->
            <div>
                <label for="user_id">担当者</label>
                <select name="user_id" id="user_id">
                    @foreach ($projectUsers as $projectUser)
                    <option value="{{ $projectUser->id }}" {{ $projectUser->id == old('user_id') ? 'selected' : '' }}>{{ $projectUser->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('user_id'))
                <p>{{ $errors->first('user_id') }}</p>
                @endif
            </div>
        </div>
        <div class="form-group">
            <!-- 内容 -->
            <div>
                <label for="description">内容</label>
                <textarea name="description" class="form-control" id="description" rows="9">{{ old('description') }}</textarea>
                @if ($errors->has('description'))
                <p>{{ $errors->first('description') }}</p>
                @endif
            </div>
        </div>
        <div class="form-group">
            <!-- 状態 -->
            <div>
                <label for="status">状態</label>
                <select name="status" id="status">
                    @foreach ($statusOptions as $key => $value)
                    <option value="{{ $key }}" {{ $key == old('status') ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
                @if ($errors->has('status'))
                <p>{{ $errors->first('status') }}</p>
                @endif
            </div>
        </div>
        <div class="form-group">
            <!-- 開始日 -->
            <div>
                <label for="start_date">開始日</label>
                <input type="datetime-local" class="form-control" name="start_date" id="start_date" value="{{ old('start_date') }}">
                @if ($errors->has('start_date'))
                <p>{{ $errors->first('start_date') }}</p>
                @endif
            </div>
        </div>
        <div class="form-group">
            <!-- 期限日 -->
            <div>
                <label for="end_date">期限日</label>
                <input type="datetime-local" class="form-control" name="end_date" id="end_date" value="{{ old('end_date') }}">
                @if ($errors->has('end_date'))
                <p>{{ $errors->first('end_date') }}</p>
                @endif
            </div>
        </div>
        <!-- <div class="form-group">
            <label for="inputFile">File input</label>
            <div class="custom-file">
                <label class="custom-file-label" for="inputFile">Choose file</label>
                <input type="file" class="custom-file-input" id="inputFile" accept="image/png, image/jpeg image/jpg">
            </div>
            @if ($errors->has('file'))
            <p>{{ $errors->first('file') }}</p>
            @endif
        </div> -->
        <div>
            <input type="file" name="file" id="file" accept="image/png, image/jpeg image/jpg">
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
@stop @section('css')
<link rel="stylesheet" href="/css/admin_custom.css" />
@stop @section('js')
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
<script>
  bsCustomFileInput.init();
</script>
@stop
