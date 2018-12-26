@extends('layouts.admin')

@section('pageTitle')
    公告通知
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        <div class="padding-top-sm">
            <a href="{{route('admin.notify.add')}}">
                <button class="pretty-btn">添加公告通知</button>
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
                <th>公告标题</th>
                <th>开关</th>
                <th>公告类型</th>
                <th>操作</th>
            </tr>
            @foreach($datas as $data)
                <tr>
                    <td>{{$data->id}}</td>
                    <td>{{$data->admin_id}}</td>
                    <td>{{$data->title}}</td>
                    <td>
                        <div class="switch " data-target="operate-status"
                             data-url="{{route('admin.notify.switch',
                                         ['notify'=>$data->id])}}" data-id="{{$data->id}}"
                        >
                            <input type="checkbox" name="status" value="{{ $data->status }}"
                                   @if( $data->status == 1 ) checked @endif/>
                        </div>
                    </td>
                    <td>{{$data->type}}</td>
                    <td><a href="{{route('admin.notify.edit',['notify'=>$data->id])}}" class="pretty-btn">公告内容修改</a>
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
            $('#operation').addClass('active');
            $('#operation_notify_index').addClass('active');
        });

    </script>
@stop
