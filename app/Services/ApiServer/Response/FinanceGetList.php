<?php
namespace App\Services\ApiServer\Response;

use App\Article;
use App\Decoration;
use App\Finance;
use Carbon\Carbon;
use Validator;

/**
 * 金融服务列表
 */
class FinanceGetList extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'FinanceGetList';

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


        $data = Finance::Show()
            ->orderBy('orderby', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        return [
            'status' => true,
            'code' => '200',
            'data' => $data,
        ];
    }


}