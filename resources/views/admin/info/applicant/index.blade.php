{{--@section('content')--}}
    {{--<div class="box">--}}
        {{--求职列表--}}
        {{--<div class="padding-top-sm">--}}
            {{--<a href="{{route('admin.applicant.show',['applicant'=>1])}}"><button class="pretty-btn" >求职详情</button></a>--}}
        {{--</div>--}}
        {{--<div class="padding-top-sm">--}}
            {{--<a href="{{route('admin.applicant.edit',['applicant'=>1])}}"><button class="pretty-btn" >求职修改</button></a>--}}
        {{--</div>--}}
        {{--<div class="padding-top-sm">--}}
            {{--<a href="{{route('admin.applicant.add')}}"> <button class="pretty-btn" >求职添加</button></a>--}}
        {{--</div>--}}
        {{--<div class="padding-top-sm">--}}
            {{--<a href="{{route('admin.applicant.switch',['applicant'=>1])}}"><button class="pretty-btn">求职开关</button></a>--}}
        {{--</div>--}}
    {{--</div>--}}

{{--@stop--}}

@extends('layouts.admin')

@section('pageTitle')
    求职列表
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        <div class="padding-top-sm">
            <a href="{{route('admin.applicant.add')}}"> <button class="pretty-btn" >求职添加</button></a>
        </div>
    </div>
    <div class="box-body">
        @include('component.search_form')
    </div>

    <div class="box-body">
        {{--<div class="padding-top-sm">--}}
        {{--<a href="{{route('admin.applicant.show',['applicant'=>1])}}"><button class="pretty-btn" >求职详情</button></a>--}}
        {{--</div>--}}

        <table class="table table-common table-hover">
            <tr>
                <th>ID</th>
                <th>姓名</th>
                <th>性别</th>
                <th>年龄</th>
                <th>求职意向</th>
                <th>工作经验</th>
                <th>学历</th>
                <th>联系电话</th>
                <th>页面显示</th>
                <th>操作</th>
            </tr>
            @foreach($datas as $data)
                <tr>
                    <td>{{$data->id}}</td>
                    <td>{{$data->name}}</td>
                    <td> {{ \App\Applicant::SEX[$data->sex]}}</td>
                    <td>{{$data->age}}</td>
                    <td>{{$data->apply_position}}</td>
                    <td>{{$data->work_experience}}</td>
                    <td>{{\APP\Applicant::EDUCATIONS[$data->education]}}</td>
                    <td>{{$data->mobile}}</td>
                    <td>
                        <div class="switch"  data-target="operate-status"
                               data-url="{{route('admin.applicant.switch',
                                         ['applicant'=>$data->id])}}"data-id="{{$data->id}}"
                        >
                            <input type="checkbox" name="is_hidden" value="{{ $data->is_hidden }}"
                                   @if( $data->is_hidden == 'F' ) checked @endif/>
                        </div>
                    </td>
                    <td> <a href="{{route('admin.applicant.edit',['applicant'=>$data->id])}}" class="pretty-btn">应聘信息修改</a></td>
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
            $('#info_applicant_index').addClass('active');
        });

    </script>
@stop
