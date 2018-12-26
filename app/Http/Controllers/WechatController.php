<?php
namespace App\Http\Controllers;
use EasyWeChat\Factory;
use App\ExternalApiLog;
use Illuminate\Support\Facades\Log;

/**
 * api测试类
 */
class WeChatController extends Controller
{


    /**
     * 执行接口
     * @param  array &$params 请求参数
     * @return array
     */
    public function oauth(){

		session_start();
		// http://easywechat.org/oauth_callback
		//echo $_SESSION['target_url'];die;

		$config =  config('wechat');
		$app = Factory::officialAccount($config);

		//$config =  config('wechat');
		//$app = new Application($config);
		$oauth = $app->oauth;
		// 获取 OAuth 授权结果用户信息
		$user = $oauth->user();
		$_SESSION['wechat_user'] = $user->toArray();
		//dd($_SESSION['wechat_user']);
		Log::info($_SESSION['wechat_user']);
		$targetUrl = empty($_SESSION['target_url']) ? '/' : $_SESSION['target_url'];
		header('location:'. $targetUrl); // 跳转到 user/profile
        
    }


}