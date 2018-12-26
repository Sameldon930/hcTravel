<?php
namespace App\Services\ApiServer\Response;

use App\Article;
use App\Notify;
use Carbon\Carbon;
use Validator;

/**
 * 文章详情
 */
class NotifyGetOne extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     *
     * @var string
     */
    protected $method = 'NotifyGetOne';

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


        //cat_id_咨询类型
        $data = Notify::Show()->find($params['id']);
        $data->create_at = date('Y-m-d',strtotime($data->created_at));
        return [
            'status' => true,
            'code' => '200',
            'data' => $data,
        ];
    }

}
