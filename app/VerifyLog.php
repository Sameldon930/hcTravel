<?php

namespace App;

use App\Http\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class VerifyLog extends Model
{
    use Searchable;

    protected $fillable = [
        'merchant_id','verify_success', 'status', 'type','feedback',
    ];

    const MERCHANT_VERIFY = 1;
    const HOMESTAY_VERIFY = 2;
    const HOUSE_VERIFY = 3;

    //审核类型
    const VERIFY_TYPE =[
      self::MERCHANT_VERIFY =>'商户认证',
      self::HOMESTAY_VERIFY =>'民宿核验',
      self::HOUSE_VERIFY =>'房屋鉴定',
    ];
    //审核状态
    const IN_AUDIT = 1;
    const SUCCESS_AUDIT  = 2;
    const FAIL_AUDIT  = 3;
    const CHECK_AUDIT =[
        self::IN_AUDIT => "待审核",
        self::SUCCESS_AUDIT => "通过认证",
        self::FAIL_AUDIT => "认证失败",
    ];


    public function merchant(){
        return $this->belongsTo(Merchant::class);
    }

    public final function custom_mobile($search_item, $search_params)
    {
        $this->builder->whereHas('merchant', function ($query) use ($search_item) {
            $query->where('mobile', 'like', '%' . $this->request->get($search_item) . '%');
        });
    }
}
