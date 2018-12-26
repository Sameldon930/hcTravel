<?php
namespace App\Services\ApiServer\Response;

use App\Applicant;
use App\Merchant;
use App\MerchantInfo;
use Carbon\Carbon;
use Validator;

/**
 * 文章列表
 */
class MerchantGetOne extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'MerchantGetOne';

    /**
     * 接口参数检验
     */

    public function checkParams(&$params)
    {
        $rules = [
            'merchant_id' => 'required',
            'token' => 'required'
        ];
        $messages = [
            'merchant_id.required' => 'ID缺失',
            'token.required' => '身份校验失败'
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

        $loginVerify = new LoginCheck();
        if($loginVerify->login_verify($params)){
            $data = Merchant::with('merchantInfo')->where('id',$params['merchant_id'])->first();
            $data->approve = json_decode($data->status);

            return [
                'status' => true,
                'code' => '200',
                'data' => $data,
            ];
        }
        return [
            'status' => true,
            'code' => '005',
            'msg' => '身份信息已过期，请重新登陆',
        ];

    }


}

