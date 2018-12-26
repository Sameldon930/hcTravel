<?php
namespace App\Services\ApiServer\Response;

use App\Feedback;
use App\Notify;
use Validator;

/**
 * 文章列表
 */
class NotifyGetList extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'NotifyGetList';

    /**
     * 接口参数检验
     */

    public function checkParams(&$params)
    {
        $rules = [
            'merchant_id' => 'required'
        ];
        $messages = [
            'merchant_id.required' => '用户ID缺失',
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
        $data = Notify::Show()
            ->orderBy('created_at', 'desc')
            ->get();
        foreach ($data as &$value){
            $value->create_at = date('Y-m-d', strtotime($value->created_at));
        }

        unset($value);
        return [
            'status' => true,
            'code' => '200',
            'data' => $data,
        ];
    }
}
