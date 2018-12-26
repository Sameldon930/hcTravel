@extends('layouts.admin')

@section('pageTitle')
    商品列表
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        商品列表
        <div class="padding-top-sm">
            <a href="{{route('admin.product.show',['product'=>1])}}">
                <button class="pretty-btn">商品详情</button>
            </a>
        </div>
        <div class="padding-top-sm">
            <a href="{{route('admin.product.edit',['product'=>1])}}">
                <button class="pretty-btn">商品修改</button>
            </a>
        </div>
        <div class="padding-top-sm">
            <a href="{{route('admin.product.add')}}">
                <button class="pretty-btn">商品添加</button>
            </a>
        </div>
        <div class="padding-top-sm">
            {{ Form::open(['method'=>'delete','route' => ['admin.product.destroy','product'=>1]]) }}
            <button class="pretty-btn">商品删除</button>
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