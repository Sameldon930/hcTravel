<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>智慧黄厝后台</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/ionicons.min.css">
    <link rel="stylesheet" href="/css/AdminLTE.min.css">
    <link rel="stylesheet" href="/css/skin-blue.min.css">
    <link rel="stylesheet" href="/css/toastr.min.css">
    <link rel="stylesheet" href="/css/bootstrap-switch.css">
    <link rel="stylesheet" href="/css/bootstrapValidator.css">
    <link rel="stylesheet" href="/css/datepicker3.css">
    <link rel="stylesheet" href="/css/jquery.magnify.min.css">
    <link rel="stylesheet" href="/css/common.css">
    <style>

    </style>
    @yield('css')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- 头部 -->
@include('admin.include.header')


{{-- 侧边导航 --}}
@include('admin.include.sidebar')


<!-- 内容 -->
<div class="content-wrapper">
    <section class="content">
        <div class="box shadow ">

            <div class="text-center">
                数据暂不开放
            </div>

        </div>
    </section>
</div>

<!-- 页脚 -->
@include('admin.include.footer')

</div>
<script src="/js/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/bootstrap-switch.js"></script>
<script src="/js/vue.js"></script>
<script src="/js/adminlte.min.js"></script>
<script src="/js/toastr.min.js"></script>
<script src="/js/file-preview.js"></script>
<script src="/js/bootstrap-datepicker.js"></script>
<script src="/js/axios.min.js"></script>
<script src="/js/bootstrapValidator.min.js"></script>
<script src="/js/jquery.magnify.min.js"></script>
<script src="/js/common.js"></script>

<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "0",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "30000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    // 小屏时调整表格padding
    if (document.body.clientWidth <= 1024) {
        $("table").addClass("table-condensed")
    }

    // 表格每个单元格附上title
    $("tr > td").each(function (i) {
        if ($(this).children("a")[0] || $(this).children("button")[0]) {
            return false
        }
        $(this).attr("title", $(this).text())
    });

    var err_arr = new Array();
    @if(count($errors) >0)
    @foreach($errors->all() as $error)
    err_arr.push('{{$error}}');
    @endforeach
            @endif
    if (err_arr.length > 0) {
        for (var i = 0; i < err_arr.length; i++) {
            toastr.error(err_arr[i])
        }
    }

    /* 初始化折叠表格 */
    //为td设置宽，使tr填充满tbody
    $(document).ready(function () {
        $tbody_width = $("table[data-action='collapse'] tbody:last-child").width();
        $td_count = $("table[data-action='collapse'] tbody tr:first").find('th').length;
        $("table[data-action='collapse'] tbody:last-child tr:first").find('th').width($tbody_width / $td_count);
    })

    $("table[data-action='collapse'] tr").hover(
        function () {
            var $this = $(this);
            $this.parents("table").find("tbody").not($this.parent()).find("tr").eq($this.index()).addClass("hover");
        },
        function () {
            var $this = $(this);
            $this.parents("table").find("tbody").not($this.parent()).find("tr").eq($this.index()).removeClass("hover");
        }
    )
    var initTableCollapse = function (box) {
        box = box.find("tbody").not(".pull-left");
        if (box instanceof jQuery) {
            box = box[0]
        }
        if (!box) return;
        var mousewheel = addMousewheelEvent();
        mousewheel(box, "mousewheel", function (event) {
            if (event.delta > 0 && this.scrollLeft > 0) {  //
                this.scrollLeft -= 100;
            } else if (event.delta < 0 && (this.scrollLeft + this.clientWidth < this.scrollWidth)) { //
                this.scrollLeft += 100;
            } else {
                return;
            }

            event.preventDefault();
        });
    };
    initTableCollapse($("table[data-action='collapse']"));

    var message = '';
    @if(session('msg')!=null)
        message = '{{session('msg')}}';
    @endif
    if (message != '') {
        toastr.success(message);
    }
</script>
@yield('js')
</body>
</html>