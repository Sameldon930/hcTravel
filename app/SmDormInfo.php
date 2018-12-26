<?php

namespace App;

use App\Http\Traits\CommonExportTrait;
use App\Http\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class SmDormInfo extends Model
{
    use CommonExportTrait,Searchable;
    protected $fillable = [
        'merchant_id', 'province','city','area','business_name','merchant_name',
        'code', 'juridical_person','service_mobile','leader_name','sex','leader_mobile',
        'leader_email', 'leader_qq','leader_wx','papers','type','brand',
        'feature', 'config','city','room_num','adorn_time','trait',
        'earning', 'lease','ratio','price','rent','staff_num',
        'awards', 'penalty','opinion','hard','img','status','site',
    ];
    protected $table = 'sm_dorm_info';
    //经营资质
    const PAPERS = [
        '1'=>'商事登记', '2'=>'组织机构代码证','3'=>'银行开户许可证',
        '4'=>'法人身份证', '5'=>'民宿登记证','6'=> '特种行业许可证',
        '7'=>'食品经营许可证', '8'=>'卫生许可证',
    ];
    //经营品类
    const TYPE_NAME = [
       '1' =>'传统民宿','2'=>'客栈','3'=>'家庭旅馆',
       '4'=>'青年旅舍','5'=>'转型的农家乐','6'=>'其他',
    ];
    const TYPE = [
        '1'=>'传统民宿','2'=>'客栈','3'=>'家庭旅馆',
        '4'=>'青年旅舍','5'=>'转型的农家乐','6'=>'其他',
    ];
    //经营品牌
    const BRAND_NAME = [
        '1'=>'自由独立品牌','2'=>'授权品牌','3'=>'连锁品牌',
        '4'=>'没有品牌',
    ];
    const BRAND = [
        '1'=>'自由独立品牌','2'=>'授权品牌','3'=>'连锁品牌',
        '4'=>'没有品牌'
    ];
    //主题特色
    const FEATURE = [
        '1'=>'滨海风情','2'=>'传统民居','3'=>'异域城堡',
        '4'=>'农村木屋','5'=>'物产美宿','6'=>'都市野奢',
        '7'=>'烂漫雅居','8'=>'亲子乐居','9'=>'静心养舍',
        '10'=>'森林树屋','11'=>'绿野仙居','12'=>'其它',
    ];
    //配套设施
    const CONFIG = [
        '1'=>'公共洗手间','2'=>'餐厅','3'=>'咖啡厅',
        '4'=>'消毒间','5'=>'储藏间','6'=>'消防设施',
    ];

    const SEX = [
        '1'=>'男',
        '2'=>'女',
    ] ;

    //所属区域
    const SITE =[
        '1'=>'黄厝社',
        '2'=>'茂后社',
        '3'=>'塔头社',
        '4'=>'溪头下社',
    ];

    public function merchant(){
        return $this->belongsTo(Merchant::class);
    }

}
