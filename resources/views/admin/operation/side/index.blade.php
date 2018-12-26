@extends('layouts.admin')

@section('pageTitle')
    幻灯片列表
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')

    <div class="box">
        <div class="padding-top-sm">
            <a href="{{route('admin.side.add')}}">
                <button class="pretty-btn">幻灯片添加</button>
            </a>
        </div>

    </div>
    <div class="box-body">
        <table class="table table-common table-hover">
            <tr>
                <th>ID</th>
                <th>缩略图</th>
                <th>跳转链接</th>
                <th>备注</th>
                <th>排序值</th>
                <th>开关</th>
                <th>操作</th>
            </tr>
            @foreach($datas as $data)
                <tr>
                    <td>{{$data->id}}</td>
                    <td><img src="{{asset('storage/serve').'/'.old_or_new_field('image',$data)}}"
                             style="height:50px; width:50px;line-height: 130px;margin-left:10px;"></td>
                    <td>{{$data->url}}</td>
                    <td>{{$data->note}}</td>
                    <td>{{$data->orderby}}</td>
                    <td>
                        <div class="switch " data-target="operate-status"
                             data-url="{{route('admin.side.switch',
                                         ['sides'=>$data->id])}}" data-id="{{$data->id}}"
                        >
                            <input type="checkbox" name="status" value="{{ $data->status }}"
                                   @if( $data->status == 1 ) checked @endif/>
                        </div>
                    </td>
                    <td><a href="{{route('admin.side.edit',['sides'=>$data->id])}}">
                            <button class="pretty-btn">幻灯片修改</button>
                        </a></td>
                </tr>
            @endforeach

        </table>
    </div>
@stop

@section('js')
    <script>

        $(document).ready(function () {
            $('#operation').addClass('active');
            $('#operation_side_index').addClass('active');
        });

    </script>
@stop
