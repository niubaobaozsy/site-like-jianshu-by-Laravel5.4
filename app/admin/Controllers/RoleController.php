<?php

namespace App\Admin\Controllers;


class RoleController extends Controller{
	public function index(){
		$roles = \App\AdminRole::paginate(10);
		return view("/admin/role/index",compact('roles'));
	}
	public function create(){
		return view("admin/role/add");
	}
	public function store(){
		$this->validate(request(),[
			'name'=>'required|min:3',
			'description'=>'required',
			]);
		\App\AdminRole::create(request(['name','description']));
		return redirect('/admin/roles');
	}
	public function permission(\App\AdminRole $role){
		//获取所有权限,all方法取得数据表里所有的信息对象
		$permissions = \App\AdminPermission::all();
		//获取当前角色权限
		$myPermissions = $role->permissions;
		return view("admin/role/permission",compact('permissions','myPermissions','role'));
	}
	public function storePermission(\App\AdminRole $role){
		$this->validate(request(),[
			'permissions'=>'required|array'
			]);
		//find方法是通过主键来在数据表中获取数据对象，request('roles')是主键
		$permissions = \App\AdminPermission::findMany(request('permissions'));
		$myPermissions = $role->permissions;
		//要增加的
		$addPermissions = $permissions->diff($myPermissions);
		foreach ($addPermissions as $permission) {
			$role->grantPermission($permission);
		}
		//要删除的
		$deletePermissions = $myPermissions->diff($permissions);
		foreach($deletePermissions as $permission){
			$role->deletePermission($permission);
		}
		return back();
	}
}