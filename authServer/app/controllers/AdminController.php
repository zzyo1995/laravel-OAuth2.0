<?php

class AdminController extends BaseController {

    public function __construct()
    {
        $this->beforeFilter('user.admin');
    }

	public function home()
	{
		if ('admin' != Auth::user()->username)
		{
			return Response::json(array('result'=>'failed','error_msg'=>'You do not have access to this page'));
		}
        	return View::make('admin.home', array('nav_active' => "home"));//转向admin的管理页面
	}

	public function syshome()
	{
		if ('sysadmin' != Auth::user()->username && 'admin' != Auth::user()->username)
		{
			return Response::json(array('result'=>'failed','error_msg'=>'You do not have access to this page'));
		}
        	return View::make('admin.home', array('nav_active' => "home"));//转向sysadmin的管理页面
	}
	public function safehome()
	{
        	return View::make('safeadmin.home', array('nav_active' => "home"));//转向safeadmin的管理页面
	}
	public function audithome()
	{
        	return View::make('auditadmin.home', array('nav_active' => "home"));//转向auditadmin的管理页面
	}

	public function users()
	{
       	 	return View::make('users.index', array('nav_active' => "users"));
	}
}
