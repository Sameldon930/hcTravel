@extends('layouts.admin')

@section('pageTitle')
    民宿统计列表
@stop

@section('css')
    <style>
        .dorm_info{
            font-size: 15px;
            padding-right: 10px;
        }
        .info_red{
            color:#ff0000;
        }
    </style>
@stop

@section('content')

    <div class="box">
        {{--<form action="{{route('admin.dorm.import')}}" method="post" enctype="multipart/form-data" class="form box-body">
            <input type="file" class="btn "
                   accept="text/csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="file_data"/>
            {{ csrf_field() }}
            <button type="submit" class="pretty-btn pull-left" style="margin-top: 10px">将民宿信息同步</button>
        </form>--}}
        <div class="box-body">
            @include('component.search_form',['export'=>'list_export'])
        </div>
        <div class="box-body" >
            <div>
                <span class="dorm_info">完成率： <span class="info_red">{{sprintf("%.2f", 100*($all->count()/347))}}</span> %</span>
            </div>
            <div >
                <span class="dorm_info">总计 <span class="info_red">347</span> 家民宿;</span>
                <span class="dorm_info">已录入 <span class="info_red">{{$all->count()}}</span> 家民宿;</span>
            </div>
            <div>
                <span class="dorm_info">黄厝社录入<span class="info_red">{{$all->where('site',1)->count()}}</span> 家民宿;</span>
                <span class="dorm_info">塔头社录入 <span class="info_red">{{$all->where('site',2)->count()}}</span> 家民宿;</span>
            </div>
            <div>
                <span class="dorm_info">茂后社录入 <span class="info_red">{{$all->where('site',3)->count()}}</span> 家民宿;</span>
                <span class="dorm_info">溪头下社录入 <span class="info_red">{{$all->where('site',4)->count()}}</span> 家民宿;</span>
            </div>

        </div>
    <div class="box-body">
        <table class="table table-common table-hover">
            <tr>
                <th>商家编号</th>
                <th>商家简称</th>
                <th>法人</th>
                <th>负责人</th>
                <th>负责人手机</th>
                <th>所属区域</th>
                <th>操作</th>
            </tr>
            @foreach($datas as $data)
                <tr>
                    <td>{{$data->merchant->id}}</td>
                    <td>{{$data->merchant_name}}</td>
                    <td>{{$data->juridical_person}}</td>
                    <td>{{$data->leader_name}}</td>
                    <td>{{$data->leader_mobile}}</td>
                    <td>
                        @if($data->site)
                       {{\App\SmDormInfo::SITE[$data->site]}}
                            @else
                            暂未填写
                        @endif

                    </td>
                    <td>
                        <a class="pretty-btn" href="{{route('admin.dorm.show',['dorm'=>$data->id])}}">详情</a>
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
            $('#operation_dorm_index').addClass('active');
        });

    </script>
@stop
