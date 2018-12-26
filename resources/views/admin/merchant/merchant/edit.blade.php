@extends('layouts.admin')

@section('pageTitle')
    商户详情
@stop

@section('css')
    <link rel="stylesheet" href="/css/swiper-4.3.3.min.css">
    <link href="{{ asset('/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <style>
        .form-group img {
            height: 120px;
            width: 120px;
            text-align: center;
            line-height: 120px;
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
            <div class="col-lg-4 col-sm-6 col-xs-12">
                <div class="panel panel-default">
{{--                    {{ Form::open(['method'=>'post','route' => ['admin.merchant.'.($data?'update':'store'),'update'=>($data?$data->id:$data)],'enctype'=>'multipart/form-data']) }}--}}
                    {{ Form::open(['method'=>'post','route' => ['admin.merchant.store'],'enctype'=>'multipart/form-data']) }}
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="thumbnail_temp" value="{{ old('thumbnail_temp') }}">
                    <div class="panel-heading">商户信息</div>
                    <div class="panel-body">
                        <div class="panel-item">
                            {{Form::label('merchant_principal','负责人姓名:')}}
                            {{Form::text('merchant_principal',old_or_new_field('merchant_principal',$data),['class'=>'form-input'])}}
                            {{--{{Form::label('merchant_principal','负责人姓名:')}}--}}
                            {{--{{Form::text('merchant_principal','',['class'=>'form-input'])}}--}}
                        </div>
                        <div class="panel-item">
                            {{Form::label('mobile','负责人手机:')}}
                            {{Form::text('mobile',old_or_new_field('mobile',$data),['class'=>'form-input'])}}
                            {{--{{Form::label('mobile','负责人手机:')}}--}}
                            {{--{{Form::text('mobile','',['class'=>'form-input'])}}--}}
                        </div>
                        <div class="panel-item">
                            {{Form::label('merchant_name','商家店铺名:')}}
                            {{Form::text('merchant_name',old_or_new_field('merchant_name',$data),['class'=>'form-input'])}}
                            {{--{{Form::label('merchant_name','商家名称:')}}--}}
                            {{--{{Form::text('merchant_name','',['class'=>'form-input'])}}--}}
                        </div>
                        <div class="panel-item">
                            {{Form::label('merchant_short_name','商家简称:')}}
                            {{Form::text('merchant_short_name',old_or_new_field('merchant_short_name',$data),['class'=>'form-input'])}}
                            {{--{{Form::label('merchant_short_name','商家简称:')}}--}}
                            {{--{{Form::text('merchant_short_name','',['class'=>'form-input'])}}--}}
                        </div>
                        <div class="panel-item">
                            {{Form::label('merchant_address','商家地址:')}}
                            {{Form::text('merchant_address','',['class'=>'form-input'])}}
                        </div>
                        <div class="form-group has-error has-feedback">
                            <label  style="color: black;" class="control-label" for="register">
                                <span class="font-red">*</span>注册时间：</label>
                            <div style="width:400px;border-color: #ccc;" class="input-group">
                                <div style="border-color: #ccc;" class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input style="border-color: #ccc;"  class="form-control date validate" name="register" id="register" required
                                       value="{{old_or_new_field('register',$data)}}">
                            </div>

                        </div>
                        <div class="panel-item">
                            {{Form::label('business_name','营业执照名称:')}}
                            {{Form::text('business_name','',['class'=>'form-input'])}}
                        </div>
                        <div class="panel-item">
                            {{Form::label('business_num','营业执照代码:')}}
                            {{Form::text('business_num','',['class'=>'form-input'])}}
                        </div>
                        <div class="panel-item">
                            {{Form::label('time','营业时间(数字):')}}
                            {{Form::text('time','',['class'=>'form-input'])}}
                        </div>
                        <div class="panel-item">
                            {{Form::label('score','评分(1~5):')}}
                            {{Form::text('score','',['class'=>'form-input'])}}
                        </div>
                        <div class="panel-item">
                            {{Form::label('business_address','营业执照地址:')}}
                            {{Form::text('business_address','',['class'=>'form-input'])}}
                        </div>
                        <div class="panel-item">
                            {{Form::label('person','法人姓名:')}}
                            {{Form::text('person','',['class'=>'form-input'])}}
                        </div>
                        <div class="panel-item">
                            {{Form::label('identity_num','法人身份证:')}}
                            {{Form::text('identity_num','',['class'=>'form-input'])}}
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="panel-heading">商户图片</div>
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
                                        <input type="file" class="file-preview form-control validate" name="file" required id="file"
                                               accept="image/*"
                                               value="{{ old_or_new_field('thumbnail',$data) }}" >
                                    @endif
                                </div>
                            </div>
                            <div class="file-preview-wrap">
                                    <img
                                        @if( old_or_new_field('thumbnail',$data) )
                                        src="{{asset('storage/serve').'/'.old_or_new_field('thumbnail',$data)}}
                                                " data-src="{{ asset('storage/serve'.old_or_new_img('thumbnail', $data, false))}}"

                                        @endif
                                        id="file-preview" class="img-thumbnail" alt="图片预览"  >
                            </div>
                        </div>
                        <!--内景图1-->
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
                                        <input type="file" class="file-preview-second form-control validate" name="image1" required id="image1"
                                               accept="image/*"
                                               value="{{ old_or_new_field('interior_figure_one',$data) }}">
                                    @endif
                                </div>
                            </div>
                            <div class="file-preview-wrap">
                                    <img
                                        @if( old_or_new_field('interior_figure_one',$data) )
                                        src="{{asset('storage/serve').'/'.old_or_new_field('interior_figure_one',$data)}}"
                                        data-src="{{ asset('storage/serve'.old_or_new_img('interior_figure_one', $data, false))}}"
                                        @endif
                                        id="file-preview-second" class="img-thumbnail" alt="图片预览" >

                            </div>
                        </div>
                        <!--内景图2-->
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
                                        <input type="file" class="file-preview-third form-control validate" name="image2" required id="image2"
                                               accept="image/*"
                                               value="{{ old_or_new_field('interior_figure_two',$data) }}">
                                    @endif
                                </div>
                            </div>
                            <div class="file-preview-wrap">
                                    <img
                                        @if( old_or_new_field('interior_figure_two',$data) )
                                        {{--src="{{route('Img.uploads.file',[old_or_new_field('url',$data)])}}"--}}
                                        src="{{asset('storage/serve').'/'.old_or_new_field('interior_figure_two',$data)}}
                                                " data-src="{{ asset('storage/serve'.old_or_new_img('interior_figure_two', $data, false))}}"
                                        @endif
                                        width="375px" height="200px"  id="file-preview-third" class="img-thumbnail" alt="图片预览"  >
                            </div>
                        </div>
                        <!--内景图3-->
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
                                        <input type="file" class="file-preview-forth form-control validate" name="image3" required id="image3"
                                               accept="image/*"
                                               value="{{ old_or_new_field('interior_figure_three',$data) }}">
                                    @endif
                                </div>
                            </div>
                            <div class="file-preview-wrap">
                                    <img
                                        @if( old_or_new_field('interior_figure_three',$data) )
                                        {{--src="{{route('Img.uploads.file',[old_or_new_field('url',$data)])}}"--}}
                                        src="{{asset('storage/serve').'/'.old_or_new_field('interior_figure_three',$data)}}
                                                " data-src="{{ asset('storage/serve'.old_or_new_img('interior_figure_three', $data, false))}}"
                                        @endif
                                        width="375px" height="200px" id="file-preview-forth"  class="img-thumbnail" alt="图片预览" >
                            </div>
                        </div>
                        <div class="panel-heading">介绍</div>
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div id="editor" type="text/plain" style="width:100%;height:500px;"></div>
                        </div>

                    </div>
                    <div class="text-center margin-bottom-sm">
                        <button class="pretty-btn"> 添加商户</button>
                    </div>

                    {{ Form::close() }}
                </div>
            </div>
        </div>



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
        });
        var ue = UE.getEditor('editor', {
            textarea: 'content',
            autoHeightEnabled: false,
        });

        @if(old_or_new_field('content',$data)!=null)
        ue.addListener("ready", function () {

            //editor准备好之后才可以使用
            ue.setContent('{!!old_or_new_field('content',$data)!!}');
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