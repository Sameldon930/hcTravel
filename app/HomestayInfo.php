<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class HomestayInfo extends Model
{
    //    ******软删除需求******
    use SoftDeletes;
    protected $dates = ['delete_at'];
//    *******软删除需求******



    protected $fillable = [
        'merchant_id', 'business_img','business_num','business_name','business_time',
        'business_person','business_address','identity_front','identity_contrary',
        'identity_num','identity_name','contract_tenancy','status','property_img',
        'alibi_img','merchant_address','merchant_short_name','merchant_name','merchant_principal',
        'property_img_1', 'property_img_2', 'property_img_3', 'property_img_4', 'property_img_5',
        'property_img_6', 'property_img_7',
    ];

    const NOT_AUDIT = 1;
    const IN_AUDIT = 2;
    const SUCCESS_AUDIT  = 3;
    const FAIL_AUDIT  = 4;

    public function merchant(){
        return $this->belongsTo(Merchant::class);
    }

}
