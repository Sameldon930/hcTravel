<?php
namespace App\Services\ApiServer\Response;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Log;


/**
 * api测试类
 */
class WeixinLogin extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称 kui
     * @var string
     * 接口id 0016
     */
    protected $method = 'WeixinLogin';

    /**
     * 接口参数检验
     */

    public function checkParams(&$params)
    {
        return $this->run($params);
    }

    /**
     * 执行接口
     * @param  array &$params 请求参数
     * @return array
     */
    public function run(&$params)
    {
        session_start();

        $config=config('wechat');
        $app = Factory::officialAccount($config);


        $oauth = $app->oauth;
        //Log::info($_SESSION['wechat_user']);
        if (empty($_SESSION['wechat_user'])) {
            $_SESSION['target_url'] = $_SERVER['HTTP_ORIGIN'] . '/index.html';
            $response = $oauth->redirect();
            $TargetUrl = $response->getTargetUrl();
            return ['href' => $TargetUrl,
                'code' => '201'
            ];
        }

        // 已经登录过
        $user = $_SESSION['wechat_user'];
        $openid = $user['id'];
        Log::info($openid);
        return ['href' => $_SERVER['HTTP_ORIGIN'] . '/index.html',
            'code' => '201'
        ];

    }

    //微信绑定用户
    public function wx_bind_user(&$params, $openid)
    {
        $rules = [
            'mobile' => 'required|numeric|digits_between:11,11',
            'mobile_code' => 'required|numeric|digits_between:4,6',
        ];
        $messages = [
            'mobile.required' => '手机号码缺失',
            'mobile.numeric' => '手机号码必须为数字',
            'mobile.digits_between' => '手机号码为11位数字组合',
            'mobile_code.required' => '验证码缺失',
            'mobile_code.numeric' => '验证码必须为数字',
            'mobile_code.digits_between' => '验证码必须在4-6位之间',
        ];

        $v = Validator::make($params, $rules, $messages);
        // dd( $v);
        if ($v->fails()) {
            return [
                'status' => false,
                'code' => '2001',
                'msg' => $v->errors()->all()];
        }


        $err_4 = ['status' => false, 'code' => '00060001', 'msg' => '手机验证码错误'];
        $err_5 = ['status' => false, 'code' => '00060002', 'msg' => '手机号未注册,请前往注册或者更换手机号'];

        $mobile = $params['mobile'];
        $mobile_code = $params['mobile_code'];
        $mobile_check = new MobileMsgCheck();
        if (!$mobile_check->mobile_code_check($mobile, $mobile_code))
            return $err_4;

        $user_data = User::where('mobile', '=', $mobile)->first();
        if (empty($user_data)) {
            return $err_5;
        }

        $user_data->wx_openid = $openid;

        $user = $_SESSION['wechat_user'];
        $user_data->wx_headimgurl = $user['avatar'];
        $user_data->wx_nickname = json_encode($user['nickname']);

        $user_data->save();
        $user_login = new UserLogin();
        return $user_login->login_action($user_data->id);
    }

    //微信登录
    public function wx_login(&$params, $openid)
    {

        $user_data = User::where('wx_openid', '=', $openid)->first();

        if (!empty($user_data)) {

            if (empty($user_data->wx_headimgurl)) {
                $user = $_SESSION['wechat_user'];
                $user_data->wx_headimgurl=$user['avatar'];
                $user_data->wx_nickname=json_encode($user['nickname']);
                $user_data->save();
            }
            $user_login = new UserLogin();
            return $user_login->login_action($user_data->id);

        } else {
            return [
                'status' => false,
                'code' => '2000',
                'data' => $user_data,
                'msg' => '需要绑定'
            ];
        }
    }


}