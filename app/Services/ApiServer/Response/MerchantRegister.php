<?php
namespace App\Services\ApiServer\Response;

use App\Merchant;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Lib\MobileMsg\MobileMsgSend;


/**
 * api测试类
 */
class MerchantRegister extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称 kui
     * @var string
     * 接口id 0002
     */
    protected $method = 'MerchantRegister';

    /**
     * 接口参数检验
     */

    public function checkParams(&$params)
    {
        return $this->run($params);
        $rules = [
            'mobile' => 'required|min:11|max:11',
            'password' => 'required|min:6|max:255',
            'mobile_code' => 'required|numeric',
        ];
        $messages = [
            'mobile.required' => '手机号码缺失',
            'mobile.min' => '手机号码最少11个字符',
            'mobile.max' => '手机号码最多11个字符',
            'password.required' => '手机号码缺失',
            'password.min' => '密码最少6个字符',
            'password.max' => '密码最多255个字符',
            'mobile_code.required' => '短信验证缺失',
            'mobile_code.numeric' => '短信验证必须为数字',
        ];
        $v = Validator::make($params, $rules, $messages);
        if ($v->fails()) {
            return [
                'status' => false,
                'code' => '2001',
                'msg' => $v->errors()->all()
            ];
        } else {
            return $this->run($params);
        }

    }

    /**
     * 执行接口
     * @param  array &$params 请求参数
     * @return array
     */
    public function run(&$params)
    {


        $err_2 = ['status' => false, 'code' => '00020002', 'msg' => '手机号错误'];
        $err_3 = ['status' => false, 'code' => '00020003', 'msg' => '注册失败,请联系管理员'];
        $err_4 = ['status' => false, 'code' => '00020004', 'msg' => '手机验证码错误'];
        $err_5 = ['status' => false, 'code' => '00020005', 'msg' => '该手机已经注册'];


        $mobile_code = $params['mobile_code'];
        $mobile = $params['mobile'];
        $password = $params['password'];


        if (!isMobile($params['mobile'])) {
            return $err_2;
        };


//        return [
//            'msg' => $this->mobile_code_check($mobile, $mobile_code)
//        ];
        //校验手机验证码
       if (!$this->mobile_code_check($mobile, $mobile_code))
            return $err_4;

//        //校验重复手机号 认领
//        $has_mobile = Merchant::where('mobile', '=', $mobile)->first();
//        if (!empty($has_mobile))
//            return $err_5;



        $password = bcrypt($password);


        $test_number = str_pad(mt_rand(0, 999999), 6, "0", STR_PAD_BOTH);
        $api_token = str_random(60);
        $is_register = 1;

        $has_mobile = Merchant::where('mobile', '=', $mobile)->first();
        if (!empty($has_mobile)) {
            if(!empty($has_mobile)) {
                return $err_5;
            }
            $create_data = [
                'password'=>$password,
                'api_token'=>$api_token,
            ];
            $is_register = 2;
            $has_mobile->update($create_data);
        } else {
            $create_data = [
                'mobile'=>$mobile,
                'password'=>$password,
                'api_token'=>$api_token,
            ];
            Merchant::create($create_data);
        }
        //注册用户,插入数据
        
//        $result_id = DB::table('users')->insertGetId(['mobile' => $mobile, 'dir_sun_id' => '', 'rid' => $rid, 'password' => $password, 'aid' => $rid_data->aid, 'sid' => $rid_data->sid, 'level' => 1, 'created_at' => Carbon::now(), 'mattered_at' => Carbon::now()]);
//
//        if (!$result_id)
//            return $err_3;
        

//        Cache::store('file')->pull($mobile . '_mobile_code');

        //发送手机短信
//        $send_mobile_msg = new MobileMsgSend();
//        $msg = $mobile;
//        $send_mobile_msg->send($rid_data->mobile, $msg, 152047, env('APP_DEBUG'));

        //微信公众号发送
//        $data = [
//            'user_id' => $result_id,
//            'type' => 'user_register',
//            'url' => PHP_SAPI === 'cli' ? false : $_SERVER['HTTP_ORIGIN'] . '/wallet_merchant_details.html',
//        ];
//        $job = (new WxMsgSendAction($data))->delay(Carbon::now()->addMinutes(1));
//        dispatch($job);

        //使用登录接口统一返回登录信息
        $result_id = Merchant::where('mobile',$mobile)->first()->id;
        $user_login = new UserLogin();
        return $user_login->login_action($result_id,$is_register);

    }




    /**
     * 验证短信验证码
     * @param $mobile
     * @param $mobile_code
     * @return bool
     */
    public function mobile_code_check($mobile, $mobile_code)
    {
        $cache_mobile_code = Cache::store('file')->get($mobile . '_mobile_code');
        if ($cache_mobile_code != $mobile_code) {
            return true;
        }
        Cache::store('file')->pull($mobile . '_mobile_code');
        return true;
    }
}
