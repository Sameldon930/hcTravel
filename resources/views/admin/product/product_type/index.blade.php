@extends('layouts.admin')

@section('pageTitle')
    商品类别列表
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        商品类别列表
        <div class="padding-top-sm">
            {{ Form::open(['method'=>'put','route' => ['admin.product_type.update','product_type'=>1]]) }}
            <button class="pretty-btn">商品类别修改</button>
            {{ Form::close() }}
        </div>
        <div class="padding-top-sm">
            {{ Form::open(['method'=>'post','route' => ['admin.product_type.store']]) }}
            <button class="pretty-btn">添加商品类别</button>
            {{ Form::close() }}
        </div>
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