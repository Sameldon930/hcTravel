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
class SaveBusiness extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     *
     * @var string
     */
    protected $method = 'SaveBusiness';

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
            'img' => 'required',
            'business_num' => 'required|max:30',
            'business_name' => 'required|max:15',
            'business_person' => 'required|max:15',
            'business_address' => 'required|max:50',
            'merchant_id' => 'required',
        ];
        $messages = [
            'img.required' => '请上传营业执照',
            'business_num.required' => '请输入组织机构代码',
            'business_num.max' => '注册地址长度不符合',
            'business_name.required' => '请输入营业执照名称',
            'business_name.max' => '营业执照名称太长',
            'business_person.required' => '请输入营业执照法人',
            'business_address.required' => '请输入注册地址',
            'business_address.max' => '注册地址长度不符合',
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

        $merchant = Merchant::findOrFail($params['merchant_id']);
        $merchant_id = $merchant->id;
        $common = new Common();
        if(strpos($params['img'],'storage') == false ){
            $path = $common->save_img($merchant_id,$params['img'],'business');
        }else{
            $merchant_info = MerchantInfo::where('merchant_id',$params['merchant_id'])->first();
            $path = $merchant_info->identity_front;
        }


        //判断用户是否拥有数据
        $merchant_info = MerchantInfo::where('merchant_id',$params['merchant_id'])->first();
        $create_data = [
            'merchant_id' =>$params['merchant_id'],
            'business_img'=>$path,
            'business_num'=>$params['business_num'],
            'business_name'=>$params['business_name'],
            'business_person'=>$params['business_person'],
            'business_address'=>$params['business_address'],
        ];
        if(empty($merchant_info)){
            MerchantInfo::create($create_data);
        }else{
            $merchant_info->business_img = $path;
            $merchant_info->business_num = $params['business_num'];
            $merchant_info->business_name = $params['business_name'];
            $merchant_info->business_person = $params['business_person'];
            $merchant_info->business_address = $params['business_address'];
            $merchant_info->save();
        }

        $homestay = HomestayInfo::where('merchant_id',$params['merchant_id'])->first();
        if(empty($homestay)){
            HomestayInfo::create($create_data);
        }else{
            $homestay->business_img = $path;
            $homestay->business_num = $params['business_num'];
            $homestay->business_name = $params['business_name'];
            $homestay->business_person = $params['business_person'];
            $homestay->business_address = $params['business_address'];
            $homestay->save();
        }

        return [
            'status' => true,
            'code' => '200',
        ];
    }



}