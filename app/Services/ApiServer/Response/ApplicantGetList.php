<?php
namespace App\Services\ApiServer\Response;

use App\Applicant;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Validator;

/**
 * 文章列表
 */
class ApplicantGetList extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'ApplicantGetList';

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


        $data = Applicant::Show()
            ->orderBy('created
            ->orderBy(\'orderby\', \'desc\')_at', 'desc')
            ->get();
        foreach ($data as &$value){
            $value->created_time = date('Y-m-d', strtotime($value->created_at));
            $value->sex = Applicant::SEX[$value->sex];
            $value->education = Applicant::EDUCATIONS[$value->education];
        }

        unset($value);
        return [
            'status' => true,
            'code' => '200',
            'data' => $data,
        ];
    }


}

