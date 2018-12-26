<?php
namespace App\Services\ApiServer\Response;

use App\Merchant;
use Session;
use Validator;
use Illuminate\Support\Facades\Hash;


/**
 * api测试类
 */
class UserLogin extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称 kui
     * @var string
     * 接口id 0001
     */
    protected $method = 'UserLogin';

    /**
     * 接口参数检验
     */

    public function checkParams(&$params)
    {

        $rules = [
            'mobile' => 'required|min:11|max:11',
            'password' => 'required|min:6|max:255',
        ];
        $messages = [
            'mobile.required' => '手机号码缺失',
            'mobile.min' => '手机号码最少11个字符',
            'mobile.max' => '手机号码最多11个字符',
            'password.required' => '密码缺失',
            'password.min' => '密码最少6个字符',
            'password.max' => '密码最多255个字符',
        ];

        $v = Validator::make($params, $rules, $messages);
        // dd( $v);
        if ($v->fails()) {
            return [
                'status' => false,
                'code' => '2001',
                'msg' => $v->errors()->all()
            ];
        } else {
            return $this->run($params);
        }

        //return $this->run($params);

    }

    /**
     * 执行接口
     * @param  array &$params 请求参数
     * @return array
     */
    public function run(&$params)
    {
        $err_1 = ['status' => false, 'code' => '00010001', 'msg' => '手机号或密码错误'];

        $mobile = $params['mobile'];
        $password = $params['password'];

        $check_password = Merchant::where('mobile', '=', $mobile)->value('password');

        if ($check_password == null)
            return $err_1;

        if (!Hash::check($password, $check_password))
            return $err_1;

        $merchant_date = Merchant::where('mobile', '=', $mobile)->first();
        return $this->login_action($merchant_date->id);
    }

    /**
     * 执行登录,设置缓存,返回数据
     * @param  array &$params 请求参数
     * @return array
     */
    public function login_action($id,$register = 1)
    {
        $err_2 = ['status' => false, 'code' => '00010002', 'msg' => '该用户异常(被冻结)'];

        $merchant_data = Merchant::find($id);

        if ($merchant_data->status == 10){
            return $err_2;
        }


//        $loginCheck = new LoginCheck();
        $merchant_id = $merchant_data->id;
        $mobile = $merchant_data->mobile;
        $token = $merchant_data->api_token;

//        $user_data->password = '';
        Session::put('token', $token);
        Session::put('merchant_id', $merchant_id);
        Session::put('mobile', $mobile);
        return [
            'status' => true,
            'code' => '200',
            'data' => $merchant_data,
            'msg' => '登录成功',
            'register' => $register
        ];
    }

}
