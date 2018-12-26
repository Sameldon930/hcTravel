<?php
namespace App\Services\ApiServer\Response;

use App\Merchant;
use Validator;

/**
 * 文章详情
 */
class SetAgreement extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     *
     * @var string
     */
    protected $method = 'SetAgreement';

    /**
     * 接口参数检验
     */

    public function checkParams(&$params)
    {
        $rules = [
            'merchant_id' => 'required',
        ];
        $messages = [
            'merchant_id.required' => '商户id缺少',
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

    }

    /**
     * 执行接口
     * @param  array &$params 请求参数
     * @return array
     */
    public function run(&$params)
    {

        $merchant = Merchant::where('id',$params['merchant_id'])->first();
        if(empty($merchant)){
            return [
                'status' => false,
                'code' => '404',
                'msg' => '该商户不存在',
            ];
        }

        $login_check = new LoginCheck();
        if($login_check->login_verify($params)){
            $merchant->flow_status = 2;
            $merchant->save();
        } else {
            return [
                'status' => false,
                'code' => '005'
            ];
        }

        return [
            'status' => true,
            'code' => '200',
        ];
    }


}
