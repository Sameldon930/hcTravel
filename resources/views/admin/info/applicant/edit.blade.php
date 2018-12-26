@extends('layouts.admin')

@section('pageTitle')
    招聘人员
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        <div>@if($data)修改{{$data->name}}@else 添加招聘人员 @endif</div>
        <?php
        $sexs = \App\Applicant::SEX;
        $educations = \App\Applicant::EDUCATIONS;
        ?>
        <div class="padding-top-sm">
            {{ Form::open(['method'=>$data?'put':'post','route' => ['admin.applicant.'.($data?'update':'store'),'update'=>($data?$data->id:$data)]]) }}
            <div class=" form-group">
                {{Form::label('name','姓名:')}}
                {{Form::text('name',old_or_new_field('name',$data),['class'=>'form-input'])}}
            </div>
            <div class=" form-group">
                {{Form::label('age','年龄:')}}
                {{Form::text('age',old_or_new_field('age',$data),['class'=>'form-input'])}}
            </div>
            <div class=" form-group">
                {{Form::label('apply_position','求职意向:')}}
                {{Form::text('apply_position',old_or_new_field('apply_position',$data),['class'=>'form-input'])}}
            </div>
            <div class=" form-group">
                {{Form::label('sex','性别:')}}
                {{Form::select('sex',$sexs,$data?$data->sex:'',['class'=>'form-input'])}}
            </div>
            <div class=" form-group">
                {{Form::label('work_experience','工作经验:')}}
                {{Form::text('work_experience',old_or_new_field('work_experience',$data),['class'=>'form-input'])}}
            </div>
            <div class=" form-group">
                {{Form::label('education','学历:')}}
                {{Form::select('education',$educations,$data?$data->education:'',['class'=>'form-input'])}}
            </div>
            <div class=" form-group">自我评价:
                {{ csrf_field() }}
            </div>
            <div class="form-group">
                <div id="editor" type="text/plain" style="width:1024px;height:500px;"></div>
            </div>
            <br>
            <div class=" form-group">
                {{Form::label('mobile','联系电话:')}}
                {{Form::text('mobile',old_or_new_field('mobile',$data),['class'=>'form-input'])}}
            </div>

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
            $('#info').addClass('active');
            $('#info_applicant_index').addClass('active');
        });
        var ue = UE.getEditor('editor', {
            textarea: 'evaluate',
            autoHeightEnabled: false,
        });

        @if(old_or_new_field('evaluate',$data)!=null)
        ue.addListener("ready", function () {

            //editor准备好之后才可以使用
            ue.setContent('{!!old_or_new_field('evaluate',$data)!!}');
        });
        @endif

    </script>
@stop
