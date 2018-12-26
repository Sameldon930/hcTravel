<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/3
 * Time: 18:55
 */

namespace App\Services\ApiServer\Response;
use App\Article;
use App\Decoration;
use App\Finance;
use App\Merchant;
use App\MerchantInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Validator;

class MerchantGetList extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     * 商户列表页
     * @var string
     */
    protected $method = 'MerchantGetList';

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
//    商户列表页列表接口getlist
    public function run(&$params)
    {
        $type = $params['type'];
        if ($type==""){
            $params['page_num'];
            $page_num = $params['page_num'];
            $count=MerchantInfo::select()->count();
            $data = MerchantInfo::select()
                ->orderBy('created_at', 'desc')
                ->offset($page_num)
                ->limit(12)
                ->get();
            return [
                'status' => true,
                'code' => '200',
                'data' => $data,
                'count'=>$count,
            ];
        }else{
//            $data = DB::select('select m.id,m.merchant_name,m.business_img ,m.merchant_address,m.thumbnail from merchant_infos AS m limit 0,2');
            $count = MerchantInfo::select()->count();
            if ($count <=6 ){
                $data = MerchantInfo::select()
                    ->orderBy('created_at', 'desc')
                    ->take(6)
                    ->get();
            }else{
                $ran_num = floor(rand(0,$count-6));
                $data = MerchantInfo::select()
                    ->orderBy('created_at', 'desc')
                    ->offset($ran_num)
                    ->limit(6)
                    ->get();
            }

        }
        return [
            'status' => true,
            'code' => '200',
            'data' => $data,
        ];
    }



}