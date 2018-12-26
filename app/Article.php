<?php

namespace App;

use App\Http\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Searchable;

    protected $fillable = [
        'admin_id', 'group_id', 'title','thumbnail','content',
        'ready', 'top', 'orderby','status','now'
    ];
    const YES = 1;
    const NO = 2;

    const STATUS_SWITCH = [
       self::YES => '显示',
       self::NO => '隐藏',
    ];

    const TOP_SWITCH = [
        self::YES => '置顶',
        self::NO => '不置顶',
    ];


    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function articleGroup(){
        return $this->belongsTo(ArticleGroup::class,'group_id','id');
    }

    public function scopeGetArticles($group_id){
        return $this->where('group_id',$group_id);
    }

    public function scopeShow($query){
        return $query->where('status',self::YES);
    }

    public final function custom_group_id($search_item, $search_params)
    {
        $this->builder->whereHas('articleGroup', function ($query) use ($search_item) {
            $query->where('id', $this->request->get($search_item));
        });
    }
}
