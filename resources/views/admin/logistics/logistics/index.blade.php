@extends('layouts.admin')

@section('pageTitle')
    配送列表
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        配送列表
    </div>

@stop

@section('js')
    <script>

        $(document).ready(function () {
            $('#logistics').addClass('active');
            $('#logistics_logistics_index').addClass('active');
        });
    </script>
@stop