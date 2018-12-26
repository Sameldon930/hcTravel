@extends('layouts.admin')

@section('pageTitle')
    商户账变列表
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        商户账变列表
    </div>

@stop

@section('js')
    <script>

        $(document).ready(function () {
            $('#account_change').addClass('active');
            $('#account_change_merchant_account_change_index').addClass('active');
        });

    </script>
@stop