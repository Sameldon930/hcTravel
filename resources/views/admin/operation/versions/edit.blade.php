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
            {{ Form::open(['method'=>'put','route' => ['admin.versions.update','versions'=>1]]) }}
            <button class="pretty-btn">版本说明修改</button>
            {{ Form::close() }}
        </div>
        <div class="padding-top-sm">
            {{ Form::open(['method'=>'post','route' => ['admin.versions.store']]) }}
            <button class="pretty-btn">版本说明公告</button>
            {{ Form::close() }}
        </div>

    </div>

@stop

@section('js')
    <script>

        $(document).ready(function () {
            $('#operation').addClass('active');
            $('#operation_versionsW_index').addClass('active');
        });

    </script>
@stop