<?php
namespace App\Services\ApiServer\Response;

use App\Article;
use App\VerifyLog;
use Carbon\Carbon;
use Validator;

/**
 * 申请记录
 */
class VerifyGetList extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'VerifyGetList';

    /**
     * 接口参数检验
     */

    public function checkParams(&$params)
    {
        $rules = [
            'merchant_id' => 'required'
        ];
        $messages = [
            'merchant_id.required' => '商户id',
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

        $data = VerifyLog::where('merchant_id',$params['merchant_id'])
            ->orderby('created_at','desc')
            ->get();

        foreach ($data as &$value){
           $value->type = VerifyLog::VERIFY_TYPE[$value->type];
           $value->status = VerifyLog::CHECK_AUDIT[$value->status];
        }
        unset($value);
        return [
            'status' => true,
            'code' => '200',
            'data' => $data,
        ];
    }


}