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
            <div class="col-lg-4 col-sm-8 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">商家信息</div>
                    <div class="panel-body">
                        <div class="panel-item">
                            {{Form::label('id','商家名称:')}}
                            <span class="panel-value">
                                {{$data->business_name}}
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('area','所属区域:')}}
                            <span class="panel-value">
                               {{-- {{json_decode($data->province)->name.json_decode($data->city)->name.json_decode($data->area)->name}}--}}
                                {{\App\SmDormInfo::SITE[$data->site]}}
                            </span>
                        </div>

                        <div class="panel-item">
                            {{Form::label('mobile','店铺招牌:')}}
                            <span class="panel-value">
                                {{$data->merchant_name}}
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('mobile','法人姓名:')}}
                            <span class="panel-value">
                                {{$data->juridical_person}}
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('code','信用代码:')}}
                            <span class="panel-value">
                                {{$data->code}}
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('code','客服电话:')}}
                            <span class="panel-value">
                                {{$data->service_mobile}}
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('leader_name','商家名称:')}}
                            <span class="panel-value">
                                {{$data->leader_name}}
                            </span>
                        </div>

                        <div class="panel-item">
                            {{Form::label('sex','负责人性别:')}}
                            <span class="panel-value">
                                @if($data->sex)
                                    {{\App\SmDormInfo:: SEX[$data->sex]}}
                                @else
                                    未填写
                                @endif
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('leader_mobile','负责人手机:')}}
                            <span class="panel-value">
                                {{$data->leader_mobile}}
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('leader_email','负责人邮箱:')}}
                            <span class="panel-value">
                                {{$data->leader_email}}
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('leader_email','负责人QQ:')}}
                            <span class="panel-value">
                                {{$data->leader_qq}}
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('leader_email','负责人微信:')}}
                            <span class="panel-value">
                                {{$data->leader_wx}}
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('leader_email','经营资质:')}}
                            <span class="panel-value">
                                @if(json_decode($data->papers))
                                    @foreach(json_decode($data->papers) as $item)
                                        {{\App\SmDormInfo::PAPERS[$item]}},
                                    @endforeach
                                @endif

                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('leader_email','经营品类:')}}
                            <span class="panel-value">
                                @if(json_decode($data->type))
                                    @foreach(json_decode($data->type) as $item)
                                        {{\App\SmDormInfo::TYPE[$item]}},
                                    @endforeach
                                @endif
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('leader_email','经营品牌:')}}
                            <span class="panel-value">
                                @if(json_decode($data->brand))
                                    @foreach(json_decode($data->brand) as $item)
                                        {{\App\SmDormInfo::BRAND[$item]}},
                                    @endforeach
                                @endif
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('leader_email','主题特色:')}}
                            <span class="panel-value">
                                @if(json_decode($data->feature))
                                    @foreach(json_decode($data->feature) as $item)
                                        {{\App\SmDormInfo::FEATURE[$item]}},
                                    @endforeach
                                @endif
                            </span>
                        </div>

                        <div class="panel-item">
                            {{Form::label('leader_email','配套设施:')}}
                            <span class="panel-value">
                                @if(json_decode($data->config))
                                    @foreach(json_decode($data->config) as $item)
                                        {{\App\SmDormInfo::CONFIG[$item]}},
                                    @endforeach
                                @endif
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('leader_email','客房数量:')}}
                            <span class="panel-value">
                                {{$data->room_num}}
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('leader_email','最后装修时间:')}}
                            <span class="panel-value">
                                {{$data->adorn_time = date('Y-m-d',strtotime($data->adorn_time))}}
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('leader_email','投资规模及民宿特色:')}}
                            <span class="panel-value">
                                {{$data->trait}}
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('leader_email','营业收入/年(万元):')}}
                            <span class="panel-value">
                                    {{$data->earning}}
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('leader_email','租期:')}}
                            <span class="panel-value">
                                {{$data->lease}}
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('leader_email','入住率:')}}
                            <span class="panel-value">
                                {{$data->ratio}}
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('leader_email','均价:')}}
                            <span class="panel-value">
                                {{$data->price}}
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('leader_email','年租金(万元):')}}
                            <span class="panel-value">
                                {{$data->rent}}
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('leader_email','员工数量:')}}
                            <span class="panel-value">
                                {{$data->staff_num}}
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('leader_email','获奖情况:')}}
                            <span class="panel-value">
                                {{$data->awards}}
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('leader_email','受到处罚情况:')}}
                            <span class="panel-value">
                                {{$data->penalty}}
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('leader_email','民宿建议:')}}
                            <span class="panel-value">
                                {{$data->opinion or '无'}}
                            </span>
                        </div>
                        <div class="panel-item">
                            {{Form::label('leader_email','民宿困难:')}}
                            <span class="panel-value">
                                {{$data->hard or '无'}}
                            </span>
                        </div>

                        <div class="panel-item"> {{Form::label('leader_email','民宿美图:')}}</div>
                        <div class="swiper-container">

                            <div class="swiper-wrapper">
                                @if($data->img)
                                    @foreach(json_decode($data->img) as $value)
                                       <div class="swiper-slide">
                                           <img src="{{asset('storage/').'/'.$value}}"
                                                data-src="{{asset('storage/').'/'.$value}}"
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

@stop

@section('js')
    <script src="/js/swiper-4.3.3.min.js"></script>
    <script>

        $(document).ready(function () {
            $('#operation').addClass('active');
            $('#operation_dorm_index').addClass('active');
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


    </script>
@stop