@extends('layouts.admin')

@section('pageTitle')
    文章分类便捷
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        <div>@if($data)修改{{$data->name}}@else 添加文章类别 @endif</div>
        <div class="padding-top-sm">
            {{ Form::open(['method'=>$data?'put':'post','route' => ['admin.article_type.'.($data?'update':'store'),'update'=>($data?$data->id:$data)]]) }}
            <div class=" form-group">
                {{Form::label('name','文章分类名:')}}
                {{Form::text('name',old_or_new_field('name',$data),['class'=>'form-input'])}}
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
            $('#info_article_type_index').addClass('active');
        });
    </script>
@stop