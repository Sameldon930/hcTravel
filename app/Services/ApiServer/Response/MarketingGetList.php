<?php
namespace App\Services\ApiServer\Response;

use App\Article;
use App\Decoration;
use App\Finance;
use App\Good;
use App\Marketing;
use Carbon\Carbon;
use Validator;

/**
 * 营销推广列表
 */
class MarketingGetList extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'MarketingGetList';

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


        $data = Marketing::Show()
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