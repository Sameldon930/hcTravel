<?php
namespace App\Services\ApiServer\Response;

use App\Article;

use App\Decoration;
use App\Finance;
use Validator;

/**
 * 金融服务详情
 */
class FinanceGetOne extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     *
     * @var string
     */
    protected $method = 'FinanceGetOne';

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

        $data = Finance::Show()->find($params['id']);
//        $data->content = json_decode($data->content, true);
        $data->created_time = date('Y-m-d', strtotime($data->created_at));

        return [
            'status' => true,
            'code' => '200',
            'data' => $data,
        ];
    }


}