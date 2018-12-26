<?php
namespace App\Services\ApiServer\Response;

use App\Applicant;
use Carbon\Carbon;
use Validator;

/**
 * 文章列表
 */
class ApplicantGetOne extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'ApplicantGetOne';

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


        $data = Applicant::Show()->find($params['id']);
        $data->created_time = date('Y-m-d', strtotime($data->created_at));
        $data->sex = Applicant::SEX[$data->sex];
        $data->education = Applicant::EDUCATIONS[$data->education];

        return [
            'status' => true,
            'code' => '200',
            'data' => $data,
        ];
    }


}

