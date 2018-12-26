@extends('layouts.app')

@section('content')
    <div class="login-container">
        <div class="login">
            <div class="login-card"><h2></h2>
                <form class="form-horizontal" method="POST" action="{{ route('admin.login') }}">
                    {{ csrf_field() }}
                    <div class="login-title"><h1>智慧黄厝商家管理后台</h1></div>
                    <div style="padding-top: 24px;"></div>
                    <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-3 control-label">手机号</label>

                        <div class="col-md-8">
                            <input id="mobile"  class="form-control" name="mobile" value="{{ old('mobile') }}" required autofocus>

                            @if ($errors->has('mobile'))
                                <span class="help-block">
                                <strong>{{ $errors->first('mobile') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-3 control-label">密码</label>

                        <div class="col-md-8">
                            <input id="password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-3">
                            <div class="checkbox" style="display: flex;justify-content: center;">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 记住密码
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-3">
                            <button type="submit" class="btn btn-primary" style="width: 100%;">
                                登录
                            </button>

                           {{-- <a class="btn btn-link" href="--}}{{--{{ route('password.request') }}--}}{{--">
                                Forgot Your Password?
                            </a>--}}
                        </div>
                    </div>
                    <div style="padding-bottom: 8px;"></div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <style>
        .login-container {
            width: 100vw;
            background: url("{{ asset('img/admin-config/login-bg2.jpg') }}") no-repeat;
            background-size: cover;
            overflow-x:hidden;
            overflow-y:hidden;
        }

        .login-title {
            position: absolute;
            width: 100%;
            text-align: center;
            z-index: 10;
            top: -80px;
            color: #ffffff;
        }

        .login-card {
            width: 380px;
        }

        .form-horizontal{
            background-color: #ffffff;
            border-radius: 5px;
            position: relative;
        }

        .login {
            display: flex;
            height: 100vh;
            flex-direction: column;
            align-items: center;
            justify-content: space-around;
            width: 100vw;
        }
    </style>
@endsection
