<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class HouseAudit extends Model
{

    //    ******软删除需求******
    use SoftDeletes;
    protected $dates = ['delete_at'];
//    *******软删除需求******


    protected $fillable = [
        'merchant_id', 'img','code','status',
        'address_img', 'system_img','duty_img','mass_img',
        'safe_img', 'self_img','audit_img','accredit_img',
    ];
    const NOT_AUDIT = 1;
    const IN_AUDIT = 2;
    const SUCCESS_AUDIT  = 3;
    const FAIL_AUDIT  = 4;

    public function merchant(){
        return $this->belongsTo(Merchant::class);
    }
}
