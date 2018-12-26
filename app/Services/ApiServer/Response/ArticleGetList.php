<?php
namespace App\Services\ApiServer\Response;

use App\Article;
use Carbon\Carbon;
use Validator;

/**
 * 文章列表
 */
class ArticleGetList extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'ArticleGetList';

    /**
     * 接口参数检验
     */

    public function checkParams(&$params)
    {
        $rules = [
            'group_id' => 'required'
        ];
        $messages = [
            'group_id.required' => '文章类型ID缺失',
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


        $data = Article::where('group_id',$params['group_id'])
            ->Show()
            ->orderBy('now', 'desc')
            ->get();
        foreach ($data as &$value){
            $value->now = date('Y-m-d', strtotime($value->now));
        }

        unset($value);
        return [
            'status' => true,
            'code' => '200',
            'data' => $data,
        ];
    }


}
