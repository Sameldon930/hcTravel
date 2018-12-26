<?php
namespace App\Services\ApiServer\Response;

use App\Feedback;
use App\Merchant;
use App\Notify;
use Validator;

/**
 * 文章列表
 */
class GetNotify extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'GetNotify';

    /**
     * 接口参数检验
     */

    public function checkParams(&$params)
    {
        $rules = [
            'merchant_id' => 'required'
        ];
        $messages = [
            'merchant_id.required' => 'ID缺失',
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

        $merchant = Merchant::where('id',$params['merchant_id'])->first();
        $feedback = Feedback::where('merchant_id',$params['merchant_id'])->orderBy('created_at','desc')->first();
        $feedback->create_at = date('Y-m-d', strtotime($feedback->created_at));
        $notify = Notify::where('created_at','>',$merchant->created_at)->orderBy('created_at','desc')->first();
        $notify->create_at = date('Y-m-d', strtotime($notify->created_at));
        $data = [
            'notify' => $notify,
            'feedback' => $feedback
        ];
        return [
            'status' => true,
            'code' => '200',
            'data' => $data,
        ];
    }


}

