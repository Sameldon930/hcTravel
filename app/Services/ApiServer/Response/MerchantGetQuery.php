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
use Illuminate\Support\Facades\Input;

class MerchantGetQuery extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     * 搜索接口
     * 用于查询商户的信息
     * @var string
     */
    protected $method = 'GetInput';

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
//    商户列表页搜索接口
    public function run(&$params)
    {
//        去除所有文章内容空格

        $name =$params['user_name'];
        $Front=array(" ","　","\t","\n","\r");
        $after=array("","","","","");
        $name =  str_replace($Front,$after,$name);
        if ($name==""){
           return [
               'status' => true,
               'code' => '250',
               'msg' => '请输入搜索内容',
           ];
       }
        $data = MerchantInfo::where("merchant_name","like","%".$name."%")->orderBy('created_at', 'desc')->get();
        if ($data){
             return [
                 'status' => true,
                 'code' => '200',
                 'data' => $data,
             ];
         }else{
             return [
                 'status' => true,
                 'code' => '201',
                 'msg' => "没有搜索结果",
             ];
         }


    }

}