<?php

namespace App\Admin\Controllers;


class PermissionController extends Controller{
	public function index(){
        $permissions = \App\AdminPermission::paginate(10);
        return view('/admin/permission/index', compact('permissions'));
	}
	public function create(){
		return view("/admin/permission/add");
	}
	public function store(){
        $this->validate(request(), [
            'name' => 'required|min:3',
            'description' => 'required'
        ]);

        \App\AdminPermission::create(request(['name', 'description']));
        return redirect('/admin/permissions');
	}

}