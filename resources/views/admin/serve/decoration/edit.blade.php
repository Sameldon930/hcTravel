@extends('layouts.admin')

@section('pageTitle')
    编辑装修公司
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        <div>@if($data)修改{{$data->name}}@else 添加装修公司 @endif</div>
        <?php
        $groups = \App\Decoration::TYPE_ARRAY;

        foreach ($groups as $key => $value) {
            $group[$key] = $value;
        }

        ?>
        {{ Form::open(['method'=>$data?'put':'post','files'=>true,
                'route' => ['admin.decoration.'.($data?'update':'store'),
                'update'=>($data?$data->id:$data)]])}}
        <div class="padding-top-sm">
            <div class=" form-group">
                {{Form::label('title','标题:')}}
                {{Form::text('title',old_or_new_field('title',$data),['class'=>'form-input'])}}
            </div>
            <div class=" form-group">
                {{Form::label('name','店名1:')}}
                {{Form::text('name',old_or_new_field('name',$data),['class'=>'form-input'])}}
            </div>
            <div class=" form-group">
                {{Form::label('type','类型:')}}
                {{Form::select('type',$group,['class'=>'form-input'])}}
            </div>
            <div class=" form-group">
                {{--  {{Form::label('thumbnail','缩略图:')}}
                  {{Form::file('thumbnail',['class'=>'form-input','accept'=>"image/*"])}}--}}
                <?php $hasUrl = old_or_new_field('thumbnail', $data); ?>
                <div class="form-group {{!$hasUrl or 'has-error'}} has-feedback">
                    <label class="control-label" for="file">
                        <span class="font-red">*</span>
                        <span>缩略图:</span>
                        <span class="font-gray">(建议宽高比为2:1)：</span>
                    </label>
                    <div class="input-group">
                        @if( $hasUrl )
                            <input type="file" class="file-preview form-control" name="file" id="file" accept="image/*"
                                   value="{{ old_or_new_field('thumbnail',$data) }}">
                        @else
                            <input type="file" class="file-preview form-control validate" name="file" required id="file"
                                   accept="image/*"
                                   value="{{ old_or_new_field('thumbnail',$data) }}">
                        @endif

                    </div>
                </div>
                <div class="file-preview-wrap">
                    <img
                            @if( old_or_new_field('thumbnail',$data) )
                            {{--src="{{route('Img.uploads.file',[old_or_new_field('url',$data)])}}"--}}
                            src="{{asset('storage/serve').'/'.old_or_new_field('thumbnail',$data)}}"
                            @endif
                            id="file-preview" class="img-thumbnail" alt="图片预览">
                </div>

            </div>
            <div class=" form-group">
                {{Form::label('mobile','联系电话:')}}
                {{Form::text('mobile',old_or_new_field('mobile',$data),['class'=>'form-input'])}}
            </div>
            <div class=" form-group">
                {{Form::label('address','地址:')}}
                {{Form::text('address',old_or_new_field('address',$data),['class'=>'form-input'])}}
            </div>
            <div class=" form-group">
                {{Form::label('url','网址:')}}
                {{Form::text('url',old_or_new_field('url',$data),['class'=>'form-input'])}}
            </div>
            <div class=" form-group">
                {{Form::label('top','是否置顶:')}}
                {{Form::radio('top',\App\Decoration::YES,(old_or_new_field('top',$data) ==  \App\Decoration::YES || old_or_new_field('top',$data)==null))}}
                {{Form::label('top','置顶')}}
                {{Form::radio('top',\App\Decoration::NO,old_or_new_field('top',$data) ==  \App\Decoration::NO)}}
                {{Form::label('top','不置顶')}}
            </div>
            <div class=" form-group">
                <label>选择分辨率:</label>
                <select id="content-dpi" class="form-input">
                    <option value="1024">PC</option>
                    <option value="320">iPhone5</option>
                    <option value="375">iPhone6</option>
                    <option value="414">iPhone6P、Iphone7</option>
                </select>
            </div>
            {{ csrf_field() }}
            <div class="form-group">
                <div id="editor" type="text/plain" style="width:1024px;height:500px;"></div>
            </div>
            <br>
        </div>
        <button class="pretty-btn">@if($data)修改@else 添加 @endif</button>
    </div>
    {{ Form::close() }}

    </div>

@stop

@section('js')
    <script type="text/javascript" charset="utf-8" src="/uedit/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/uedit/ueditor.all.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/uedit/lang/zh-cn/zh-cn.js"></script>
    <script>

        $(document).ready(function () {
            $('#info').addClass('active');
            $('#serve_decoration_index').addClass('active');
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

        $("#content-dpi").on('change', function () {
            width = $(this).val();
            $("#edui1").css('width', width);
            $("#edui1_iframeholder").css('width', width);
        })
    </script>
@stop
