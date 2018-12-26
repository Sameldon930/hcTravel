<?php
namespace App\Services\ApiServer\Response;

use App\Article;
use App\HomestayInfo;
use App\HouseAudit;
use App\Merchant;
use App\MerchantInfo;
use App\VerifyLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Validator;

/**
 * 民宿认证表
 */
class SaveHouseAudit extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     *
     * @var string
     */
    protected $method = 'SaveHouseAudit';

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
            'address_img' => 'required',
            'system_img' => 'required',
            'duty_img_1' => 'required',
            'duty_img_2' => 'required',
            'mass_img' => 'required',
            'safe_img' => 'required',
            'self_img' => 'required',
            'audit_img' => 'required',
            'accredit_img' => 'required',

        ];
        $messages = [
            'merchant_id.required' => '商户id缺少',
            'address_img.required' => '请上传公共场所地址方位示意图',
            'system_img.required' => '请上传公共制度',
            'duty_img_1.required' => '请上传黄厝社区民宿经营责任协议书',
            'duty_img_2.required' => '请上传黄厝社区民宿经营责任协议书',
            'mass_img.required' => '请上传建筑结构质量鉴定委托书',
            'safe_img.required' => '请上传民宿业治安管理制度',
            'self_img.required' => '请上传厦门市个体工商户安全生产标准化建设自评表',
            'audit_img.required' => '请上传厦门市民宿经营申报联合核验表',
            'accredit_img.required' => '请上传授权委托书',
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

        $merchant = Merchant::find($params['merchant_id']);
        Merchant::getStatus($merchant,Merchant::STATUS_ARRAY[2]);
        $merchant_id = $merchant->id;
        $common = new Common();
        if(stripos($params['address_img'],'storage') !=false){
            $address_img=explode('storage',$params['address_img'])[1];
        }else{
            $address_img = $common->save_img($merchant_id,$params['address_img'],'house_address-');
        }
        if(stripos($params['system_img'],'storage') !=false){
            $system_img=explode('storage',$params['system_img'])[1];
        }else{
            $system_img = $common->save_img($merchant_id,$params['system_img'],'house_system-');
        }
        if(stripos($params['duty_img_1'],'storage') !=false){
            $duty_img_1_path=explode('storage',$params['duty_img_1'])[1];
        }else{
            $duty_img_1_path = $common->save_img($merchant_id,$params['duty_img_1'],'house_img_1-');
        }
        if(stripos($params['duty_img_2'],'storage') !=false){
            $duty_img_2_path=explode('storage',$params['duty_img_2'])[1];
        }else{
            $duty_img_2_path = $common->save_img($merchant_id,$params['duty_img_2'],'house_img_2-');
        }
        if(stripos($params['mass_img'],'storage') !=false){
            $mass_img=explode('storage',$params['mass_img'])[1];
        }else{
            $mass_img = $common->save_img($merchant_id,$params['mass_img'],'house_mass_img-');
        }
        if(stripos($params['safe_img'],'storage') !=false){
            $safe_img=explode('storage',$params['safe_img'])[1];
        }else{
            $safe_img = $common->save_img($merchant_id,$params['safe_img'],'house_safe_img-');
        }
        if(stripos($params['self_img'],'storage') !=false){
            $self_img=explode('storage',$params['self_img'])[1];
        }else{
            $self_img = $common->save_img($merchant_id,$params['self_img'],'house_self_self-');
        }
        if(stripos($params['audit_img'],'storage') !=false){
            $audit_img=explode('storage',$params['audit_img'])[1];
        }else{
            $audit_img = $common->save_img($merchant_id,$params['audit_img'],'house_audit_audit-');
        }
        if(stripos($params['accredit_img'],'storage') !=false){
            $accredit_img=explode('storage',$params['accredit_img'])[1];
        }else{
            $accredit_img = $common->save_img($merchant_id,$params['accredit_img'],'house_accredit-');
        }

        //将图片转JSON
        $duty_img_path = [];
        $duty_img_path[] = $duty_img_1_path;
        $duty_img_path[] = $duty_img_2_path;
        $duty_img= json_encode($duty_img_path);


        $house_audit = HouseAudit::where('merchant_id',$params['merchant_id'])->first();
        $house_audit->address_img = $address_img;
        $house_audit->system_img = $system_img;
        $house_audit->duty_img = $duty_img;
        $house_audit->mass_img = $mass_img;
        $house_audit->safe_img = $safe_img;
        $house_audit->self_img = $self_img;
        $house_audit->audit_img = $audit_img;
        $house_audit->accredit_img = $accredit_img;
        $house_audit->status = HouseAudit::IN_AUDIT;
        $house_audit->save();
        $merchantModel = new Merchant();
        $merchantModel->auditIn($merchant,Merchant::STATUS_ARRAY[2]);
        $verify_success = json_encode([
            'img'=>$house_audit->img,
            'code'=>$house_audit->code,
            'address_img'=>$house_audit->address_img,
            'system_img'=>$house_audit->system_img,
            'duty_img'=>$house_audit->duty_img,
            'mass_img'=>$house_audit->mass_img,
            'safe_img'=>$house_audit->safe_img,
            'self_img'=>$house_audit->self_img,
            'audit_img'=>$house_audit->audit_img,
            'accredit_img'=>$house_audit->accredit_img,
        ]);
        $verify_data = [
            'merchant_id'=>$params['merchant_id'],
            'verify_success'=>$verify_success,
            'type'=>VerifyLog::HOUSE_VERIFY,
        ];
        $veifylog = VerifyLog::create($verify_data);

        return [
            'status' => true,
            'code' => '200',
        ];
    }


}