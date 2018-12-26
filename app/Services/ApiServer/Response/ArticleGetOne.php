<?php
namespace App\Services\ApiServer\Response;

use App\Article;
use Carbon\Carbon;
use Validator;

/**
 * 文章详情
 */
class ArticleGetOne extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     *
     * @var string
     */
    protected $method = 'ArticleGetOne';

    /**
     * 接口参数检验
     */

    public function checkParams(&$params)
    {
        $rules = [
            'id' => 'required'
        ];
        $messages = [
            'id.required' => '文章ID缺失',
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
        $data = Article::Show()->find($params['id']);
        $data->now = date('Y-m-d', strtotime($data->now));
        return [
            'status' => true,
            'code' => '200',
            'data' => $data,
        ];
    }


}