Array.prototype.range = function ( start,end ){
    var _self = this;
    var length = end - start +1;
    var step = start - 1;
    return Array.apply(null,{length:length}).map(function (v,i){step++;return step;});
};

/**
 * 获取查询字符串
 * 例子 url: localhost?id=2 => getQueryString("id") -> 2
 * @param name
 * @returns {string}
 */
function getQueryString(name)
{
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if(r!=null)return  unescape(r[2]); return null;
}

//隐藏未选择上传时的占位
function hideFileImg() {
    var files = $("[type='file']")
    for(var i=0; i < files.length; i++ ){
        var file_id = files[i].id;
        if($('#'+file_id).attr('accept') == 'image/*'){
            if($('#'+file_id+'-preview').attr('src').length == 0){
                $('#'+file_id+'-preview').parent('.img-size').hide();
            };
        }

    }
}

$('[data-target="file-button"]').on('click', function (e) {
    var id = $(this).attr('id');
    var file_id = id.split("-")[0];
    $('#'+file_id).click();
});

function loading(){
    $("#wis-loading").show();
}
function stopLoading(){
    $("#wis-loading").hide();
}

// bootstrap-switch开关事件
$('[data-target="operate-status"]').on('switch-change', function (e, data) {
    var id = $(this).data("id");
    var url = $(this).data("url");
    var status = data.value ? 1 : 2;
    $.ajax({
        url: url,
        data: { id: id, status: status },
        success: function (data) {
            if (Number(data.code) === 200){
                toastr.success(data.msg);
            }else {
                toastr.error(data.msg);
            }

        },
        error: function (data) {
            toastr.error(data.msg);
        },
    });
});