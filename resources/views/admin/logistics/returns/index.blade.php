@extends('layouts.admin')

@section('pageTitle')
    退货列表
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        退货列表
    </div>

@stop

@section('js')
    <script>

        $(document).ready(function () {
            $('#logistics').addClass('active');
            $('#logistics_returns_index').addClass('active');
        });

    </script>
@stop