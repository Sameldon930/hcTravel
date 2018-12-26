<?php

namespace App;

use App\Http\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    use Searchable;

    protected $fillable = [
        'admin_id','title','content','status','type'
    ];

    const YES = 1;
    const NO = 2;

    const STATUS_SWITCH = [
        self::YES => '显示',
        self::NO => '隐藏',
    ];

    public function scopeShow($query){
        return $query->where('status',self::YES);
    }
}
