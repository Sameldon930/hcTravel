@extends('layouts.admin')

@section('pageTitle')
    商户详情
@stop

@section('css')
    <link rel="stylesheet" href="/css/swiper-4.3.3.min.css">
    <link href="{{ asset('/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
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
            max-height: 200px;
        }
        .panel-body .swiper-container img {
            margin: 0 auto 20px auto;
            max-height: 300px;
        }
        .thumnail-img {
            font-size: 1.1em;
            margin-top: 6px;
            margin-bottom: 6px;
        }
    </style>
@stop

@section('content')
    <div class="box">

        <div class="row">
            <div class="col-lg-6 col-sm-8  col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">商户信息</div>
                    <div class="panel-body">
                        <div class="panel-item">
                            {{Form::label('id','商户编号:')}}
                            <span class="panel-value">
                                {{$data->id}}
                            </span>
                        </div>

                        <div class="panel-item">
                            {{Form::label('mobile','商户手机号:')}}
                            <span class="panel-value">
                                {{$data->mobile}}
                            </span>
                        </div>

                        <div class="panel-item">
                            {{Form::label('mobile','认证情况:')}}
                            <span class="panel-value">
                                {{ \App\Merchant::MERCHANT_STATUS[\App\Merchant::getStatus($data,'merchant')]}}

                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-sm-8  col-xs-12">
                <div class="panel panel-default">
                    {{ Form::open(['method'=>'post','route' => ['admin.merchant.add_img_store'],'enctype'=>'multipart/form-data']) }}
                    <div class="panel-heading">商户信息</div>
                    <div class="panel-body">
                        <input type="hidden" name="id" value="{{$data->id}}">
                        <div class=" form-group">
                            {{Form::label('time','营业时间(取整)')}}
                            {{Form::text('time',old_or_new_field('time',$data->merchantInfo),['class'=>'form-input'])}}
                        </div>
                        <div class=" form-group">
                            {{Form::label('merchant_address','商家地址')}}
                            {{Form::text('merchant_address',old_or_new_field('merchant_address',$data->merchantInfo),['class'=>'form-input'])}}
                        </div>
                        <div class=" form-group">
                            {{Form::label('merchant_name','商家店铺名')}}
                            {{Form::text('merchant_name',old_or_new_field('merchant_name',$data->merchantInfo),['class'=>'form-input'])}}
                        </div>
                        <div class=" form-group">
                            {{Form::label('score','评分(取整)')}}
                            {{Form::text('score',old_or_new_field('score',$data->merchantInfo),['class'=>'form-input'])}}
                        </div>
                        <div class="form-group has-error has-feedback">
                            <label  style="color: black;" class="control-label" for="register">
                                <span class="font-red">*</span>注册时间：</label>
                            <div style="width:400px;border-color: #ccc;" class="input-group">
                                <div style="border-color: #ccc;" class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input style="border-color: #ccc;"  class="form-control date validate" name="register" id="register" required
                                       value="{{old_or_new_field('register',$data->merchantInfo)}}">
                            </div>

                        </div>
                        <div class=" form-group">
                            <?php $hasUrl = old_or_new_field('thumbnail', $data); ?>
                            <div class="form-group {{!$hasUrl or 'has-error'}} has-feedback">
                                <label class="control-label" for="file">
                                    <span class="font-red">*</span>
                                    <span>缩略图:</span>
                                    <span class="font-gray">(宽高为120px:120px)：</span>
                                </label>
                                <div class="input-group">
                                    @if( $hasUrl )
                                        <input type="file" class="file-preview form-control" name="file" id="file" accept="image/*"
                                               value="{{ old_or_new_field('thumbnail',$data) }}">
                                    @else
                                        <input type="file" class="file-preview form-control validate" name="file"
                                               @if( !isset($data->merchantInfo->thumbnail)) required @endif
                                               id="file" accept="image/*"
                                               value="">
                                    @endif
                                        <input type="hidden" class="file-preview form-control validate" name="file_1" value="{{$hasUrl?$hasUrl:($data->merchantInfo->thumbnail??'')}}">
                                </div>
                            </div>
                            <div class="file-preview-wrap">
                                <img
                                        @if( old_or_new_field('thumbnail',$data) )
                                            src="{{asset('storage/serve').'/'.old_or_new_field('thumbnail',$data)}}" data-src="{{ asset('storage/serve'.old_or_new_img('thumbnail', $data, false))}}"
                                        @else
                                            src="{{asset('storage/serve').'/'. (isset($data->merchantInfo->thumbnail)?$data->merchantInfo->thumbnail:' ')}}" data-src="{{ asset('storage/serve').'/'. (isset($data->merchantInfo->thumbnail)?$data->merchantInfo->thumbnail:' ')}}"
                                        @endif
                                        id="file-preview" class="img-thumbnail" alt="图片预览" data-magnify="gallery">

                            </div>
                        </div>
                        <div>
                            <?php $hasUrl = old_or_new_field('interior_figure_one', $data); ?>
                            <div class="form-group {{!$hasUrl or 'has-error'}} has-feedback">
                                <label class="control-label" for="file">
                                    <span class="font-red">*</span>
                                    <span>内景图1:</span>
                                    <span class="font-gray">(宽高为375px:200px)：</span>
                                </label>
                                <div class="input-group">
                                    @if( $hasUrl )
                                        <input type="file" class="file-preview-second form-control" name="image1" id="image1" accept="image/*"
                                               value="{{ old_or_new_field('interior_figure_one',$data) }}">
                                    @else
                                        <input type="file" class="file-preview-second form-control validate" name="image1"
                                               @if( !isset($data->merchantInfo->interior_figure_one)) required @endif
                                               id="image1" accept="image/*"
                                               value="">
                                    @endif
                                        <input type="hidden" class="file-preview form-control validate" name="image1_1" value="{{$hasUrl?$hasUrl:($data->merchantInfo->interior_figure_one??'')}}">
                                </div>
                            </div>
                            <div class="file-preview-wrap">
                                <img
                                        @if( old_or_new_field('interior_figure_one',$data) )
                                        src="{{asset('storage/serve').'/'.old_or_new_field('interior_figure_one',$data)}}" data-src="{{ asset('storage/serve'.old_or_new_img('interior_figure_one', $data, false))}}"
                                        @else
                                        src="{{asset('storage/serve').'/'.(isset($data->merchantInfo->interior_figure_one)?$data->merchantInfo->interior_figure_one:'')}}" data-src="{{ asset('storage/serve').'/'.(isset($data->merchantInfo->interior_figure_one)?$data->merchantInfo->interior_figure_one:'')}}"

                                        @endif
                                        width="375px" height="200px" id="file-preview-second" class="img-thumbnail" alt="图片预览" data-magnify="gallery">
                            </div>
                        </div>
                        <div >
                            <?php $hasUrl = old_or_new_field('interior_figure_two', $data); ?>
                            <div class="form-group {{!$hasUrl or 'has-error'}} has-feedback">
                                <label class="control-label" for="file">
                                    <span class="font-red">*</span>
                                    <span>内景图2:</span>
                                    <span class="font-gray">(宽高为375px:200px)：</span>
                                </label>
                                <div class="input-group">
                                    @if( $hasUrl )
                                        <input type="file" class="file-preview-third form-control" name="image2" id="image2" accept="image/*"
                                               value="{{ old_or_new_field('interior_figure_two',$data) }}">
                                    @else
                                        <input type="file" class="file-preview-third form-control validate" name="image2"
                                               @if(!isset($data->merchantInfo->interior_figure_two)) required @endif
                                               id="image2" accept="image/*" value="">

                                    @endif
                                        <input type="hidden" class="file-preview form-control validate" name="image2_1" value="{{$hasUrl?$hasUrl:($data->merchantInfo->interior_figure_two??'')}}">
                                </div>
                            </div>
                            <div class="file-preview-wrap">
                                <img
                                        @if( old_or_new_field('interior_figure_two',$data) )
                                        {{--src="{{route('Img.uploads.file',[old_or_new_field('url',$data)])}}"--}}
                                        src="{{asset('storage/serve').'/'.old_or_new_field('interior_figure_two',$data)}}" data-src="{{ asset('storage/serve'.old_or_new_img('interior_figure_two', $data, false))}}"
                                        @else
                                        src="{{asset('storage/serve').'/'.(isset($data->merchantInfo->interior_figure_two)?$data->merchantInfo->interior_figure_two:'')}}" data-src="{{ asset('storage/serve').'/'.(isset($data->merchantInfo->interior_figure_two)?$data->merchantInfo->interior_figure_two:'')}}"

                                        @endif
                                        width="375px" height="200px"  id="file-preview-third" class="img-thumbnail" alt="图片预览" data-magnify="gallery">
                            </div>
                        </div>
                        <div>
                            <?php $hasUrl = old_or_new_field('interior_figure_three', $data); ?>
                            <div class="form-group {{!$hasUrl or 'has-error'}} has-feedback">
                                <label class="control-label" for="file">
                                    <span class="font-red">*</span>
                                    <span>内景图3:</span>
                                    <span class="font-gray">(宽高为375px:200px)：</span>
                                </label>
                                <div class="input-group">
                                    @if( $hasUrl )
                                        <input type="file" class="file-preview-forth form-control" name="image3" id="image3" accept="image/*"
                                               value="{{ old_or_new_field('interior_figure_three',$data) }}">
                                    @else
                                        <input type="file" class="file-preview-forth form-control validate" name="image3"
                                               @if(!isset($data->merchantInfo->interior_figure_three)) required @endif
                                               id="image3" accept="image/*" value="" >
                                    @endif

                                    <input type="hidden" class="file-preview form-control validate" name="image3_1" value="{{$hasUrl?$hasUrl:($data->merchantInfo->interior_figure_three??'')}}">

                                </div>
                            </div>
                            <div class="file-preview-wrap">
                                <img
                                        @if( old_or_new_field('interior_figure_three',$data) )
                                        {{--src="{{route('Img.uploads.file',[old_or_new_field('url',$data)])}}"--}}
                                        src="{{asset('storage/serve').'/'.old_or_new_field('interior_figure_three',$data)}}" data-src="{{ asset('storage/serve'.old_or_new_img('interior_figure_three', $data, false))}}"
                                        @else
                                        src="{{asset('storage/serve').'/'.(isset($data->merchantInfo->interior_figure_three)?$data->merchantInfo->interior_figure_three:'')}}" data-src="{{ asset('storage/serve').'/'.(isset($data->merchantInfo->interior_figure_three)?$data->merchantInfo->interior_figure_three:'')}}"

                                        @endif
                                        width="375px" height="200px" id="file-preview-forth"  class="img-thumbnail" alt="图片预览" data-magnify="gallery">
                            </div>
                        </div>
                    </div>
                    <div class="panel-heading">介绍</div>
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div id="editor" type="text/plain" style="width:100%;height:500px;">

                        </div>
                    </div>
                    <div class="text-center margin-bottom-sm">
                        <button class="pretty-btn"> 提交</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>


        @if(\App\Merchant::getStatus($data,'merchant') == \App\Merchant::SUCCESS_AUDIT ||
        \App\Merchant::getStatus($data,'dorm')== \App\Merchant::SUCCESS_AUDIT)
            <div class="row">
                <div class="col-lg-6 col-sm-8  col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">店铺信息</div>
                        <div class="panel-body">
                            <div class="panel-item">
                                {{Form::label('number','店铺负责人:')}}
                                <span class="panel-value">
                                {{$data->merchantInfo->merchant_principal}}
                                </span>
                            </div>

                            <div class="panel-item">
                                {{Form::label('number','店铺名称:')}}
                                <span class="panel-value">
                                {{$data->merchantInfo->merchant_name}}
                            </span>
                            </div>

                            <div class="panel-item">
                                {{Form::label('number','店铺简称:')}}
                                <span class="panel-value">
                                {{$data->merchantInfo->merchant_short_name}}
                            </span>
                            </div>

                            <div class="panel-item">
                                {{Form::label('number','店铺地址：')}}
                                <span class="panel-value">
                                {{$data->merchantInfo->merchant_address}}
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
                                {{Form::label('number','名称：')}}
                                <span class="panel-value">
                                {{$data->merchantInfo->business_name}}
                            </span>
                            </div>

                            <div class="panel-item">
                                {{Form::label('number','注册号：')}}
                                <span class="panel-value">
                                {{$data->merchantInfo->business_num}}
                            </span>
                            </div>

                            <div class="panel-item">
                                {{Form::label('number','营业执照法人：')}}
                                <span class="panel-value">
                                {{$data->merchantInfo->business_person}}
                            </span>
                            </div>

                            <div class="panel-item">
                                {{Form::label('number','营业地址：')}}
                                <span class="panel-value">
                                {{$data->merchantInfo->business_address}}
                            </span>
                            </div>

                            <div class="panel-item">
                                {{Form::label('number','营业执照：')}}
                                <span class="panel-value">
                                <img src="{{asset('storage/').'/'.$data->merchantInfo->business_img}}"
                                     data-src="{{asset('storage/').'/'.$data->merchantInfo->business_img}}"
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
                                {{Form::label('number','身份证姓名：')}}
                                <span class="panel-value">
                                {{$data->merchantInfo->identity_name}}
                            </span>
                            </div>

                            <div class="panel-item">
                                {{Form::label('number','身份证号：')}}
                                <span class="panel-value">
                                {{$data->merchantInfo->identity_num}}
                            </span>
                            </div>

                            <div class="panel-item">
                                {{Form::label('identity_front','身份证正面照:')}}
                                <span class="panel-value">
                                <img src="{{asset('storage/').'/'.$data->merchantInfo->identity_front}}"
                                     data-src="{{asset('storage/').'/'.$data->merchantInfo->identity_front}}"
                                     data-magnify="gallery">
                            </span>
                            </div>

                            <div class="panel-item">
                                {{Form::label('identity_contrary','身份证反面照:')}}
                                <span class="panel-value">
                                <img src="{{asset('storage/').'/'.$data->merchantInfo->identity_contrary}}"
                                     data-src="{{asset('storage/').'/'.$data->merchantInfo->identity_contrary}}"
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
                                    @if($data->merchantInfo->contract_tenancy)
                                        @foreach(json_decode($data->merchantInfo->contract_tenancy) as $img)
                                            <div class="swiper-slide">
                                                <img src="{{asset('storage/').'/'.$img}}"
                                                     data-src="{{asset('storage/').'/'.$img}}"
                                                     data-magnify="gallery" class="img-responsive">
                                            </div>
                                        @endforeach
                                    @else
                                        未上传
                                    @endif
                                </div>
                                <div class="swiper-scrollbar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(\App\Merchant::getStatus($data,'dorm')== \App\Merchant::SUCCESS_AUDIT)

            @if($data->homestayInfo->property_img_1)
                <div class="row">
                    <div class="col-lg-6 col-sm-8  col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">集体土地使用权证(农村房屋所有权证)</div>
                            <div class="panel-body">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        @foreach(json_decode($data->homestayInfo->property_img_1) as $img)
                                            <div class="swiper-slide">
                                                <img src="{{asset('storage/').'/'.$img}}"
                                                     data-src="{{asset('storage/').'/'.$img}}"
                                                     data-magnify="gallery" class="img-responsive">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-scrollbar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($data->homestayInfo->property_img_2)
                <div class="row">
                    <div class="col-lg-6 col-sm-8  col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">乡村建房宅基地许可证(个人建房田地临时凭据)</div>
                            <div class="panel-body">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        @foreach(json_decode($data->homestayInfo->property_img_2) as $img)
                                            <div class="swiper-slide">
                                                <img src="{{asset('storage/').'/'.$img}}"
                                                     data-src="{{asset('storage/').'/'.$img}}"
                                                     data-magnify="gallery" class="img-responsive">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-scrollbar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($data->homestayInfo->property_img_3)
                <div class="row">
                    <div class="col-lg-6 col-sm-8  col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">乡村房屋契证</div>
                            <div class="panel-body">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        @foreach(json_decode($data->homestayInfo->property_img_3) as $img)
                                            <div class="swiper-slide">
                                                <img src="{{asset('storage/').'/'.$img}}"
                                                     data-src="{{asset('storage/').'/'.$img}}"
                                                     data-magnify="gallery" class="img-responsive">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-scrollbar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($data->homestayInfo->property_img_4)
                <div class="row">
                    <div class="col-lg-6 col-sm-8  col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">土地房产所有证</div>
                            <div class="panel-body">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        @foreach(json_decode($data->homestayInfo->property_img_4) as $img)
                                            <div class="swiper-slide">
                                                <img src="{{asset('storage/').'/'.$img}}"
                                                     data-src="{{asset('storage/').'/'.$img}}"
                                                     data-magnify="gallery" class="img-responsive">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-scrollbar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($data->homestayInfo->property_img_5)
                <div class="row">
                    <div class="col-lg-6 col-sm-8  col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">乡村企业田地许可证</div>
                            <div class="panel-body">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        @foreach(json_decode($data->homestayInfo->property_img_5) as $img)
                                            <div class="swiper-slide">
                                                <img src="{{asset('storage/').'/'.$img}}"
                                                     data-src="{{asset('storage/').'/'.$img}}"
                                                     data-magnify="gallery" class="img-responsive">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-scrollbar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($data->homestayInfo->property_img_6)
                <div class="row">
                    <div class="col-lg-6 col-sm-8  col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">建设工程规划许可证</div>
                            <div class="panel-body">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        @foreach(json_decode($data->homestayInfo->property_img_6) as $img)
                                            <div class="swiper-slide">
                                                <img src="{{asset('storage/').'/'.$img}}"
                                                     data-src="{{asset('storage/').'/'.$img}}"
                                                     data-magnify="gallery" class="img-responsive">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-scrollbar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($data->homestayInfo->property_img_7)
                <div class="row">
                    <div class="col-lg-6 col-sm-8  col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">私危房翻改建许可证</div>
                            <div class="panel-body">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        @foreach(json_decode($data->homestayInfo->property_img_7) as $img)
                                            <div class="swiper-slide">
                                                <img src="{{asset('storage/').'/'.$img}}"
                                                     data-src="{{asset('storage/').'/'.$img}}"
                                                     data-magnify="gallery" class="img-responsive">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-scrollbar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($data->homestayInfo->property_img)
                <div class="row">
                    <div class="col-lg-6 col-sm-8  col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">其他产权证明</div>
                            <div class="panel-body">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        @foreach(json_decode($data->homestayInfo->property_img) as $img)
                                            <div class="swiper-slide">
                                                <img src="{{asset('storage/').'/'.$img}}"
                                                     data-src="{{asset('storage/').'/'.$img}}"
                                                     data-magnify="gallery" class="img-responsive">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-scrollbar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-6 col-sm-8  col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">无犯罪(清白)证明</div>
                        <div class="panel-body">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="{{asset('storage/').'/'.$data->homestayInfo->alibi_img }}"
                                             data-src="{{asset('storage/').'/'.$data->homestayInfo->alibi_img}}"
                                             data-magnify="gallery" class="img-responsive"
                                        >
                                    </div>
                                </div>
                                <div class="swiper-scrollbar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endif

        @if(\App\Merchant::getStatus($data,'house')== \App\Merchant::SUCCESS_AUDIT)
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
                                        @if($data->houseAudit->img)
                                            @foreach(json_decode($data->houseAudit->img) as $img)
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
                                {{Form::label('name','房屋审批编号:')}}
                                <span class="panel-value">
                                {{$data->houseAudit->code}}
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
                                <img src="{{asset('storage/').'/'.$data->houseAudit->address_img}}"
                                     data-src="{{asset('storage/').'/'.$data->houseAudit->address_img}}"
                                     data-magnify="gallery">
                            </span>
                            </div>
                            <div class="panel-item">
                                {{Form::label('system_img','公共制度：')}}
                                <span class="panel-value">
                                <img src="{{asset('storage/').'/'.$data->houseAudit->system_img}}"
                                     data-src="{{asset('storage/').'/'.$data->houseAudit->system_img}}"
                                     data-magnify="gallery">
                            </span>
                            </div>

                            <div class="panel-item">
                                {{Form::label('duty_img','黄厝社区民宿经营责任协议书：')}}
                                <span class="panel-value">
                                    <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                       @if($data->houseAudit->duty_img)
                                            @foreach(json_decode($data->houseAudit->duty_img) as $img)
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
                                 <img src="{{asset('storage/').'/'.$data->houseAudit->mass_img}}"
                                      data-src="{{asset('storage/').'/'.$data->houseAudit->mass_img}}"
                                      data-magnify="gallery">
                            </span>
                            </div>

                            <div class="panel-item">
                                {{Form::label('safe_img','民宿业治安管理制度：')}}
                                <span class="panel-value">
                                <img src="{{asset('storage/').'/'.$data->houseAudit->safe_img}}"
                                     data-src="{{asset('storage/').'/'.$data->houseAudit->safe_img}}"
                                     data-magnify="gallery">
                            </span>
                            </div>

                            <div class="panel-item">
                                {{Form::label('self_img','厦门市个体工商户安全生产标准化建设自评表：')}}
                                <span class="panel-value">
                                <img src="{{asset('storage/').'/'.$data->houseAudit->self_img}}"
                                     data-src="{{asset('storage/').'/'.$data->houseAudit->self_img}}"
                                     data-magnify="gallery">
                            </span>
                            </div>

                            <div class="panel-item">
                                {{Form::label('audit_img','厦门市民宿经营申报联合核验表：')}}
                                <span class="panel-value">
                                <img src="{{asset('storage/').'/'.$data->houseAudit->audit_img}}"
                                     data-src="{{asset('storage/').'/'.$data->houseAudit->audit_img}}"
                                     data-magnify="gallery">
                            </span>
                            </div>

                            <div class="panel-item">
                                {{Form::label('accredit_img','授权委托书：')}}
                                <span class="panel-value">
                                <img src="{{asset('storage/').'/'.$data->houseAudit->accredit_img}}"
                                     data-src="{{asset('storage/').'/'.$data->houseAudit->accredit_img}}"
                                     data-magnify="gallery">
                            </span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif



    </div>

@stop

@section('js')
    <script type="text/javascript" charset="utf-8" src="/uedit/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/uedit/ueditor.all.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/uedit/lang/zh-cn/zh-cn.js"></script>
    <script type="text/javascript" charset="utf-8" src="/js/bootstrap-datetimepicker.min.js"></script>
    <script src="/js/swiper-4.3.3.min.js"></script>
    <script>

        $(document).ready(function () {
            $('#merchant').addClass('active');
            $('#merchant_merchant_index').addClass('active');

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
        $(document).ready(function () {
            $('#merchant').addClass('active');
            $('#merchant_merchant_index').addClass('active');
        });
        var ue = UE.getEditor('editor', {
            textarea: 'content',
            autoHeightEnabled: false,
        });

        @if(old_or_new_field('content',$data->merchantInfo)!=null)
        ue.addListener("ready", function () {
            //editor准备好之后才可以使用
            ue.setContent('{!!old_or_new_field('content',$data->merchantInfo)!!}');
        });
        @endif
        $(function (){
            $('.date').datetimepicker({
                autoclose: true,
                clearBtn: true,
                todayBtn: true,
                language: 'zh-CN',
                format: "yyyy-mm-dd hh:ii:ss",
            }).on("show", function (ev) {
                window.currentDatePicker = ev.target;
            });
        })
        $("#content-dpi").on('change', function () {
            width = $(this).val();
            $("#edui1").css('width', width);
            $("#edui1_iframeholder").css('width', width);
        })
        //缩略图
        $(document).on("change", ".file-preview", function (e) {
            var files = e.target.files;
            for (var i = 0, f; f = files[i]; i++) {
                if (!f.type.match('image.*')) {
                    continue;
                }
                var reader = new FileReader();
                reader.onload = (function (theFile) {
                    return function (e) {
                        document.getElementById('file-preview').src = e.target.result;
                    };
                })(f);
                reader.readAsDataURL(f);
            }
        });
        //内景图1
        $(document).on("change", ".file-preview-second", function (e) {
            var files = e.target.files;
            for (var i = 0, f; f = files[i]; i++) {
                if (!f.type.match('image.*')) {
                    continue;
                }
                var reader = new FileReader();
                reader.onload = (function (theFile) {
                    return function (e) {
                        document.getElementById('file-preview-second').src = e.target.result;
                    };
                })(f);
                reader.readAsDataURL(f);
            }
        });
        //内景图2
        $(document).on("change", ".file-preview-third", function (e) {
            var files = e.target.files;
            for (var i = 0, f; f = files[i]; i++) {
                if (!f.type.match('image.*')) {
                    continue;
                }
                var reader = new FileReader();
                reader.onload = (function (theFile) {
                    return function (e) {
                        document.getElementById('file-preview-third').src = e.target.result;
                    };
                })(f);
                reader.readAsDataURL(f);
            }
        });
        //内景图3
        $(document).on("change", ".file-preview-forth", function (e) {
            var files = e.target.files;
            for (var i = 0, f; f = files[i]; i++) {
                if (!f.type.match('image.*')) {
                    continue;
                }
                var reader = new FileReader();
                reader.onload = (function (theFile) {
                    return function (e) {
                        document.getElementById('file-preview-forth').src = e.target.result;
                    };
                })(f);
                reader.readAsDataURL(f);
            }
        });

    </script>
@stop