@extends('layouts.admin')

@section('pageTitle')
    审核详情
@stop

@section('css')
    <link rel="stylesheet" href="/css/swiper-4.3.3.min.css">
    <style>
        .form-group  img {
            height: 150px;
            width: 150px;
            text-align: center;
            line-height: 130px;
            font-size: 20px;
            color: #666666;
        }
        #feedback{
            width: 500px;
        }
        .info-title{
            font-size: 20px;
            font-weight: bold;
            padding-bottom: 20px;
        }
        .info-block{
            padding: 40px;
            border: 2px solid black;
        }
        .form-group img{
            padding-left: 20px;
        }


        .panel {
            background-color: #fff;
            border-radius: 0;
            -webkit-box-shadow: 0px 5px 2px #eee;
            box-shadow: 0px 5px 2px #eee;
            border: 1px solid #eee;
        }
        .panel-default>.panel-heading {
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
    <div class="box">

        <div class="row">
            <div class="col-lg-6 col-sm-8 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">商户信息</div>
                    <div class="panel-body">
                        <div class="panel-item">
                            {{Form::label('id','商户编号:')}}
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
            <div class="col-lg-6 col-sm-8 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">房屋鉴定</div>
                    <div class="panel-body">
                        <div class="panel-item">
                            {{Form::label('name','房屋鉴定图:')}}
                            <span class="panel-value">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        @if($data->verify_success->img)
                                            @foreach(json_decode($data->verify_success->img) as $img)
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
                            </span>
                        </div>

                        <div class="panel-item">
                            {{Form::label('name','房屋审批报告编号:')}}
                            <span class="panel-value">
                                {{$data->verify_success->code}}
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-8 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">房屋鉴定附件</div>
                    <div class="panel-body">
                        <div class="panel-item">
                            {{Form::label('address_img','公共场所地址方位示意图：')}}
                            <span class="panel-value">
                                <img src="{{asset('storage/').'/'.$data->verify_success->address_img}}"
                                     data-src="{{asset('storage/').'/'.$data->verify_success->address_img}}"
                                     data-magnify="gallery">
                            </span>
                        </div>

                        <div class="panel-item">
                            {{Form::label('system_img','公共制度：')}}
                            <span class="panel-value">
                                <img src="{{asset('storage/').'/'.$data->verify_success->system_img}}"
                                     data-src="{{asset('storage/').'/'.$data->verify_success->system_img}}"
                                     data-magnify="gallery">
                            </span>
                        </div>
                        
                        <div class="panel-item">
                            {{Form::label('duty_img','黄厝社区民宿经营责任协议书：')}}
                            <span class="panel-value">
                                    <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                       @if($data->verify_success->duty_img)
                                            @foreach(json_decode($data->verify_success->duty_img) as $img)
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
                            </span>
                        </div>

                        <div class="panel-item">
                            {{Form::label('mass_img','建筑结构质量鉴定委托书：')}}
                            <span class="panel-value">
                                 <img src="{{asset('storage/').'/'.$data->verify_success->mass_img}}"
                                      data-src="{{asset('storage/').'/'.$data->verify_success->mass_img}}"
                                      data-magnify="gallery">
                            </span>
                        </div>

                        <div class="panel-item">
                            {{Form::label('safe_img','民宿业治安管理制度：')}}
                            <span class="panel-value">
                                <img src="{{asset('storage/').'/'.$data->verify_success->safe_img}}"
                                     data-src="{{asset('storage/').'/'.$data->verify_success->safe_img}}"
                                     data-magnify="gallery">
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('self_img','厦门市个体工商户安全生产标准化建设自评表：')}}
                            <span class="panel-value">
                                <img src="{{asset('storage/').'/'.$data->verify_success->self_img}}"
                                     data-src="{{asset('storage/').'/'.$data->verify_success->self_img}}"
                                     data-magnify="gallery">
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('audit_img','厦门市民宿经营申报联合核验表：')}}
                            <span class="panel-value">
                                <img src="{{asset('storage/').'/'.$data->verify_success->audit_img}}"
                                     data-src="{{asset('storage/').'/'.$data->verify_success->audit_img}}"
                                     data-magnify="gallery">
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('accredit_img','授权委托书：')}}
                            <span class="panel-value">
                                <img src="{{asset('storage/').'/'.$data->verify_success->accredit_img}}"
                                     data-src="{{asset('storage/').'/'.$data->verify_success->accredit_img}}"
                                     data-magnify="gallery">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-sm-6 col-xs-12">
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
                <button type="button" class="pretty-btn pretty-btn-danger"  style="margin-top: 10px" onclick="fail_audit()">审核不通过</button>
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

            var mySwiper = new Swiper ('.swiper-container', {
                loop: false,
                lazy: true,
                mousewheel: true,

                // 如果需要滚动条
                scrollbar: {
                    el: '.swiper-scrollbar',
                },

                on:{
                    tap: function(e){
                        console.log(e)
                    },
                },
            })

        });
        function success_audit() {
                if (confirm('确认通过房屋鉴定吗?')) {
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