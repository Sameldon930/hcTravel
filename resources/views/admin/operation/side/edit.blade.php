@extends('layouts.admin')

        @section('pageTitle')
        幻灯片编辑
        @stop

        @section('css')
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
                {{ Form::open(['method'=>$data?'put':'post','files'=>true,
                        'route' => ['admin.side.'.($data?'update':'store'),
                        'update'=>($data?$data->id:$data)]])
                 }}
                <div class="padding-top-sm">
                    <div class=" form-group">
                        <?php $hasUrl = old_or_new_field('image',$data); ?>
                        <div class="form-group {{!$hasUrl or 'has-error'}} has-feedback">
                            <label class="control-label" for="file">
                                <span class="font-red">*</span>
                                <span>缩略图:</span>
                                <span class="font-gray">(建议宽高比为2:1)：</span>
                            </label>
                            <div class="input-group">
                                @if( $hasUrl )
                                    <input type="file" class="file-preview form-control" name="file" id="file" accept="image/*"
                                           value="{{ old_or_new_field('image',$data) }}">
                                @else
                                    <input type="file" class="file-preview form-control validate" name="file" required id="file" accept="image/*"
                                           value="{{ old_or_new_field('image',$data) }}">
                                @endif

                            </div>
                        </div>
                        <div class="file-preview-wrap">
                            <img
                                    @if( old_or_new_field('image',$data) )
                                    {{--src="{{route('Img.uploads.file',[old_or_new_field('url',$data)])}}"--}}
                                    src="{{asset('storage/serve').'/'.old_or_new_field('image',$data)}}"
                                    @endif
                                    id="file-preview" class="img-thumbnail" alt="图片预览">
                        </div>

                    </div>
                    <div class=" form-group">
                        {{Form::label('url','跳转链接:')}}
                        {{Form::text('url',old_or_new_field('url',$data),['class'=>'form-input'])}}
                    </div>
                    <div class=" form-group">
                        {{Form::label('note','备注:')}}
                        {{Form::text('note',old_or_new_field('note',$data),['class'=>'form-input'])}}
                    </div>
                    <div class=" form-group">
                        {{Form::label('orderby','排序值:')}}
                        {{Form::text('orderby',old_or_new_field('orderby',$data),['class'=>'form-input'])}}
                    </div>
                </div>
                <button class="pretty-btn" >@if($data)修改@else 添加 @endif</button>
            </div>
            {{ Form::close() }}

            </div>

        @stop

@section('js')
    <script type="text/javascript" charset="utf-8" src="/uedit/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/uedit/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="/uedit/lang/zh-cn/zh-cn.js"></script>
    <script>

        $(document).ready(function () {
            $('#operation').addClass('active');
            $('#operation_side_index').addClass('active');
        });
        var ue = UE.getEditor('editor',{
            textarea:'content',
            autoHeightEnabled: false,
        });

        @if(old_or_new_field('content',$data)!=null)
        ue.addListener("ready", function () {

            //editor准备好之后才可以使用
            ue.setContent('{!!old_or_new_field('content',$data)!!}');
        });
        @endif

        $("#content-dpi").on('change', function(){
            width = $(this).val();
            $("#edui1").css('width', width);
            $("#edui1_iframeholder").css('width', width);
        })
    </script>
@stop
