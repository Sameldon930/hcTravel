<?php
namespace App\Services\ApiServer\Response;

use App\Feedback;
use App\Merchant;
use Validator;

/**
 * 文章详情
 */
class FeedbackRead extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     *
     * @var string
     */
    protected $method = 'FeedbackRead';

    /**
     * 接口参数检验
     */

    public function checkParams(&$params)
    {
        $rules = [
            'merchant_id' => 'required',
            'feedback_id' => 'required'
        ];
        $messages = [
            'merchant_id.required' => '商户id缺少',
            'feedback_id.required' => '反馈id缺少',
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

        $feedback = Feedback::where('id',$params['feedback_id'])->first();

        $login_check = new LoginCheck();
        if($login_check->login_verify($params)){
            $feedback->is_read = 1;
            $feedback->save();
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
