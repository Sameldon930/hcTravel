@extends('layouts.admin')

@section('pageTitle')
    公告编辑
@stop

@section('css')
    <link href="{{ asset('/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <style>
        .file-preview-wrap > img {
            height: 150px;
            width: 410px;
            text-align: center;
            line-height: 130px;
            font-size: 20px;
            color: #666666;
        }
    </style>
@stop

@section('content')
    <div class="box">

        <div class="padding-top-sm">
            <?php
//            $articleGroup = new \App\ArticleGroup();
//            $groups = $articleGroup->getArticleGroups();
//            $group = [];
//            foreach ($groups as $value) {
//                $group[$value->id] = $value->name;
//            }

            ?>
            {{ Form::open(['method'=>'post','route' => ['admin.notify.'.($data?'update':'store'),'update'=>($data?$data->id:$data)],'enctype'=>'multipart/form-data']) }}
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class=" form-group">
                {{Form::label('title','文章标题')}}
                {{Form::text('title',old_or_new_field('title',$data),['class'=>'form-input'])}}
            </div>

            {{ csrf_field() }}
            <div class="form-group">
                <div id="editor" type="text/plain" style="width:1024px;height:500px;"></div>
            </div>
            <br>
            <button class="pretty-btn">@if($data)修改@else 添加 @endif</button>
            {{ Form::close() }}
        </div>

    </div>

@stop

@section('js')
    <script type="text/javascript" charset="utf-8" src="/uedit/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/uedit/ueditor.all.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/uedit/lang/zh-cn/zh-cn.js"></script>
    <script type="text/javascript" charset="utf-8" src="/js/bootstrap-datetimepicker.min.js"></script>

    <script>

        $(document).ready(function () {
            $('#operation').addClass('active');
            $('#operation_notify_index').addClass('active');
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
    </script>
@stop
