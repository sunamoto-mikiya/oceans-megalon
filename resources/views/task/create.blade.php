<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <form method="POST" action="{{ route('task.store', [$projectId]) }}" enctype="multipart/form-data">
            @csrf

            <!-- 種別 -->
            <div>
                <select name="type" id="type">
                    @foreach ($taskOptions as $key => $value)
                        <option value="{{ $key }}" {{ $key == old('type') ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
                @if ($errors->has('type'))
                    <p>{{ $errors->first('type') }}</p>
                @endif
            </div>

            <!-- タイトル -->
            <div>
                <input type="text" name="title" id="title" value="{{ old('title') }}">
                @if ($errors->has('title'))
                    <p>{{ $errors->first('title') }}</p>
                @endif
            </div>

            <!-- 担当者 -->
            <div>
                <select name="user_id" id="user_id">
                    @foreach ($projectUsers as $projectUser)
                        <option value="{{ $projectUser->id }}" {{ $projectUser->id == old('user_id') ? 'selected' : '' }}>{{ $projectUser->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('user_id'))
                    <p>{{ $errors->first('user_id') }}</p>
                @endif
            </div>

            <!-- 内容 -->
            <div>
                <textarea name="description" id="description" rows="9">{{ old('description') }}</textarea>
                @if ($errors->has('description'))
                    <p>{{ $errors->first('description') }}</p>
                @endif
            </div>

            <!-- 状態 -->
            <div>
                <select name="status" id="status">
                    @foreach ($statusOptions as $key => $value)
                        <option value="{{ $key }}" {{ $key == old('status') ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
                @if ($errors->has('status'))
                    <p>{{ $errors->first('status') }}</p>
                @endif
            </div>

            <!-- 開始日 -->
            <div>
                <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date') }}">
                @if ($errors->has('start_date'))
                    <p>{{ $errors->first('start_date') }}</p>
                @endif
            </div>

            <!-- 期限日 -->
            <div>
                <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date') }}">
                @if ($errors->has('end_date'))
                    <p>{{ $errors->first('end_date') }}</p>
                @endif
            </div>

            <!-- ファイル -->
            <div>
                <input type="file" name="file" id="file" accept="image/png, image/jpeg image/jpg">
                @if ($errors->has('file'))
                    <p>{{ $errors->first('file') }}</p>
                @endif
            </div>

            <div>
                <button type="submit">追加</button>
            </div>

        </form>
    </div>
</body>
</html>
