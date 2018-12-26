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
class SaveAlibi extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     *
     * @var string
     */
    protected $method = 'SaveAlibi';

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
            'merchant_id' => 'required',
        ];
        $messages = [
            'img.required' => '无犯罪证明',
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
        if(strpos($params['img'],'storage') !=false){
            return [
                'status' => true,
                'code' => '200',
            ];
        }

        $merchant = Merchant::find($params['merchant_id']);

        $merchant_id = $merchant->id;

        $common = new Common();
        $path =$common->save_img($merchant_id,$params['img'],'alibi-');

        $homestay = HomestayInfo::where('merchant_id',$params['merchant_id'])->first();
        if(empty($homestay)){
            HomestayInfo::create(['merchant_id'=>$params['merchant_id'],'alibi_img'=>$path]);
        }else{
            $homestay->alibi_img = $path;
            $homestay->save();
        }
        return [
            'status' => true,
            'code' => '200',
        ];
    }


}