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
class GetFormConfig extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     *
     * @var string
     */
    protected $method = 'GetFormConfig';

    /**
     * 接口参数检验
     */

    public function checkParams(&$params)
    {
            return $this->run($params);

    }

    /**
     * 执行接口
     * @param  array &$params 请求参数
     * @return array
     */
    public function run(&$params)
    {



            //获取配置数据
            $data['config_papers'] = SmDormInfo::PAPERS;
            $data['config_type'] = SmDormInfo::TYPE;
            $data['config_brand'] = SmDormInfo::BRAND;
            $data['config_feature'] = SmDormInfo::FEATURE;
            $data['config_config'] = SmDormInfo::CONFIG;
            return [
                'status' => true,
                'code' => '200',
                'data'=>$data,
            ];


    }



}
