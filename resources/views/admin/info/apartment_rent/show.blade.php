@extends('layouts.admin')

@section('pageTitle')
    招租详情
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        招租详情
    </div>
@stop

@section('js')
    <script>

        $(document).ready(function () {
            $('#info').addClass('active');
            $('#info_apartment_rent_index').addClass('active');
        });

    </script>
@stop
