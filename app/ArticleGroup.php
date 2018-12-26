<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleGroup extends Model
{
    protected $fillable = [
        'name', 'status',
    ];

    public function articles(){
        return $this->belongsTo('app/Article');
    }

    public function getArticleGroups(){

        return $this->paginate(20);

    }
}