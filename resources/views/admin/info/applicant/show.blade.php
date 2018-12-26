@extends('layouts.admin')

@section('pageTitle')
    求职详情
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        求职详情
    </div>

@stop

@section('js')
    <script>

        $(document).ready(function () {
            $('#info').addClass('active');
            $('#info_applicant_index').addClass('active');
        });

    </script>
@stop
