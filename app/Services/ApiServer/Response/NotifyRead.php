<?php
namespace App\Services\ApiServer\Response;

use App\Feedback;
use App\Merchant;
use App\Notify;
use Validator;

/**
 * 文章详情
 */
class NotifyRead extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     *
     * @var string
     */
    protected $method = 'NotifyRead';

    /**
     * 接口参数检验
     */

    public function checkParams(&$params)
    {
        $rules = [
            'merchant_id' => 'required',
            'notify_id' => 'required'
        ];
        $messages = [
            'merchant_id.required' => '商户id缺少',
            'notify_id.required' => '通知id缺少',
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

        $notify = Notify::where('id',$params['notify_id'])->first();

        $login_check = new LoginCheck();
        if($login_check->login_verify($params)){
            $notify->save();
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
