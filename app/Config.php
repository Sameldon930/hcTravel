<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $fillable = [
        'group_id', 'key','value',
    ];

    public function configGroup(){
        return $this->belongsTo('app/ConfigGroup');
    }
}
