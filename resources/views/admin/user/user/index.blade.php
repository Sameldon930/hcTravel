@extends('layouts.admin')

@section('pageTitle')
    用户列表
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        用户列表
        <div class="padding-top-sm">
            <a href="{{route('admin.user.show',['user'=>1])}}">
                <button class="pretty-btn">用户详情</button>
            </a>
        </div>
    </div>

@stop

@section('js')
    <script>

        $(document).ready(function () {
            $('#user').addClass('active');
            $('#user_user_index').addClass('active');
        });

    </script>
@stop