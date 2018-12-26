@extends('layouts.admin')

@section('pageTitle')
    用户详情
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        用户详情
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