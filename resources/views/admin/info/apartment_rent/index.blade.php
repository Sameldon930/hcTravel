@extends('layouts.admin')

@section('pageTitle')
    招租列表
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        <div class="padding-top-sm">
            <a href="{{route('admin.apartment_rent.add')}}">
                <button class="pretty-btn"> 招租添加</button>
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
                <th>租金</th>
                <th>缩略图</th>
                <th>详情图</th>
                <th>房屋类型</th>
                <th>租凭方式</th>
                <th>支付方式</th>
                <th>所属区域</th>
                <th>联系电话</th>
                <th>招租详情</th>
                <th>页面显示</th>
                <th>操作</th>
            </tr>
            @foreach($datas as $data)
                <tr>
                    <td>{{$data->id}}</td>
                    <td>{{$data->title}}</td>
                    <td>{{$data->rental}}</td>
                    <td><img src="{{asset('storage/serve').'/'.old_or_new_field('thumbnail',$data)}}"
                             style="height:50px; width:50px;line-height: 130px;margin-left:10px;"></td>
                    <td><img src="{{asset('storage/serve').'/'.old_or_new_field('image',$data)}}"
                             style="height:50px; width:50px;line-height: 130px;margin-left:10px;"></td>
                    <td>{{$data->house_type}}</td>
                    <td>{{$data->rent_way}}</td>
                    <td>{{$data->payment_mode}}</td>
                    <td>{{$data->region}}</td>
                    <td>{{$data->mobile}}</td>
                    <td>{{$data->content}}</td>
                    <td>
                        <div class="switch" data-target="operate-status"
                             data-url="{{route('admin.apartment_rent.switch',
                                         ['applicant'=>$data->id])}}" data-id="{{$data->id}}"
                        >
                            <input type="checkbox" name="is_hidden" value="{{ $data->is_hidden }}"
                                   @if( $data->is_hidden == 'F' ) checked @endif/>
                        </div>
                    </td>
                    <td><a href="{{route('admin.apartment_rent.edit',['apartment_rent'=>$data->id])}}"
                           class="pretty-btn">修改</a></td>
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
            $('#info_apartment_rent_index').addClass('active');
        });

    </script>
@stop
