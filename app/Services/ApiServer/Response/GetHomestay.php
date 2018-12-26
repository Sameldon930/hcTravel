<?php
namespace App\Services\ApiServer\Response;

use App\Article;
use App\HomestayInfo;
use App\Merchant;
use App\MerchantInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Validator;

/**
 * 文章详情
 */
class GetHomestay extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     *
     * @var string
     */
    protected $method = 'GetHomestay';

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


        $data = HomestayInfo::where('merchant_id',$params['merchant_id'])->first();

        if(empty($data)){
            return [
                'status' => true,
                'code' => '202',
                'msg' => '用户未填写相关信息',
            ];
        }
        $data->property_img = json_decode( $data->property_img);
        $data->property_img_1 = json_decode( $data->property_img_1);
        $data->property_img_2 = json_decode( $data->property_img_2);
        $data->property_img_3 = json_decode( $data->property_img_3);
        $data->property_img_4 = json_decode( $data->property_img_4);
        $data->property_img_5 = json_decode( $data->property_img_5);
        $data->property_img_6 = json_decode( $data->property_img_6);
        $data->property_img_7 = json_decode( $data->property_img_7);
        $data->contract_tenancy = json_decode( $data->contract_tenancy);

        return [
            'status' => true,
            'code' => '200',
            'data' => $data,
            ];



    }



}
