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
 * 文章详情
 */
class GetDorm extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     *
     * @var string
     */
    protected $method = 'GetDorm';

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


        //获取用户数据
        $data = SmDormInfo::find($params['merchant_id']);

        if(empty($data)){
            //获取配置数据
            $data['config_papers'] = SmDormInfo::PAPERS;
            $data['config_type'] = SmDormInfo::TYPE;
            $data['config_brand'] = SmDormInfo::BRAND;
            $data['config_feature'] = SmDormInfo::FEATURE;
            $data['config_config'] = SmDormInfo::CONFIG;
            return [
                'status' => true,
                'code' => '202',
                'data'=>$data,
                'msg' => '用户未填写相关信息',
            ];
        }
        $data['config_papers'] = SmDormInfo::PAPERS;
        $data['config_type'] = SmDormInfo::TYPE;
        $data['config_brand'] = SmDormInfo::BRAND;
        $data['config_feature'] = SmDormInfo::FEATURE;
        $data['config_config'] = SmDormInfo::CONFIG;
        $data->area = json_decode($data->area);
        $data->brand = json_decode($data->brand);
        $data->city = json_decode($data->city);
        $data->config = json_decode($data->config);
        $data->feature = json_decode($data->feature);
        $data->img = json_decode($data->img);
        $data->papers = json_decode($data->papers);
        $data->province = json_decode($data->province);
        $data->type = json_decode($data->type);
        $data->adorn_time = date('Y-m-d',strtotime($data->adorn_time));


        return [
            'status' => true,
            'code' => '200',
            'data' => $data,
            ];



    }



}
