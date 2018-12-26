@extends('layouts.admin')

@section('pageTitle')
    商户列表
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
   {{-- <form action="{{route('admin.merchant.import')}}" method="post" enctype="multipart/form-data" class="form box-body">
        <input type="file" class="btn "
               accept="text/csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="file_data"/>
        {{ csrf_field() }}
        <button type="submit" class="pretty-btn pull-left" style="margin-top: 10px">导入商户</button>
    </form>--}}
    <div style="padding: 10px;">
        <a href="{{route('admin.merchant.add')}}" class="pretty-btn" >添加商户</a>
    </div>
    <div class="box-body">
        @include('component.search_form')
    </div>
    <div class="box-body margin-top-md">
        <table class="table table-common table-hover">
            <tr>
                <th>商户编号</th>
                <th>商家店铺名</th>
                <th>缩略图</th>
                <th>手机</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            @foreach($datas as $data)
                <tr>
                    <td>{{$data->id}}</td>
                    <td>
                        @if($data->merchantInfo)
                            {{$data->merchantInfo->merchant_name}}
                        @endif
                    </td>
                    <td><img src="{{asset('storage/serve').'/'.old_or_new_field('thumbnail',$data->merchantInfo)}}"
                             style="height:50px; width:50px;line-height: 130px;margin-left:10px;">
                    </td>
                    <td>{{$data->mobile}}</td>
                    <td>{{ \App\Merchant::MERCHANT_STATUS[\App\Merchant::getStatus($data,'merchant')]}}</td>
                    <td>
                        <a class="pretty-btn" href="{{route('admin.merchant.show',['merchant'=>$data->id])}}">编辑</a>
                        {{--<a class="pretty-btn pretty-btn-danger" href="{{route('admin.merchant.destroy',['merchant'=>$data->id])}}" >删除</a>--}}
                    <a class="pretty-btn pretty-btn-danger user_del" href="#" onclick="del_user({{ $data->id }})" >删除</a>
                    {{--<a class="pretty-btn" href="{{route('admin.merchant.add_img',['merchant'=>$data->id])}}">添加图片</a></td>--}}
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
            $('#merchant').addClass('active');
            $('#merchant_merchant_index').addClass('active');
        });

        function del_user(id) {
            if (window.confirm("您确定要删除吗？")){
                window.location.href="{{route('admin.merchant.destroy',['merchant'=>0])}}"+id
            }
        }

    </script>
@stop