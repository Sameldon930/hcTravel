<?php
namespace App\Services\ApiServer\Response;

use App\Article;
use App\HomestayInfo;
use App\Merchant;
use App\MerchantInfo;
use App\VerifyLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;

/**
 * 保存商户信息
 */
class SaveMerchantInfo extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     *
     * @var string
     */
    protected $method = 'SaveMerchantInfo';

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

        $merchant_info= MerchantInfo::where('merchant_id',$params['merchant_id'])->first();
        if(empty($merchant_info)){
            return [
                'status' => false,
                'code' => '404',
                'msg' => '商户未填写数据',
            ];
        }

        if($merchant_info->business_img== null||$merchant_info->identity_front== null||$merchant_info->contract_tenancy== null||$merchant_info->merchant_name== null){
            return [
                'status' => false,
                'code' => '202',
                'msg' => '信息未填写完整，请先填写完整',
            ];
        }

        $merchant_info->status = MerchantInfo::IN_AUDIT;
        $merchant_info->save();
        $verify_success = json_encode([
            'business_img'=>$merchant_info->business_img,
            'business_num'=>$merchant_info->business_num,
            'business_name'=>$merchant_info->business_name,
            'business_person'=>$merchant_info->business_person,
            'business_address'=>$merchant_info->business_address,
            'identity_front'=>$merchant_info->identity_front,
            'identity_contrary'=>$merchant_info->identity_contrary,
            'identity_num'=>$merchant_info->identity_num,
            'identity_name'=>$merchant_info->identity_name,
            'contract_tenancy'=>$merchant_info->contract_tenancy,
            'merchant_address'=>$merchant_info->merchant_address,
            'merchant_short_name'=>$merchant_info->merchant_short_name,
            'merchant_name'=>$merchant_info->merchant_name,
            'merchant_principal'=>$merchant_info->merchant_principal,
        ]);
        $verify_data = [
          'merchant_id'=>$params['merchant_id'],
          'verify_success'=>$verify_success,
          'type'=>VerifyLog::MERCHANT_VERIFY,
        ];

        $veifylog = VerifyLog::create($verify_data);
        $merchantModel = new Merchant();
        $merchant = Merchant::find($params['merchant_id']);
        $merchantModel->auditIn($merchant,Merchant::STATUS_ARRAY[0]);


        return [
            'status' => true,
            'code' => '200',
        ];
    }


}