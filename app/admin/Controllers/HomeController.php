<?php

namespace App\Admin\Controllers;


class HomeController extends Controller{
	//登陆展示
	public function index(){
		return view('admin.home.index');
	}
}