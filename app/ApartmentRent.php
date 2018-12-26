<?php

namespace App;

use App\Http\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class ApartmentRent extends Model
{
    use Searchable;

    protected $fillable = [
        'title','rental','orderby','thumbnail','image','house_type','rent_way','payment_mode','region','mobile','content','is_hidden'
    ];

    const RENT_WAY_ONE = 1;
    const RENT_WAY_TWO = 2;

    const RENT_WAYS = [
        self::RENT_WAY_ONE => '整套出租',
        self::RENT_WAY_TWO => '单间出租',
    ];

    public function scopeShow(){
        return $this->where('is_hidden','F');
    }
}
