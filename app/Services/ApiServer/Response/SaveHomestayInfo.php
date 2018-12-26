<?php
namespace App\Services\ApiServer\Response;

use App\Article;
use App\HomestayInfo;
use App\Merchant;
use App\MerchantInfo;
use App\VerifyLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Validator;

/**
 * 民宿信息表
 */
class SaveHomestayInfo extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     *
     * @var string
     */
    protected $method = 'SaveHomestayInfo';

    /**
     * 接口参数检验
     */

    public function checkParams(&$params)
    {   $login = new LoginCheck();
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

        $homestay = HomestayInfo::where('merchant_id',$params['merchant_id'])->first();
        if(empty($homestay)){
            return [
                'status' => false,
                'code' => '404',
                'msg' => '商户未填写数据',
            ];
        }
        if(
            $homestay->business_img == null||$homestay->identity_front== null||$homestay->contract_tenancy == null||
            $homestay->merchant_name== null||$homestay->alibi_img == null||
            (
                $homestay->property_img== null&&$homestay->property_img_1== null && $homestay->property_img_2== null && $homestay->property_img_3== null
                && $homestay->property_img_4== null && $homestay->property_img_5== null && $homestay->property_img_6== null && $homestay->property_img_7== null
            )
        )
        {
            return [
                'status' => false,
                'code' => '204',
                'msg' => '信息未填写完整，请先填写完整',
            ];
        }
        $merchantModel = new Merchant();
        $merchant = Merchant::find($params['merchant_id']);
        $merchantModel->auditIn($merchant,Merchant::STATUS_ARRAY[1]);
        $homestay->status = HomestayInfo::IN_AUDIT;
        $homestay->save();
        $verify_success = json_encode([
            'business_img'=>$homestay->business_img,
            'business_num'=>$homestay->business_num,
            'business_name'=>$homestay->business_name,
            'business_person'=>$homestay->business_person,
            'business_address'=>$homestay->business_address,
            'identity_front'=>$homestay->identity_front,
            'identity_contrary'=>$homestay->identity_contrary,
            'identity_num'=>$homestay->identity_num,
            'identity_name'=>$homestay->identity_name,
            'contract_tenancy'=>$homestay->contract_tenancy,
            'property_img'=>$homestay->property_img,
            'property_img_1'=>$homestay->property_img_1,
            'property_img_2'=>$homestay->property_img_2,
            'property_img_3'=>$homestay->property_img_3,
            'property_img_4'=>$homestay->property_img_4,
            'property_img_5'=>$homestay->property_img_5,
            'property_img_6'=>$homestay->property_img_6,
            'property_img_7'=>$homestay->property_img_7,
            'alibi_img'=>$homestay->alibi_img,
            'merchant_address'=>$homestay->merchant_address,
            'merchant_short_name'=>$homestay->merchant_short_name,
            'merchant_name'=>$homestay->merchant_name,
            'merchant_principal'=>$homestay->merchant_principal,
        ]);
        $verify_data = [
            'merchant_id'=>$params['merchant_id'],
            'verify_success'=>$verify_success,
            'type'=>VerifyLog::HOMESTAY_VERIFY,
        ];
        $veifylog = VerifyLog::create($verify_data);
        return [
            'status' => true,
            'code' => '200',
        ];
    }


}