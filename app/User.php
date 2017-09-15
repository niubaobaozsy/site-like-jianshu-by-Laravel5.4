<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	protected $fillable = [
	'name','email','password'
	];
	//获取当前user的文章列表
	public function posts(){
		return $this->hasMany(\App\Post::class,'user_id','id');
	}
	//关注我的fan模型
	public function fans(){
		return $this->hasMany(\App\Fan::class,'star_id','id');
	}
	//我关注的fan模型
	public function stars(){
		return $this->hasMany(\App\Fan::class,'fan_id','id');
	}
	//关注某人
	public function doFan($uid){
		$fan = new \App\Fan();
		$fan->star_id = $uid;
		return $this->stars()->save($fan);
	}
	public function doUnFan($uid){
		$fan = new \App\Fan();
		$fan->star_id = $uid;
		return $this->stars()->delete($fan);
	}	
	//当前用户是否有这个粉丝
	public function hasFan($uid){
		//关注我的用户中谁是id=$uid的那个
		return $this->fans()->where('fan_id',$uid)->count();
	}
	//当前用户是否关注了某个
	public function hasStar($uid){
		return $this->stars()->where('star_id',$uid)->count();
	}	
}