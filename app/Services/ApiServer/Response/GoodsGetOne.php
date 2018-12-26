<?php
namespace App\Services\ApiServer\Response;

use App\Article;

use App\Decoration;
use App\Finance;
use App\Good;
use Illuminate\Support\Facades\App;
use Validator;

/**
 * 二手商品详情
 */
class GoodsGetOne extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     *
     * @var string
     */
    protected $method = 'GoodsGetOne';

    /**
     * 接口参数检验
     */

    public function checkParams(&$params)
    {
        $rules = [
            'id' => 'required'
        ];
        $messages = [
            'id.required' => 'ID缺失',
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

        $data = Good::Show()->find($params['id']);
        $data->created_time = date('Y-m-d', strtotime($data->created_at));
        $data->measure = Good::GOOD_MEASURE[$data->measure];

        return [
            'status' => true,
            'code' => '200',
            'data' => $data,
        ];
    }


}