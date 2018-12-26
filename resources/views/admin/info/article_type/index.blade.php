@extends('layouts.admin')

@section('pageTitle')
    文章分类
@stop

@section('css')


    <style>


    </style>
@stop

@section('content')
    {{--<div class="box">
        <div class="padding-top-sm">
            <a href="{{route('admin.article_type.add')}}">
                <button class="pretty-btn">添加文章分类</button>
            </a>
        </div>

    </div>--}}
    <div class="box-body">
        <table class="table table-common table-hover">
            <tr>
                <th>ID</th>
                <th>文章类别</th>
                <th>开关</th>
                <th>操作</th>
            </tr>
            @foreach($datas as $data)
                <tr>
                    <td>{{$data->id}}</td>
                    <td>{{$data->name}}</td>
                    <td>
                        <div class="switch " data-target="operate-status"
                             data-url="{{route('admin.article_type.switch',
                                         ['article'=>$data->id])}}" data-id="{{$data->id}}"
                        >
                            <input type="checkbox" name="status" value="{{ $data->status }}"
                                   @if( $data->status == 1 ) checked @endif/>
                        </div>
                    </td>
                    <td><a href="{{route('admin.article_type.edit',['article'=>$data->id])}}"
                           class="pretty-btn">文章类别修改</a></td>
                </tr>
            @endforeach

        </table>
    </div>
@stop

@section('js')
    <script>

        $(document).ready(function () {
            $('#info').addClass('active');
            $('#info_article_type_index').addClass('active');
        });

    </script>
@stop