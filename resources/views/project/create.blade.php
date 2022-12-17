@extends('adminlte::page') @section('title', 'プロジェクト作成')
@section('content_header')
<div class="card">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">プロジェクト作成</h3>
        </div>

        <form>
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">タイトル</label>
                    <input
                        type="email"
                        class="form-control"
                        id="exampleInputEmail1"
                        placeholder="Enter email"
                        control-id="ControlID-1"
                    />
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">詳細</label>
                    <textarea
                        class="form-control"
                        rows="3"
                        placeholder="Enter ..."
                        control-id="ControlID-13"
                        data-dl-input-translation="true"
                    ></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">ファイル選択</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input
                                type="file"
                                class="custom-file-input"
                                id="exampleInputFile"
                                control-id="ControlID-3"
                            />
                            <label
                                class="custom-file-label"
                                for="exampleInputFile"
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
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>
@stop @section('css')
<link rel="stylesheet" href="/css/admin_custom.css" />
@stop @section('js')
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
<script>
    bsCustomFileInput.init();
</script>
@stop
