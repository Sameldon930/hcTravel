@extends('layouts.admin')

@section('pageTitle')
    版本说明
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        版本说明
        <div class="padding-top-sm">
            <a href="{{route('admin.versions.edit',['versions'=>1])}}">
                <button class="pretty-btn">版本说明修改</button>
            </a>
        </div>
        <div class="padding-top-sm">
            <a href="{{route('admin.versions.add')}}">
                <button class="pretty-btn">版本说明添加</button>
            </a>
        </div>
    </div>

@stop

@section('js')
    <script>

        $(document).ready(function () {
            $('#operation').addClass('active');
            $('#operation_versions_index').addClass('active');
        });

    </script>
@stop