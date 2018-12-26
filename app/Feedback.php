<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'admin_id','merchant_id','img','content','type','is_read'
    ];
    const YES = 1;
    const NO = 0;
    const FEEDBACK_READ= [
        self::YES => '已读',
        self::NO => '未读',
    ];
    public function Merchants(){
        return $this->belongsTo('App\Merchants', 'merchant_id');
    }
    public function scopeShow($query){
        return $query->where('is_read',self::YES);
    }
}
