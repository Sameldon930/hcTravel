<?php
namespace App\Http\Controllers;
use App\Lib\WxMsg\WxMsg;

/**
 * api测试类
 */
class TestController extends Controller
{


    /**
     * 执行接口
     * @param  array &$params 请求参数
     * @return array
     */
    public function index(){
		$option=config('wechat');
		$a=new WxMsg($option);
		$a->notice_send('check_info','www.baidu.com');
    }


}