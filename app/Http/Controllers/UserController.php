<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    //个人设置页面
    public function setting(){

    	return view('user.setting');
    }
    //个人设置行为
    public function settingStore(){

    }
    //个人中心页面
    public function show(User $user){
    	//这个用户个人信息，包含关注粉丝和文章 
    	$user = User::withCount(['stars','fans','posts'])->find($user->id);
    	//这个人的文章，前十条
    	$posts = $user->posts()->orderBy('created_at','desc')->take(10)->get();
    	//这个人关注的用户，包含关注用户的关注粉丝文章数
    	$stars = $user->stars;
    	$susers = User::whereIn('id',$stars->pluck('star_id'))->withCount(['stars','fans','posts'])->get();
    	//这个人粉丝的用户，包含关注用户的关注粉丝文章数
    	$fans= $user->fans;
    	$fusers = User::whereIn('id',$fans->pluck('fan_id'))->withCount(['stars','fans','posts'])->get();
    	return view('user\show',compact('user','posts','susers','fusers'));
    }
    //关注用户
    public function fan(User $user){
    	ini_set('always_populate_raw_post_data', -1);
    	$me = \Auth::user();//获取当前用户的用户
    	$me->doFan($user->id);
    	// return [
    	// 'error'=>0,
    	// 'msg'=>''
    	// ];
    	echo 1;
    }
    //取消关注
    public function unfan(User $user){
    	ini_set('always_populate_raw_post_data', -1);
    	$me = \Auth::user();
    	$me->doUnFan($user->id);
		echo 1;
    }
}
