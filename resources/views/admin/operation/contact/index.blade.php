@extends('layouts.admin')

@section('pageTitle')
    联系我们
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        联系我们
        <div class="padding-top-sm">
            <a href="{{route('admin.contact.edit',['contact'=>1])}}">
                <button class="pretty-btn">修改客服</button>
            </a>
        </div>
        <div class="padding-top-sm">
            <a href="{{route('admin.contact.add')}}">
                <button class="pretty-btn">添加客服</button>
            </a>
        </div>
        <div class="padding-top-sm">
            <a href="{{route('admin.contact.switch',['contact'=>1])}}">
                <button class="pretty-btn">客服开关</button>
            </a>
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