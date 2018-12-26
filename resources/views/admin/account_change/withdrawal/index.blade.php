@extends('layouts.admin')

@section('pageTitle')
    提现列表
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">
        提现列表
    </div>

@stop

@section('js')
    <script>

        $(document).ready(function () {
            $('#account_change').addClass('active');
            $('#account_change_withdrawal_index').addClass('active');
        });

    </script>
@stop