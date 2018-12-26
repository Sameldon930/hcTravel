<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/3
 * Time: 19:01
 */

namespace App\Services\ApiServer\Response;
use App\Article;

use App\Decoration;
use App\Finance;
use App\Merchant;
use App\MerchantInfo;
use Validator;
use Illuminate\Support\Facades\DB;

class MerchantGetDetails extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称MerchantGetDetails
     * 商户列表详情页显示商户的详细信息
     *
     * @var string
     */
    protected $method = 'MerchantGetDetails';

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
//     商户详情页接口
    public function run(&$params)
    {

          $id = $params['id'];
//        $data = DB::select("select m.name,m.avatar,m.mobile,m.mobile, a.merchant_address,a.merchant_name,m.created_at,a.content,a.interior_figure_one,a.interior_figure_two,a.interior_figure_three from merchants AS m INNER JOIN merchant_infos AS a ON a.merchant_id = m.id  WHERE a.id = $id");
        $data = Merchant::join('merchant_infos','merchant_infos.merchant_id','=','merchants.id')->where('merchant_infos.id','=',$id)->first();
//        dd($data);
//        $data = Merchant::with('merchantInfo')->where('merchant_infos.id',$id)->first();
//          $data = MerchantInfo::select()
//              ->where('merchant_infos.id','=',$id)
//              ->first();
//        dd($data);
        $data->now = date('Y-m-d', strtotime($data->register));
        return [
            'status' => true,
            'code' => '200',
            'data' => $data,
        ];
    }

}