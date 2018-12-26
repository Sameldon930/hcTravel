<?php

namespace App;

use App\Http\Traits\AuthAdminTrait;
use App\Http\Traits\Searchable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use AuthAdminTrait; // @cxyauth
    use Searchable;


    protected $fillable = [
        'name', 'mobile', 'password','status','api_token'
    ];

    protected $hidden = [
        'password'
    ];

    public function actionLogs(){
        return $this->hasMany('app/ActionLog');
    }

    public function articles(){
        return $this->hasMany('app/Article');
    }

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

}
