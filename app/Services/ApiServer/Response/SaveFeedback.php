<?php
namespace App\Services\ApiServer\Response;

use App\Applicant;
use App\Feedback;
use App\Merchant;
use App\MerchantInfo;
use Carbon\Carbon;
use Validator;

/**
 * 意见反馈
 */
class SaveFeedback extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'SaveFeedback';

    /**
     * 接口参数检验
     */

    public function checkParams(&$params)
    {
        $rules = [
            'merchant_id' => 'required',
            'token' => 'required',
            'content' => 'required'
        ];
        $messages = [
            'merchant_id.required' => 'ID缺失',
            'token.required' => '身份校验失败',
            'content.required' => '反馈内容不能为空'
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
        $merchant_id = $params['merchant_id'];
        if($loginVerify->login_verify($params)){
            $common = new Common();
            if(!empty($params['img'])){
                $img_path = $common->save_img($merchant_id,$params['img'],'feedback');
                $params['img'] = $img_path;
            }

            Feedback::create($params);
//            $data = Merchant::with('merchantInfo')->where('id',$params['merchant_id'])->first();
            return [
                'status' => true,
                'code' => '200',
                'msg' => '意见反馈成功！',
            ];
        }
        return [
            'status' => true,
            'code' => '005',
            'msg' => '身份信息已过期，请重新登陆',
        ];

    }


}

