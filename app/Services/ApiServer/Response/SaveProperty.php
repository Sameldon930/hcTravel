<?php
namespace App\Services\ApiServer\Response;

use App\Article;
use App\HomestayInfo;
use App\Merchant;
use App\MerchantInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Validator;

/**
 * 保存产权证书
 */
class SaveProperty extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     *
     * @var string
     */
    protected $method = 'SaveProperty';

    /**
     * 接口参数检验
     */

    public function checkParams(&$params)
    {
        $login = new LoginCheck();
        if(!$login->login_verify($params)){
            return [
                'status' => false,
                'code' => '005',
                'msg' => '请先登录'
            ];
        }
        $rules = [
            'img' => 'required',
            'merchant_id' => 'required',
            'class'=>'required',
        ];
        $messages = [
            'img.required' => '请上传产权照',
            'class.required' => '不可缺少产权类别，请联系管理员',
            'merchant_id.required' => '缺少商户id',
        ];
        $params['img'] = json_decode($params['img']);
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
        $imgs = $params['img'];
        $merchant = Merchant::find($params['merchant_id']);
        $merchant_id = $merchant->id;
        $common = new Common();
        $img_array = [];

        foreach ($imgs as $key=>$img){
            //判断是否为旧数据
            if(stripos($img,'storage') !=false){
                $img_array[$key]=explode('storage',$img)[1];
            }else{
                $path =$common->save_img($merchant_id,$img,$key.'property');
                $img_array[$key] = $path;
            }
        }
        //将图片转JSON
        $path_img = json_encode($img_array);
        $class=$params['class'];
        $merchant_id = $params['merchant_id'];
        switch ($class){
            case 1:

                $this->storeProperty($merchant_id,$path_img,'property_img_1');
                break;
            case 2:
                $this->storeProperty($merchant_id,$path_img,'property_img_2');
                break;
            case 3:
                $this->storeProperty($merchant_id,$path_img,'property_img_3');
                break;
            case 4:
                $this->storeProperty($merchant_id,$path_img,'property_img_4');
                break;
            case 5:
                $this->storeProperty($merchant_id,$path_img,'property_img_5');
                break;
            case 6:
                $this->storeProperty($merchant_id,$path_img,'property_img_6');
                break;
            case 7:
                $this->storeProperty($merchant_id,$path_img,'property_img_7');
                break;
            default:
                $this->storeProperty($merchant_id,$path_img,'property_img');
                break;
        }


        return [
            'status' => true,
            'code' => '200',
        ];
    }

    protected function storeProperty($merchant_id,$path_img,$class){
        $homestay = HomestayInfo::where('merchant_id',$merchant_id)->first();
        if(empty($homestay)){
            HomestayInfo::create(['merchant_id'=>$merchant_id,$class=>$path_img]);
        }else{
            HomestayInfo::where('merchant_id',$merchant_id)
                ->update([$class => $path_img]);
        }
    }

}