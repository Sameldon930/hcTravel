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
class SetMerchant extends BaseResponse implements InterfaceResponse
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
            $created_data=[
                'id'=>$params['id'],
                'name'=>$params['name'],
                'merchant_name'=>$params['merchant_name'],
                'merchant_address'=>$params['merchant_address'],
                'mobile'=>'123131231231',
                'number'=>'414141',
                'api_token'=>'1111233',
            ];
            $result= Merchant::create($created_data);
        }else{
            $merchant->name=$params['name'];
            $merchant->merchant_name=$params['merchant_name'];
            $merchant->merchant_address=$params['merchant_address'];

            $result=$merchant->save();
        }

        if($result){
            return [
                'status' => true,
                'code' => '200',
                'data' => 'ok',
            ];
        }

    }



}