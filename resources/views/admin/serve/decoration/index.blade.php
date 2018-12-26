@extends('layouts.admin')

@section('pageTitle')
    装修服务列表
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        <div class="padding-top-sm">
            <a href="{{route('admin.decoration.add')}}">
                <button class="pretty-btn">装修服务添加</button>
            </a>
        </div>

        <div class="box-body">
            @include('component.search_form')
        </div>

        <div class="box-body">
            <table class="table table-common table-hover">
                <tr>
                    <th>ID</th>
                    <th>标题</th>
                    <th>类别</th>
                    <th>店名</th>
                    <th>联系电话</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                @foreach($datas as $data)
                    <tr>
                        <td>{{$data->id}}</td>
                        <td>{{$data->title}}</td>
                        <td>{{\App\Decoration::TYPE_ARRAY[$data->type]}}</td>
                        <td>{{$data->name}}</td>
                        <td>{{$data->mobile}}</td>
                        <td>
                            <div class="switch " data-target="operate-status"
                                 data-url="{{route('admin.decoration.switch',
                                         ['decoration'=>$data->id])}}" data-id="{{$data->id}}"
                            >
                                <input type="checkbox" name="status" value="{{ $data->status }}"
                                       @if( $data->status == 1 ) checked @endif/>
                            </div>
                        </td>
                        <td><a href="{{route('admin.decoration.edit',['decoration'=>$data->id])}}"
                               class="pretty-btn">修改</a></td>
                    </tr>
                @endforeach

            </table>

            <div class="text-center">{{ links_custom($datas, $search_items) }}</div>
        </div>
    </div>

@stop

@section('js')
    @yield('date_search')
    <script>

        $(document).ready(function () {
            $('#serve').addClass('active');
            $('#serve_decoration_index').addClass('active');
        });

    </script>
@stop