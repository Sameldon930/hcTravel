<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfigGroup extends Model
{
    protected $fillable = [
       'name',
    ];

    public function config(){
        return $this->hasMany('app/ConfigGroup');
    }
}
