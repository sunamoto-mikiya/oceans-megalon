@extends('adminlte::page') @section('title', 'Dashboard')
@section('content_header')
<div class="card">
    <div class="card-header border-transparent">
        <h3 class="card-title">プロジェクト一覧</h3>
        <div class="card-tools">
            <a
                href="{{ route('project.create') }}"
                class="btn btn-sm btn-secondary float-right"
                >新規プロジェクト作成</a
            >
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th>title</th>
                        <th>Description</th>
                    </tr>
                </thead>
                @foreach($projects as $project)
                <tbody>
                    <tr>
                        <td>
                            <a
                                href="{{ route('task.index', ['projectId' => $project->id]) }}"
                                >{{ $project->title }}</a
                            >
                        </td>
                        <td>
                            <div
                                class="sparkbar"
                                data-color="#00a65a"
                                data-height="20"
                            >
                                {{ $project->description }}
                            </div>
                        </td>
                        <td>
                            <form
                                class="col s12"
                                method="POST"
                                action="{{ route('project.delete',['projectId' => $project->id]) }}"
                            >
                                @csrf @method('DELETE')
                                <button
                                    type="submit"
                                    class="btn btn-block btn-danger btn-xs"
                                    control-id="ControlID-36"
                                >
                                    削除
                                </button>
                            </form>
                        </td>
                        <td>
                            <a
                                href="{{ route('project.edit',['projectId'=>$project->id]) }}"
                            >
                                <button
                                    type="button"
                                    class="btn btn-block btn-primary btn-xs"
                                    control-id="ControlID-12"
                                >
                                    編集
                                </button>
                            </a>
                        </td>
                    </tr>
                </tbody>
                @endforeach
            </table>
        </div>
    </div>
</div>
@stop @section('css')
<link rel="stylesheet" href="/css/admin_custom.css" />
@stop @section('js')
<script>
    console.log("Hi!");
</script>
@stop
