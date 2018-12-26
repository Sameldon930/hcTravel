<?php
namespace App\Services\ApiServer\Response;

use App\Article;
use App\HomestayInfo;
use App\HouseAudit;
use App\Merchant;
use App\MerchantInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Validator;

/**
 * 民宿认证码
 */
class SaveHouseAuditCode extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     *
     * @var string
     */
    protected $method = 'SaveHouseAuditCode';

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
            'img' => 'required',
            'code' => 'required|max:50',
            'merchant_id' => 'required',
        ];
        $messages = [
            'img.required' => '无犯罪证明缺失',
            'code.required' => '请输入房屋审批报告编号',
            'code.max' => '房屋审批报告编号太长',
            'merchant_id.required' => '商户id缺少',
        ];
        $params['img'] = json_decode($params['img']);
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
        $imgs = $params['img'];
        $merchant = Merchant::find($params['merchant_id']);
        Merchant::getStatus($merchant,Merchant::STATUS_ARRAY[2]);
        $merchant_id = $merchant->id;
        $common = new Common();
        $img_array = [];

        foreach ($imgs as $key=>$img){
            //判断是否为旧数据
            if(stripos($img,'storage') !=false){
                $img_array[$key]=explode('storage',$img)[1];
            }else{
                $path =$common->save_img($merchant_id,$img,$key.'house_audit-');
                $img_array[$key] = $path;
            }
        }
        //将图片转JSON
        $img = json_encode($img_array);

        $house_audit = HouseAudit::where('merchant_id',$params['merchant_id'])->first();
        if(empty($house_audit)){
            HouseAudit::create(['merchant_id'=>$merchant_id,'img'=>$img,'code'=>$params['code'],'status'=>HouseAudit::IN_AUDIT]);
            $merchantModel = new Merchant();
            $merchantModel->auditIn($merchant,Merchant::STATUS_ARRAY[2]);
        }else{
            $house_audit->img = $img;
            $house_audit->code = $params['code'];
            $house_audit->save();
        }


        return [
            'status' => true,
            'code' => '200',
        ];
    }


}