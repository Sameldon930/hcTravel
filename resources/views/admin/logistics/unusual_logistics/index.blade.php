@extends('layouts.admin')

@section('pageTitle')
    异常物流列表
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        异常物流列表
    </div>

@stop

@section('js')
    <script>

        $(document).ready(function () {
            $('#logistics').addClass('active');
            $('#logistics_unusual_logistics_index').addClass('active');
        });

    </script>
@stop