<?php
namespace App\Services\ApiServer\Response;

use App\Merchant;
use Validator;

/**
 * 保存商户名字
 */
class SaveMerchantName extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     *
     * @var string
     */
    protected $method = 'SaveMerchantName';

    /**
     * 接口参数检验
     */

    public function checkParams(&$params)
    {
        $rules = [
            'merchant_id' => 'required',
            'name' => 'required',
        ];
        $messages = [
            'merchant_id.required' => '商户id缺少',
            'name.required' => '昵称不能为空'
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
            $merchant->name = $params['name'];
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
