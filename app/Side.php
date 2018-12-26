<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Side extends Model
{
    protected $fillable = [
        'image', 'url','orderby','note','status'
    ];

    const STATUS_ONE = 1;
    const STATUS_TWO = 2;

    const STATUS = [
        self::STATUS_ONE => '显示',
        self::STATUS_TWO => '隐藏'
    ];

    public function scopeShow($query)
    {
        return $query->where('status','1');
    }

}
