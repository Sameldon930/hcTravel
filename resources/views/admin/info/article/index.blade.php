@extends('layouts.admin')

@section('pageTitle')
    文章列表
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        <div class="padding-top-sm">
            <a href="{{route('admin.article.add')}}">
                <button class="pretty-btn">添加文章</button>
            </a>
        </div>

    </div>

    <div class="box-body">
        @include('component.search_form')
    </div>

    <div class="box-body">
        <table class="table table-common table-hover">
            <tr>
                <th>ID</th>
                <th>管理员Id</th>
                <th>文章分组</th>
                <th>文章标题</th>
                <th>缩略图</th>
                <th>阅读数</th>
                <th>开关</th>
                <th>操作</th>
            </tr>
            @foreach($datas as $data)
                <tr>
                    <td>{{$data->id}}</td>
                    <td>{{$data->admin_id}}</td>
                    <td>{{$data->articleGroup->name}}</td>
                    <td>{{$data->title}}</td>
                    <td><img src="{{asset('storage/serve').'/'.old_or_new_field('thumbnail',$data)}}"
                             style="height:50px; width:50px;line-height: 130px;margin-left:10px;"></td>
                    <td>{{$data->ready}}</td>
                    <td>
                        <div class="switch " data-target="operate-status"
                             data-url="{{route('admin.article.switch',
                                         ['article'=>$data->id])}}" data-id="{{$data->id}}"
                        >
                            <input type="checkbox" name="status" value="{{ $data->status }}"
                                   @if( $data->status == 1 ) checked @endif/>
                        </div>
                    </td>
                    <td><a href="{{route('admin.article.edit',['article'=>$data->id])}}" class="pretty-btn">文章内容修改</a>
                    </td>
                </tr>
            @endforeach

        </table>

        <div class="text-center">{{ links_custom($datas, $search_items) }}</div>
    </div>

@stop

@section('js')
    @yield('date_search')
    <script>

        $(document).ready(function () {
            $('#info').addClass('active');
            $('#info_article_index').addClass('active');
        });

    </script>
@stop