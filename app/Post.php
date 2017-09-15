<?php

namespace App;

use App\Model;

class Post extends Model
{
	//关联用户
	public function user(){

		return $this->belongsTo('App\User');
	}
	//关联评论模型
	public function comments(){
		return $this->hasMany('App\Comment')->orderBy('created_at','desc');   
	}
	//关联赞，一个文章和一个用户只能产生一个赞的关联
	public function zan($user_id){
		return $this->hasOne('App\Zan')->where('user_id',$user_id);
	}
	//这篇文章所有赞
	public function zans(){
		return $this->hasMany('App\Zan');
	}
	//属于某个作者的文章
	public function scopeAuthorBy($query,$user_id){
		return $query->where('user_id',$user_id);
	}
	//文章和文章专题的关系表之间的关联
	public function postTopics(){
		return $this->hasMany(\App\PostTopic::class,'post_id','id');
	}
	//不属于某个专题的文章
	public function scopeTopicNotBy($query,$topic_id){
		return $query->doesntHave('postTopics','and',function($q) use($topic_id){
			$q->where('topic_id',$topic_id);
		});
	}
	//全局scope方式
	protected static function boot(){
		parent::boot();
		static::addGlobalScope("avaiable",function($builder){
			$builder->whereIn('status',[0,1]);
		});
	}
}
