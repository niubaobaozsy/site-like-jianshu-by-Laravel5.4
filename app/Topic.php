<?php

namespace App;

use App\Model;

class Topic extends Model
{
    //属于这个这个专题的所有文章
    public function posts(){
    	return $this->belongsToMany(\App\Post::class,'post_topics','topic_id','post_id');
    }
    //专题的文章数，用于withCount。可以用posts函数的count方法，但是没必要又做一次多对多的关联
    public function postTopics(){
    	return $this->hasMany(\App\PostTopic::class,'topic_id');
    }
}
