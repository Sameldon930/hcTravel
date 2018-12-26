@extends('layouts.admin')

@section('pageTitle')
    运营推广列表
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">

        <div class="padding-top-sm">
            <a href="{{route('admin.marketing.add')}}">
                <button class="pretty-btn">运营推广添加</button>
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
                <th>标题</th>
                <th>公司名</th>
                <th>联系电话</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            @foreach($datas as $data)
                <tr>
                    <td>{{$data->id}}</td>
                    <td>{{$data->title}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->mobile}}</td>
                    <td>
                        <div class="switch " data-target="operate-status"
                             data-url="{{route('admin.marketing.switch',
                                         ['marketing'=>$data->id])}}" data-id="{{$data->id}}"
                        >
                            <input type="checkbox" name="status" value="{{ $data->status }}"
                                   @if( $data->status == 1 ) checked @endif/>
                        </div>
                    </td>
                    <td><a href="{{route('admin.marketing.edit',['marketing'=>$data->id])}}" class="pretty-btn">修改</a>
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
            $('#serve').addClass('active');
            $('#serve_marketing_index').addClass('active');
        });

    </script>
@stop