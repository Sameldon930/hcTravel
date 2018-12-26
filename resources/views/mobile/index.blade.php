@extends('mobile.layouts.app')
@section('content')
    <van-row>
        <van-col span="8">span: 8</van-col>
        <van-col span="8">span: 8</van-col>
        <van-col span="8">span: 8</van-col>
    </van-row>

    <van-row>
        <van-col span="4">span: 4</van-col>
        <van-col span="10" offset="4">offset: 4, span: 10</van-col>
    </van-row>

    <van-row>
        <van-col offset="12" span="12">offset: 12, span: 12</van-col>
    </van-row>
    <van-badge-group :active-key="activeKey">
        <van-badge title="标签名称" @click="onClick" info="199" />
    </van-badge-group>
@endsection

@section('js')
    <script>
        var app = new Vue({
            el:"#app",
            data() {
                return {
                    activeKey: 0
                };
            },
            methods: {
                onClick(key) {
                    console.log('1111111111111111')
                }
            }
        });
    </script>
@endsection
