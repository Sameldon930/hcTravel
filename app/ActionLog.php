<?php

namespace App;

use App\Http\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model
{
    use Searchable;

    protected $fillable = [
        'admin_id', 'url', 'data','note'
    ];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public final function custom_admin_id($search_item, $search_params)
    {
        $this->builder->whereHas('admin', function ($query) use ($search_item) {
            $query->where('name', 'like', '%' . $this->request->get($search_item) . '%');
        });
    }

}
