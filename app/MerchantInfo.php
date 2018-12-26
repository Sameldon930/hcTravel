<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class MerchantInfo extends Model
{
    //    ******软删除需求******
    use SoftDeletes;
    protected $dates = ['delete_at'];
//    *******软删除需求******



    protected $fillable = [
        'merchant_id', 'business_img','business_num','business_name',
        'business_person','business_address','identity_front','identity_contrary',
        'identity_num','identity_name','contract_tenancy','status',
        'merchant_address','merchant_short_name','merchant_name','merchant_principal',
        'thumbnail','interior_figure_one','interior_figure_two','interior_figure_three','content','time','score','register'
    ];
    const NOT_AUDIT = 1;
    const IN_AUDIT = 2;
    const SUCCESS_AUDIT  = 3;
    const FAIL_AUDIT  = 4;

    const CHECK_AUDIT =[
       self::NOT_AUDIT => "未上传",
       self::IN_AUDIT => "审核中",
       self::SUCCESS_AUDIT => "通过认证",
       self::FAIL_AUDIT => "认证失败",
    ];

    public function merchant(){
        return $this->belongsTo(Merchant::class);
    }
}
