<?php

namespace App;

use App\Model;

class Fan extends Model
{
    //粉丝用户
    public function fuser(){
    	return $this->hasOne(\App\User::class,'id','fan_id');//第二个参数，是要获取的目标id（从user表中）。第三个参数是fan表提供的外键。id=fan_id
    }
   //被关注的用户
    public function suser(){
    	return $this->hasOne(\App\User::class,'id','star_id');
    }
}
