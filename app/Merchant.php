<?php

namespace App;

use App\Http\Traits\CommonExportTrait;
use App\Http\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Merchant extends Model
{
    use Searchable,CommonExportTrait;
//    ******软删除需求******
    use SoftDeletes;
    protected $dates = ['delete_at'];
//    *******软删除需求******

    protected $fillable = [
        'name','merchant_name','merchant_id','merchant_address','mobile','status','password','api_token','number','avatar','thumbnail'
    ];

    protected $hidden = ['password'];

    //status字段的审核分类的key
    const STATUS_ARRAY = [
        'merchant', //商户
        'dorm',  //民宿核验
        'house', //房屋鉴定
    ];

    const NOT_AUDIT = 1;
    const IN_AUDIT = 2;
    const SUCCESS_AUDIT = 3;
    const FAIL_AUDIT = 4;

    //商户认证状态
    const MERCHANT_STATUS = [
      self::NOT_AUDIT => '商户未认证',
      self::IN_AUDIT => '商户认证中',
      self::SUCCESS_AUDIT => '商户认证成功',
      self::FAIL_AUDIT => '商户认证失败',
    ];
    //民宿核验状态
    const DORM_STATUS = [
        self::NOT_AUDIT => '民宿核验未认证',
        self::IN_AUDIT => '民宿核验材料初审中，请耐心等待，审核需2-3个工作日',
        self::SUCCESS_AUDIT => '民宿核验材料初审通过，请进行下一步操作',
        self::FAIL_AUDIT => '民宿核验失败',
    ];

    //商户认证状态
    const HOUSE_STATUS = [
        self::NOT_AUDIT => '房屋未鉴定',
        self::IN_AUDIT => '房屋鉴定中',
        self::SUCCESS_AUDIT => '房屋鉴定成功',
        self::FAIL_AUDIT => '房屋鉴定失败',
    ];

    const SHOW_HOME_FLOW = 1;
    const HIDE_HOME_FLOW = 2;



    /**
     * @param $merchant 模型
     * @param $audit 审核类型
     * @return bool|int
     */
   public static function getStatus($merchant,$audit){
       //判断用户传的值是否在审核组中
       if($merchant->getArrayKey($audit) == true){
           $status = json_decode($merchant->status,true);
           $status_key = array_keys($status);

           //判断用户数据中是否已存在当前审核的值，存在就显示，不存在就添加默认为未上传
           if(in_array($audit,$status_key) == false) {
               $new_audit = [$audit =>self::NOT_AUDIT];
               $new_status = array_merge($status,$new_audit);
               $merchant->status = json_encode($new_status);
               $merchant->save();
               return self::NOT_AUDIT;
           };

             return json_decode($merchant->status,true)[$audit];
       }else{

           return false;
       }
   }

    /**
     * 判断是否有这个审核
     * @param $audit
     * @return bool
     */
   protected function getArrayKey($audit){
       if(in_array($audit,self::STATUS_ARRAY) !=null){
           return true;
       }
       return false;
   }

    /**
     * 将认证状态改为认证成功
     * @param $merchant
     * @param $type 认证类型
     */
   public function auditSuccess($merchant,$type){
       if($merchant->getArrayKey($type)){
           $this->changeAudit($merchant,$type,self::SUCCESS_AUDIT);
       }
   }

    /***
     * 将认证状态改为认证失败
     * @param $merchant
     * @param $type 认证类型
     */
    public function auditFail($merchant,$type){
        if($merchant->getArrayKey($type)){
            $this->changeAudit($merchant,$type,self::FAIL_AUDIT);
        }
    }

    /***
     * 将认证状态改为审核中
     * @param $merchant
     * @param $type 认证类型
     */
    public function auditIn($merchant,$type){
        if($merchant->getArrayKey($type)){
            $this->changeAudit($merchant,$type,self::IN_AUDIT);
        }
    }

    /**
     * 改变审核状态
     * @param $merchant
     * @param $type
     * @param $status
     */
    protected function changeAudit($merchant,$type,$status){
        $status_data = json_decode($merchant->status,true);
        $status_data[$type] =$status;
        $merchant->status = json_encode($status_data);
        $merchant->save();
    }



    public function merchantInfo(){
        return $this->hasOne(MerchantInfo::class);
    }

    public function homestayInfo(){
        return $this->hasOne(HomestayInfo::class);
    }

    public function houseAudit(){
        return $this->hasOne(HouseAudit::class);
    }

    public function verifyLogs(){
        return $this->hasMany(VerifyLog::class);
    }
    public function feedback(){
        return $this->hasMany(Feedback::class);
    }

}
