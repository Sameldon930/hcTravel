<?php

namespace App;

use App\Http\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use Searchable;

    protected $fillable = [
        'name','age','sex','apply_position','work_experience','orderby','education','current_position','mobile','is_hidden','evaluate'
    ];
    
    const SEX_MAN = 1;
    const SEX_FEMALE = 2;

    const EDUCATION_ONE = 1;
    const EDUCATION_TWO = 2;
    const EDUCATION_THREE = 3;
    const EDUCATION_FOUR = 4;
    const EDUCATION_FIVE = 5;
    const EDUCATION_SIX = 6;

    const SEX = [
        self::SEX_MAN => '男',
        self::SEX_FEMALE => '女'
    ];

    const EDUCATIONS = [
        self::EDUCATION_ONE => '中专/技校',
        self::EDUCATION_TWO => '高中以下',
        self::EDUCATION_THREE => '高中',
        self::EDUCATION_FOUR => '大专',
        self::EDUCATION_FIVE => '本科',
        self::EDUCATION_SIX => '硕士及以上',
    ];

    public function scopeShow(){
        return $this->where('is_hidden','F');
    }
}
