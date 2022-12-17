@extends('adminlte::page') @section('title', 'Dashboard')
@section('content_header')
<div class="card">
    <div class="card-header border-transparent">
        <h3 class="card-title">プロジェクト一覧</h3>
        <div class="card-tools">
            <button
                type="button"
                class="btn btn-tool"
                data-card-widget="collapse"
                control-id="ControlID-15"
            >
                <i class="fas fa-minus"></i>
            </button>
            <button
                type="button"
                class="btn btn-tool"
                data-card-widget="remove"
                control-id="ControlID-16"
            >
                <i class="fas fa-times"></i>
            </button>
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
                                href="{{ route('project.show', ['projectId' => $project->id]) }}"
                                >{{ $project->title }}</a
                            >
                        </td>
                        <td>
                            <div
                                class="sparkbar"
                                data-color="#00a65a"
                                data-height="20"
                            >
                                <a
                                    href="{{ route('project.show', ['projectId' => $project->id]) }}"
                                    >{ {{ $project->description }}</a
                                >
                            </div>
                        </td>
                    </tr>
                </tbody>
                @endforeach
            </table>
        </div>
    </div>

    <div class="card-footer clearfix">
        <a href="javascript:void(0)" class="btn btn-sm btn-info float-left"
            >Place New Order</a
        >
        <a
            href="javascript:void(0)"
            class="btn btn-sm btn-secondary float-right"
            >View All Orders</a
        >
    </div>
</div>
@stop @section('css')
<link rel="stylesheet" href="/css/admin_custom.css" />
@stop @section('js')
<script>
    console.log("Hi!");
</script>
@stop
