@extends('layouts.admin')

@section('pageTitle')
    客服修改/添加
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        客服修改/添加页面
        <div class="padding-top-sm">
            {{ Form::open(['method'=>'put','route' => ['admin.contact.update','contact'=>1]]) }}
            <button class="pretty-btn">客服修改</button>
            {{ Form::close() }}
        </div>
        <div class="padding-top-sm">
            {{ Form::open(['method'=>'post','route' => ['admin.contact.store']]) }}
            <button class="pretty-btn">客服公告</button>
            {{ Form::close() }}
        </div>

    </div>

@stop

@section('js')
    <script>

        $(document).ready(function () {
            $('#operation').addClass('active');
            $('#operation_contact_index').addClass('active');
        });

    </script>
@stop