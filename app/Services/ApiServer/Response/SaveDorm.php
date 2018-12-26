<?php
namespace App\Services\ApiServer\Response;

use App\Article;
use App\HomestayInfo;
use App\Merchant;
use App\MerchantInfo;
use App\SmDormInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Validator;

/**
 * 保存民宿调查表单
 */
class SaveDorm extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     *
     * @var string
     */
    protected $method = 'SaveProperty';

    /**
     * 接口参数检验
     */

    public function checkParams(&$params)
    {
        $rules = [
            'img' => 'required',
            'merchant_id' => 'required',
            'business_name' => 'required',
            'business_name' => 'required|max:100',
            'merchant_name' => 'required|max:100',
            'code' => 'required|max:100',
            'juridical_person' => 'required|max:100',
            'service_mobile' => 'required|max:50',
            'leader_name' => 'required|max:100',
            'sex' => 'required',
            'leader_mobile' => 'required|numeric|digits_between:8,16',
            'leader_email' => 'required|email',
            'leader_qq' => 'required|numeric|digits_between:5,16',
            'leader_wx' => 'required|max:50',
            'papers' => 'required',
            'type' => 'required',
            'brand' => 'required',
            'feature' => 'required',
            'config' => 'required',
            'room_num' => 'required|numeric',
            'adorn_time' => 'required',
            'trait' => 'required',
            'earning' => 'required|numeric',
            'lease' => 'required',
            'ratio' => 'required',
            'price' => 'required',
            'rent' => 'required',
            'staff_num' => 'required|numeric',
            'awards' => 'required',
            'penalty' => 'required',
        ];

        $messages = [
            'img.required' => '请上传民宿美图',
            'business_name.required' => '请输入商家名称',
            'business_name.max' => '商家名称太长',
            'merchant_name.required' => '请输入店铺招牌',
            'merchant_name.max' => '店铺招牌太长',
            'code.required' => '请输入统一社会信用代码',
            'code.max' => '统一社会信用代码太长',
            'juridical_person.required' => '请输入法人姓名',
            'juridical_person.max' => '法人姓名太长',
            'service_mobile.required' => '请输入客服电话',
            'service_mobile.max' => '客服电话太长',
            'leader_name.required' => '请输入负责人姓名',
            'leader_name.max' => '负责人姓名太长',
            'sex.required' => '请选择负责人性别',
            'leader_mobile.required' => '请输入负责人手机',
            'leader_mobile.numeric' => '负责人手机必须为数字',
            'leader_mobile.digits_between' => '负责人手机长度不符合规则',
            'leader_email.required' => '请输入负责人邮箱',
            'leader_email.email' => '负责人邮箱格式不对',
            'leader_qq.required' => '请输入负责人QQ',
            'leader_qq.digits_between' => '负责人QQ长度不对',
            'leader_qq.numeric' => '负责人QQ必须为数字',
            'leader_wx.required' => '请输入负责人微信',
            'papers.required' => '请选择经营资质',
            'type.required' => '请选择经营品类',
            'brand.required' => '请选择经营品牌',
            'feature.required' => '请选择主题特色',
            'config.required' => '请选择配套设施',
            'room_num.required' => '请输入客房数量',
            'room_num.numeric' => '客房数量必须为数字',
            'adorn_time.required' => '请输入最后装修时间',
            'trait.required' => '请输入投资规模及民宿特色',
            'earning.required' => '请输入营业收入',
            'earning.numeric' => '营业收入必须为数字',
            'lease.required' => '请输入租期',
            'ratio.required' => '请输入入住率',
            'price.required' => '请输入均价',
            'rent.required' => '请输入年租金',
            'staff_num.required' => '请输入员工数量',
            'staff_num.numeric' => '员工数量必须为数字',
            'awards.required' => '请输入获奖情况（无获奖请填无）',
            'penalty.required' => '请输入受到处罚情况（无惩罚请填无）',
        ];
        $params['papers']= json_decode($params['papers']);
        $params['type']= json_decode($params['type']);
        $params['brand']= json_decode($params['brand']);
        $params['feature']= json_decode($params['feature']);
        $params['config']= json_decode($params['config']);
        $params['img'] = json_decode($params['img']);
        $params['province'] = json_decode($params['province']);
        $params['city'] = json_decode($params['city']);
        $params['area'] = json_decode($params['area']);
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
        //判断是否存在该用户
        $merchant = Merchant::find($params['merchant_id']);
        $merchant_id = $merchant->id;
        $common = new Common();
        $img_array = [];

        foreach ($imgs as $key=>$img){
            //判断是否为旧数据
            if(stripos($img,'storage') !=false){
                $img_array[$key]=explode('storage',$img)[1];
            }else{
                $path =$common->save_img($merchant_id,$img,$key.'dorm-');
                $img_array[$key] = $path;
            }
        }


        //将图片转JSON
        $params['img'] = json_encode($img_array);

        unset($params['method']);
        unset($params['nonce']);
        unset($params['sign']);
        $params['papers']= json_encode($params['papers']);
        $params['type']= json_encode($params['type']);
        $params['brand']= json_encode($params['brand']);
        $params['feature']= json_encode($params['feature']);
        $params['config']= json_encode($params['config']);
        $params['province'] = json_encode($params['province']);
        $params['city'] = json_encode($params['city']);
        $params['area'] = json_encode($params['area']);

        //判断是否已存在，更新还是创建
        $dorm = SmDormInfo::where('merchant_id',$params['merchant_id'])->first();
        if(empty($dorm)){
            SmDormInfo::create($params);
        }else{
            SmDormInfo::where('merchant_id',$params['merchant_id'])->update($params);

        }

        return [
            'status' => true,
            'code' => '200',
        ];
    }


}