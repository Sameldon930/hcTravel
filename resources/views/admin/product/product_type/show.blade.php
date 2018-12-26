@extends('layouts.admin')

@section('pageTitle')
    商品类型详情
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        商品类型详情
    </div>

@stop

@section('js')
    <script>

        $(document).ready(function () {
            $('#product').addClass('active');
            $('#product_product_type_index').addClass('active');
        });

    </script>
@stop