<?php
namespace App\Services\ApiServer\Response;

use App\Merchant;
use App\UserLiveness;
use Validator;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

/**
 * api测试类
 */
class LoginCheck extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称 kui
     * @var string
     * 接口id 0005
     */
    protected $method = 'LoginCheck';

    /**
     * 接口参数检验
     */

    public function checkParams(&$params)
    {

        $token = $params['token'];
        $merchant_id = $params['merchant_id'];

        $array = [
            'status' => false,
            'code' => '0005',
            'msg' => '还未登录'
        ];

        /* $array2=[
             'status' => false,
             'code'   => 0006,
             'msg'    => '用户信息已经修改,请重新登录!'
         ];*/

        //echo Session::get('name');die;
        if ($token == '' || $merchant_id == '') {
            return $array;
        }
        //$user_data=DB::table('users')->where('id','=',$user_id)->first();
        /*if($user_data->mobile!=Session::get('mobile')){
            return $array2;
        }*/

        if (Session::get('token') == $token && Session::get('merchant_id') == $merchant_id) {
            return $this->run($params);
        }

        $merchant_data = Merchant::where('id', '=', $merchant_id)->first();
//        $password = $merchant_data->value('password');//密码
        //$mobile=$user_data->value('mobile');//手机号码
        //dd($this->encrypt($user_id.'_'.$password));
        if ($token == $merchant_data->api_token) {
            Session::put('token', $token);
            Session::put('merchant_id', $merchant_id);
            return $this->run($params);
        } else {
            return $array;
        }

    }

    /**
     * 执行接口
     * @param  array &$params 请求参数
     * @return array
     */
    public function run(&$params)
    {
        return [
            'status' => true,
            'code' => '200',
            'data' => [
                'msg' => '已经登录',
            ]
        ];
    }

    /**
     * 为其他接口提供用户登录检验
     * @param  array &$params 请求参数
     * @return boolean
     */
    public function login_check(&$params)
    {

        $token = isset($params['token']) ? $params['token'] : '';
        $merchant_id = isset($params['merchant_id']) ? $params['merchant_id'] : '';

        if ($token == '' || $merchant_id == '') {
            return false;
        }

        if (Session::get('token') == $token && Session::get('merchant_id') == $merchant_id) {
            return true;
//            return $this->check_status($params);
        }

        $merchant_data = Merchant::where('id', '=', $merchant_id)->first();//密码

        if ($token == $merchant_data->api_token) {
            Session::put('token', $token);
            Session::put('merchant_id', $merchant_id);
            return true;
//            return $this->check_status($params);
        } else {
            return false;
        }

    }

    //检查用户是否被冻结
    public function check_status(&$params)
    {
        if (!Cache::store('file')->has('is_lock') || Cache::store('file')->get('is_lock') == 1) {
            $user_data = DB::table('users')->select('id', 'status')
                ->find($params['user_id']);
            if ($user_data->status == 1) {  //冻结状态
                Cache::store('file')->put('is_lock', 1, 1);
                return false;
            } else {
                Cache::store('file')->put('is_lock', 2, 1);
                UserLiveness::updateLastLogined($params['user_id']);
                return true;
            }
        }

        if (Cache::store('file')->get('is_lock') == 2) {
            UserLiveness::updateLastLogined($params['user_id']);
            return true;
        }
    }

    public function login_verify(&$params)
    {
        $api_token = Merchant::where('id',$params['merchant_id'])->first()->api_token;
        if($api_token == $params['token']) {
            return true;
        }
        return [
            'status' => true,
            'code' => '005',
            'msg' => '身份信息已过期，请重新登陆',
        ];
    }

}
