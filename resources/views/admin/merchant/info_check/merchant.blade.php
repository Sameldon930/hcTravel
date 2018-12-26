@extends('layouts.admin')

@section('pageTitle')
    信息审核
@stop

@section('css')
    <link rel="stylesheet" href="/css/swiper-4.3.3.min.css">
    <style>
        .form-group img {
            height: 150px;
            width: 150px;
            text-align: center;
            line-height: 130px;
            font-size: 20px;
            color: #666666;
        }

        #feedback {
            width: 500px;
        }

        .info-title {
            font-size: 20px;
            font-weight: bold;
            padding-bottom: 20px;
        }

        .info-block {
            padding: 40px;
            border: 2px solid black;
        }

        .form-group img {
            padding-left: 20px;
        }

        .panel {
            background-color: #fff;
            border-radius: 0;
            -webkit-box-shadow: 0px 5px 2px #eee;
            box-shadow: 0px 5px 2px #eee;
            border: 1px solid #eee;
        }

        .panel-default > .panel-heading {
            border-radius: 0;
            border: 0;
            border-bottom: 3px solid #ff6a4a;
            background-color: #fff;
            font-size: 1.4em;
        }

        .panel-item {
            font-size: 1.1em;
            margin-top: 6px;
            margin-bottom: 6px;
        }

        .panel-item > label {
            color: #aaa;
            font-weight: 400;
            width: 126px;

            font-size: 1.1em;
        }

        .panel-value {
            color: #303030;
            font-size: 1.1em;
        }

        .panel-value img {
            max-height: 100px;
        }

        .panel-body .swiper-container img {
            margin: 0 auto 20px auto;
            max-height: 300px;
        }
    </style>
@stop

@section('content')
    <div class="box ">

        <div class="row">
            <div class="col-lg-6 col-sm-8  col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">商户信息</div>
                    <div class="panel-body">
                        <div class="panel-item">
                            {{Form::label('number','商户编号:')}}
                            <span class="panel-value">
                                {{$data->merchant->id}}
                            </span>
                        </div>

                        <div class="panel-item">
                            {{Form::label('mobile','商户手机号:')}}
                            <span class="panel-value">
                                {{$data->merchant->mobile}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-6 col-sm-8  col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">店铺信息</div>
                    <div class="panel-body">
                        <div class="panel-item">
                            {{Form::label('name','店铺负责人:')}}
                            <span class="panel-value">
                                {{$data->verify_success->merchant_principal}}
                            </span>
                        </div>

                        <div class="panel-item">
                            {{Form::label('name','店铺名称:')}}
                            <span class="panel-value">
                                {{$data->verify_success->merchant_name}}
                            </span>
                        </div>

                        <div class="panel-item">
                            {{Form::label('name','店铺简称:')}}
                            <span class="panel-value">
                                {{$data->verify_success->merchant_short_name}}
                            </span>
                        </div>

                        <div class="panel-item">
                            {{Form::label('name','店铺地址：')}}
                            <span class="panel-value">
                                {{$data->verify_success->merchant_address}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-6 col-sm-8  col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">营业执照信息</div>
                    <div class="panel-body">
                        <div class="panel-item">
                            {{Form::label('name','名称：')}}
                            <span class="panel-value">
                                {{$data->verify_success->business_name}}
                            </span>
                        </div>

                        <div class="panel-item">
                            {{Form::label('name','注册号：')}}
                            <span class="panel-value">
                                {{$data->verify_success->business_num}}
                            </span>
                        </div>

                        <div class="panel-item">
                            {{Form::label('name','营业执照法人：')}}
                            <span class="panel-value">
                                {{$data->verify_success->business_person}}
                            </span>
                        </div>

                        <div class="panel-item">
                            {{Form::label('name','营业执照注册地址：')}}
                            <span class="panel-value">
                                {{$data->verify_success->business_address}}
                            </span>
                        </div>

                        <div class="panel-item">
                            {{Form::label('name','营业执照：')}}
                            <span class="panel-value">
                                <img src="{{asset('storage/').'/'.$data->verify_success->business_img}}"
                                     data-src="{{asset('storage/').'/'.$data->verify_success->business_img}}"
                                     data-magnify="gallery">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-6 col-sm-8  col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">法人身份证信息</div>
                    <div class="panel-body">
                        <div class="panel-item">
                            {{Form::label('name','身份证姓名：')}}
                            <span class="panel-value">
                                {{$data->verify_success->identity_name}}
                            </span>
                        </div>

                        <div class="panel-item">
                            {{Form::label('name','身份证号：')}}
                            <span class="panel-value">
                                {{$data->verify_success->identity_num}}
                            </span>
                        </div>

                        <div class="panel-item">
                            {{Form::label('identity_front','身份证正面照:')}}
                            <span class="panel-value">
                                <img src="{{asset('storage/').'/'.$data->verify_success->identity_front}}"
                                     data-src="{{asset('storage/').'/'.$data->verify_success->identity_front}}"
                                     data-magnify="gallery">
                            </span>
                        </div>

                        <div class="panel-item">
                            {{Form::label('identity_contrary','身份证反面照:')}}
                            <span class="panel-value">
                                <img src="{{asset('storage/').'/'.$data->verify_success->identity_contrary}}"
                                     data-src="{{asset('storage/').'/'.$data->verify_success->identity_contrary}}"
                                     data-magnify="gallery">
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-8  col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">租赁合同信息</div>
                    <div class="panel-body">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                @if($data->verify_success->contract_tenancy)
                                    @foreach(json_decode($data->verify_success->contract_tenancy) as $img)
                                        <div class="swiper-slide">
                                            <img src="{{asset('storage/').'/'.$img}}"
                                                 data-src="{{asset('storage/').'/'.$img}}"
                                                 data-magnify="gallery" class="img-responsive">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="swiper-scrollbar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-8  col-xs-12">
                {{ Form::open(['method'=>'put','route' => ['admin.info_check.update','info_check'=>$data->id],'id'=>'success_form']) }}
                <button type="button" class="btn pretty-btn  " onclick="success_audit()">审核通过</button>
                {{Form::text('status',\App\VerifyLog::SUCCESS_AUDIT,['class'=>'form-input hide'])}}
                {{ Form::close() }}
            </div>


        </div>

        <div class="row">
            <div class="col-lg-4 col-sm-6 col-xs-12">
                {{ Form::open(['method'=>'put','route' => ['admin.info_check.update','info_check'=>$data->id],'id'=>'fail_form']) }}

                {{Form::text('status',\App\VerifyLog::FAIL_AUDIT,['class'=>'form-input hide'])}}
                <div class="form-group " style="margin-top: 10px">
                    {{Form::label('feedback','不通过原因:')}}
                    {{Form::text('feedback','',['class'=>'form-input','id'=>'feedback'])}}
                </div>
                <button type="button" class="pretty-btn pretty-btn-danger" style="margin-top: 10px"
                        onclick="fail_audit()">审核不通过
                </button>
                {{ Form::close() }}
            </div>
        </div>

    </div>

@stop

@section('js')
    <script src="/js/swiper-4.3.3.min.js"></script>
    <script>

        $(document).ready(function () {
            $('#merchant').addClass('active');
            $('#merchant_info_check_index').addClass('active');

            var mySwiper = new Swiper('.swiper-container', {
                loop: false,
                lazy: true,
                mousewheel: true,

                // 如果需要滚动条
                scrollbar: {
                    el: '.swiper-scrollbar',
                },

                on: {
                    tap: function (e) {
                        console.log(e)
                    },
                },
            })
        });

        function success_audit() {
            if (confirm('确认通过商户认证吗?')) {
                $('#success_form').submit();
            }

        }

        function fail_audit() {
            if ($('#feedback').val() == '') {
                alert('请输出拒绝原因');

            } else {
                if (confirm("你确定此拒绝操作吗？")) {
                    $('#fail_form').submit();
                }
            }
        }

    </script>
@stop