<?php

namespace App;

use App\Http\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    use Searchable;

    protected $fillable = [
        'title','name', 'thumbnail', 'price','market_price',
        'content','address','mobile','url','top','orderby','status','type','new_level','measure'
    ];

    const YES = 1;
    const NO = 2;

    const STATUS_SWITCH = [
        self::YES => '显示',
        self::NO => '隐藏',
    ];

    const TOP_SWITCH = [
        self::YES => '置顶',
        self::NO => '不置顶',
    ];
    const GOOD_MEASURE = [
        self::YES => '自提',
        self::NO => '送货上门',
    ];
    public function scopeShow(){
        return $this->where('status',self::YES);
    }
}
