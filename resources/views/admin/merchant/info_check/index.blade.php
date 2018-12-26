@extends('layouts.admin')

@section('pageTitle')
    信息审核
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">

        <div class="box-body">
            @include('component.search_form')
        </div>

        <div class="box-body">
            <table class="table table-common table-hover">
                <tr>
                    <th>姓名</th>
                    <th>商户号</th>
                    <th>手机</th>
                    <th>状态</th>
                    <th>类型</th>
                    <th>操作</th>
                </tr>
                @foreach($datas as $data)
                    <tr>
                        <td>{{$data->merchant->merchantInfo->merchant_principal??''}}</td>
                        <td>{{$data->merchant->id??''}}</td>
                        <td>{{$data->merchant->mobile??''}}</td>
                        <td>{{\App\VerifyLog::CHECK_AUDIT[$data->status]}}</td>
                        <td>{{\App\VerifyLog::VERIFY_TYPE[$data->type]}}</td>
                        <td>
                            @if($data->status == \App\VerifyLog::IN_AUDIT)
                                <a href="{{route('admin.info_check.show',['info_check'=>$data->id])}}">
                                    <button class="pretty-btn">审核</button>
                                </a>
                            @else
                                <button class="pretty-btn" disabled>审核</button>
                            @endif

                        </td>
                    </tr>
                @endforeach

            </table>

            <div class="text-center">{{ links_custom($datas, $search_items) }}</div>
        </div>
    </div>

@endsection

@section('js')
    @yield('date_search')
    <script>

        $(document).ready(function () {
            $('#merchant').addClass('active');
            $('#merchant_info_check_index').addClass('active');
        });

    </script>
@endsection