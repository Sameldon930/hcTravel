@extends('layouts.admin')

@section('pageTitle')
    操作日志
@stop

@section('css')
    <style>

    </style>
@stop

@section('content')
    <div class="box">

        <div class="box-body">
            @include('component.search_form')
        </div>

        <div class="box-body">
            <table class="table table-bordered text-center table-hover table-responsive">
                <tbody>
                <tr>
                    <th>ID</th>
                    <th>操作管理员</th>
                    <th>操作说明</th>
                    <th>操作时间</th>
                </tr>
                @foreach($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->admin->name }}</td>
                        <td>{{ $item->note }}</td>
                        <td>{{ $item->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-center">{{ links_custom($data, $search_items) }}</div>
    </div>

@stop

@section('js')
    @yield('date_search')
    <script>

        $(document).ready(function () {
            $('#system').addClass('active');
            $('#system_admin_index').addClass('active');
        });

    </script>
@stop