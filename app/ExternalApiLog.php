<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExternalApiLog extends Model
{
    protected $fillable = [
        'merchant_id', 'note','request_data','respond_data',
    ];
}
