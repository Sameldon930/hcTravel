@extends('layouts.admin')

@section('pageTitle')
    商户招租
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        <div>@if($data)修改{{$data->name}}@else 添加招租信息 @endif</div>
        <?php
        $rent_ways = \App\ApartmentRent::RENT_WAYS;
        ?>
        <div class="padding-top-sm">
            {{ Form::open(['method'=> 'post','route' => ['admin.apartment_rent.'.($data?'update':'store'),'update'=>($data?$data->id:$data)],'enctype'=>'multipart/form-data']) }}
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class=" form-group">
                {{Form::label('title','标题:')}}
                {{Form::text('title',old_or_new_field('title',$data),['class'=>'form-input'])}}
            </div>
            <div class=" form-group">
                {{Form::label('rental','租金:')}}
                {{Form::text('rental',old_or_new_field('rental',$data),['class'=>'form-input'])}}
            </div>
            <div class=" form-group">
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
                            src="{{asset('storage/serve').'/'.old_or_new_field('thumbnail',$data)}}
                                    " data-src="{{ asset('storage/serve'.old_or_new_img('thumbnail', $data, false))}}"
                            @endif
                            id="file-preview" class="img-thumbnail" alt="图片预览"/>
                </div>
            </div>

            <div class=" form-group">
                <?php $hasUrl = old_or_new_field('image', $data); ?>
                <div class="form-group {{!$hasUrl or 'has-error'}} has-feedback">
                    <label class="control-label" for="file">
                        <span class="font-red">*</span>
                        <span>详情图:</span>
                        <span class="font-gray">(建议宽高比为2:1)：</span>
                    </label>
                    <div class="input-group">
                        @if( $hasUrl )
                            <input type="file" class="file-preview-second form-control" name="image" id="image"
                                   accept="image/*"
                                   value="{{ old_or_new_field('',$data) }}">
                        @else
                            <input type="file" class="file-preview-second form-control validate" name="image" required
                                   id="image" accept="image/*"
                                   value="{{ old_or_new_field('image',$data) }}">
                        @endif

                    </div>
                </div>
                <div class="file-preview-wrap">
                    <img
                            @if( old_or_new_field('image',$data) )
                            {{--src="{{route('Img.uploads.file',[old_or_new_field('url',$data)])}}"--}}
                            src="{{asset('storage/serve').'/'.old_or_new_field('image',$data)}}
                                    " data-src="{{ asset('storage/serve'.old_or_new_img('image', $data, false))}}"
                            @endif
                            id="file-preview-second" class="img-thumbnail" alt="图片预览"/>
                </div>
            </div>
            <div class=" form-group">
                {{Form::label('house_type','房屋类型:')}}
                {{Form::text('house_type',old_or_new_field('house_type',$data),['class'=>'form-input'])}}
            </div>
            <div class=" form-group">
                {{Form::label('rent_way','租凭方式:')}}
                {{Form::select('rent_way',$rent_ways,$data?$data->rent_way:'',['class'=>'form-input'])}}
            </div>
            <div class=" form-group">
                {{Form::label('payment_mode','支付方式:')}}
                {{Form::text('payment_mode',old_or_new_field('payment_mode',$data),['class'=>'form-input'])}}
            </div>
            <div class=" form-group">
                {{Form::label('region','所属区域:')}}
                {{Form::text('region',old_or_new_field('region',$data),['class'=>'form-input'])}}
            </div>
            <div class=" form-group">
                {{Form::label('mobile','联系方式:')}}
                {{Form::text('mobile',old_or_new_field('mobile',$data),['class'=>'form-input'])}}
            </div>
            <div class=" form-group">
                {{Form::label('content','招租详情:')}}
                {{Form::textarea('content',old_or_new_field('content',$data),['class'=>'form-input','rows'=>"7",'cols'=>"50",'style'=>'height:auto;'])}}
            </div>

            <button class="pretty-btn">@if($data)修改@else 添加 @endif</button>

            {{ Form::close() }}
        </div>
    </div>

@stop

@section('js')
    <script>

        $(document).ready(function () {
            $('#info').addClass('active');
            $('#info_apartment_rent_index').addClass('active');
        });
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
