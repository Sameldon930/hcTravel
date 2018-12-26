<?php
namespace App\Services\ApiServer\Response;

use App\Side;
use Validator;

/**
 * 文章列表
 */
class SwipeGetList extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'SwipeGetList';

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


        $data = Side::Show()->orderBy('orderby')->get();
        foreach ($data as &$value){
            $value->image = 'storage/serve/'.$value->image;
        }

        return [
            'status' => true,
            'code' => '200',
            'data' => $data,
        ];
    }


}

