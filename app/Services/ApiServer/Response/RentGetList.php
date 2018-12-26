<?php
namespace App\Services\ApiServer\Response;

use App\ApartmentRent;
use Carbon\Carbon;
use Validator;

/**
 * 二手商品列表
 */
class RentGetList extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'RentGetList';

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


        $data = ApartmentRent::Show()
            ->orderBy('orderby', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        foreach ($data as &$value){
            $value->created_time = date('Y-m-d', strtotime($value->created_at));
            $value->rent_way = ApartmentRent::RENT_WAYS[$value->rent_way];
        }
        return [
            'status' => true,
            'code' => '200',
            'data' => $data,
        ];
    }


}