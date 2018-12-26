@extends('layouts.admin')

@section('pageTitle')
    商品修改/添加
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        商品修改/添加页面
        <div class="padding-top-sm">
            {{ Form::open(['method'=>'put','route' => ['admin.product.update','product'=>1]]) }}
            <button class="pretty-btn">商品修改</button>
            {{ Form::close() }}
        </div>
        <div class="padding-top-sm">
            {{ Form::open(['method'=>'post','route' => ['admin.product.store']]) }}
            <button class="pretty-btn">添加商品</button>
            {{ Form::close() }}
        </div>
    </div>

@stop

@section('js')
    <script>

        $(document).ready(function () {
            $('#product').addClass('active');
            $('#product_product_index').addClass('active');
        });

    </script>
@stop