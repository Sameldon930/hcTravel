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
 * 文章详情
 */
class GetMerchant extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     *
     * @var string
     */
    protected $method = 'GetMerchantInfo';

    /**
     * 接口参数检验
     */

    public function checkParams(&$params)
    {
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

        $merchant =Merchant::find($params['merchant_id']);
        if(empty($merchant)){
            return [
                'status' => false,
                'code' => '201',
            ];
        }else{
            $data['name']=$merchant->name;
            $data['merchant_name']=$merchant->merchant_name;
            $data['merchant_address']=$merchant->merchant_address;

            return [
                'status' => true,
                'code' => '200',
                'data' => $data,
            ];
        }

    }



}