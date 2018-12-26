@extends('layouts.admin')

@section('pageTitle')
    意见反馈
@stop

@section('css')
    <style>
        .modal-textarea {
            border: 0;
            width: 100%;
            height: 200px!important;
        }
        .modal-textarea:focus {
            border-color: #66afe9;
            outline: 0;
            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102,175,233,.6);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102,175,233,.6);
        }
        .padding-0 {
            padding: 0;
        }
        .margin-top-lg {
            margin-top: 40px;
        }
        .imgs > img {
            margin-left: 10px;
            margin-right: 10px;
        }
        .panel-heading{
            color: #a94442;
            background-color: #2b4d51;
            border-color: #2b4d51;
        }
    </style>
@stop

@section('content')
    <div class="box shadow">
        <form class="form box-body" method="get" action="" name="">

            <div class="row">
                <div class="col-xs-3 col-lg-2">
                    <div class="form-group">
                        <label class="control-label" for="reply_status">回复状态：</label>
                        <select class="form-control" name="reply_status" id="reply_status">
                            <option value="1"  @if($reply_status ==1)selected="selected" @endif>全部</option>
                            <option value="2"  @if($reply_status ==2)selected="selected" @endif>已回复</option>
                            <option value="3"  @if($reply_status ==3)selected="selected" @endif>未回复</option>
                        </select>
                    </div>
                </div>
            </div>

            <button  class="pretty-btn pull-left" onclick="search('order_list')">
                <span class="glyphicon glyphicon-search"></span> 搜索
            </button>
            <a href="{{ url()->current() }}" class="pretty-btn" data-toggle="tooltip" data-title="重置搜索条件">重置</a>
        </form>

        <div class="box-body">
            <table class="table table-common table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>姓名</th>
                    <th>手机号</th>
                    <th>反馈内容</th>
                    <th>回复内容</th>
                    <th>回复状态</th>
                    <th>提交日期</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @if(count($list_data)>0)
                    @foreach ($list_data as $data)
                        <tr>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->name ? $data->name : '' }}</td>
                            <td>{{ $data->mobile }}</td>
                            <td>{!! $data->content !!}</td><!--反馈内容-->
                            <td class="ellipse max-width-sm">{!! $data->feedback !!} </td><!--回复内容-->
                            <td class="ellipse max-width-sm">{{ $data->created_at==$data->updated_at? '暂未回复':'已回复' }}</td>
                            <td class="ellipse max-width-sm">{{ $data->created_at }}</td>
                            <td>
                                <a class="pretty-btn pretty-btn-xs" data-toggle="modal" data-target="#reply-{{$data->id}}">
                                        {{ $data->updated_at>$data->created_at? '追加回复':'回复' }}
                                </a>
                                <div class="modal fade" id="reply-{{$data->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                <h4 class="modal-title">回复</h4>
                                            </div>
                                            <form action="{{route('admin.feedback.index')}}" method="post">

                                                <div class="modal-body">
                                                    <div>
                                                        <div style="color: #ffffff;background-color: #7bdbe7;border-color: #7bdbe7;">用户反馈信息：</div>
                                                        <div class="panel-body">
                                                            {{$data->content}}
                                                            <br>
                                                            <div class="pull-right">
                                                                {{$data->created_at}}
                                                            </div>
                                                            @if($data->img !=null)
                                                            <div class="row margin-top-lg imgs">
                                                                <a class="example-image-link revolve"
                                                                   href="{{asset('storage').$data->img}}"
                                                                   data-magnify="gallary">
                                                                    <img height="140" width="140"
                                                                         rel="lightbox" class="example-image"
                                                                         src="{{asset('storage').$data->img}}">
                                                                </a>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @if( $data->updated_at>$data->created_at )
                                                        <div >
                                                            <div style="color: #ffffff;background-color: #7bdbe7;border-color: #7bdbe7;">上次回复消息：</div>
                                                            <div  class="panel-body">
                                                                {!! $data->feedback?:'' !!}
                                                                <br>
                                                                <div class="pull-right">
                                                                    {{$data->updated_at}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="panel panel-default">
                                                        <div style="color: #ffffff;background-color: #7bdbe7;border-color: #7bdbe7;">回复信息：</div>
                                                        <div >
                                                            <textarea class="form-control modal-textarea" name="replay"></textarea>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="id" value="{{$data->id}}">
                                                </div>
                                                {{ csrf_field() }}
                                                <div class="modal-footer">
                                                    <button type="button" class="pretty-btn pretty-btn-gray" data-dismiss="modal">取消</button>
                                                    <input type="submit" value="提交" class="pretty-btn">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif

                </tbody>
            </table>
            <div class="text-center">{{ $list_data->appends(['reply_status'=>$reply_status])->links('vendor/pagination/custom') }}</div>
        </div>
    </div>

@stop

@section('js')
    <script>

        $(document).ready(function () {
            $('#operation').addClass('active');
            $('#operation_feedback_index').addClass('active');
        });

    </script>
@stop