<?php
namespace App\Services\ApiServer\Response;

use App\Article;
use App\HomestayInfo;
use App\Merchant;
use App\MerchantInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Validator;

/**
 * 获取用户审核状态
 */
class GetVerifyStatus extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     *
     * @var string
     */
    protected $method = 'GetVerifyStatus';

    /**
     * 接口参数检验
     */

    public function checkParams(&$params)
    {
        $login = new LoginCheck();
        if(!$login->login_verify($params)){
            return [
                'status' => false,
                'code' => '005',
                'msg' => '请先登录'
            ];
        }
        $rules = [
            'merchant_id' => 'required',
        ];
        $messages = [
            'merchant_id.required' => '缺少商户id',
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

        $merchant =Merchant::where('id',$params['merchant_id'])
            ->with('merchantInfo')
            ->with('homestayInfo')
            ->first();
        if(empty($merchant)){
            return [
                'status' => false,
                'code' => '404',
                'msg'=>'用户不存在'
            ];
        }

        $data['merchant_data'] = $merchant;
        $data['merchant'] = Merchant::getStatus($merchant,Merchant::STATUS_ARRAY[0]);
        $data['dorm'] = Merchant::getStatus($merchant,Merchant::STATUS_ARRAY[1]);
        $data['house'] = Merchant::getStatus($merchant,Merchant::STATUS_ARRAY[2]);
        $data['house_msg'] = Merchant::HOUSE_STATUS[ $data['house']];
        $data['dorm_msg'] = Merchant::DORM_STATUS[ $data['dorm']];
        $data['merchant_msg'] = Merchant::MERCHANT_STATUS[  $data['merchant']];
        return [
            'status' => true,
            'code' => '200',
            'data' => $data,
        ];


    }



}
