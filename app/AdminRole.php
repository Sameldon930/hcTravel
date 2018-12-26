<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    // @cxyauth

    protected $table = 'admin_role';

    protected $fillable = [
        'role_id', 'admin_id',
    ];
}
