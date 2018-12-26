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
 * 保存商户店铺
 */
class SaveMerchantShop extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     *
     * @var string
     */
    protected $method = 'SaveMerchantShop';

    /**
     * 接口参数检验
     */

    public function checkParams(&$params)
    {
        $rules = [
            'merchant_id' => 'required',
            'merchant_principal' => 'required|max:12',
            'merchant_name' => 'required|max:25',
            'merchant_short_name' => 'required|max:15',
            'merchant_address' => 'required|max:40',
        ];
        $messages = [
            'merchant_id.required' => '缺少商户id',
            'merchant_principal.required' => '请输入负责人',
            'merchant_principal.max' => '输入的负责人太长了',
            'merchant_name.required' => '请输入商铺名称',
            'merchant_name.max' => '商铺全称太长了',
            'merchant_short_name.required' => '请输入商铺简称',
            'merchant_short_name.max' => '商铺简称太长了',
            'merchant_address.required' => '请输入商铺地址',
            'merchant_address.max' => '商铺地址太长了',

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


        $merchant_info = MerchantInfo::where('merchant_id',$params['merchant_id'])->first();

        $create_data = [
            'merchant_id' => $params['merchant_id'],
            'merchant_name' => $params['merchant_name'],
            'merchant_short_name' => $params['merchant_short_name'],
            'merchant_address' => $params['merchant_address'],
            'merchant_principal' => $params['merchant_principal'],
        ];
        if(empty($merchant_info)){
            MerchantInfo::create($create_data);
        }else{
            $merchant_info->merchant_name = $params['merchant_name'];
            $merchant_info->merchant_short_name = $params['merchant_short_name'];
            $merchant_info->merchant_address = $params['merchant_address'];
            $merchant_info->merchant_principal = $params['merchant_principal'];
            $merchant_info->save();
        }

        $homestay = HomestayInfo::where('merchant_id',$params['merchant_id'])->first();
        if(empty($homestay)){
            HomestayInfo::create($create_data);
        }else{
            $homestay->merchant_name = $params['merchant_name'];
            $homestay->merchant_short_name = $params['merchant_short_name'];
            $homestay->merchant_address = $params['merchant_address'];
            $homestay->merchant_principal = $params['merchant_principal'];
            $homestay->save();
        }

        return [
            'status' => true,
            'code' => '200',
            'msg' => '保存成功',
        ];
    }


}