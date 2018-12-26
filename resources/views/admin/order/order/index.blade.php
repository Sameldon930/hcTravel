@extends('layouts.admin')

@section('pageTitle')
    订单列表
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        订单列表
    </div>

@stop

@section('js')
    <script>

        $(document).ready(function () {
            $('#order').addClass('active');
            $('#order_order_index').addClass('active');
        });

    </script>
@stop