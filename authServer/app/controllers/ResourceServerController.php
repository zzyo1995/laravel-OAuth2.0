<?php

class ResourceServerController extends \BaseController {

	public function __construct()
	{
		$this->beforeFilter('auth', array('only' => 'edit'));
        $this->beforeFilter('user.admin', array('only' => 'index'));
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if ('admin' != Auth::user()->username)
		{
			return Response::json(array('result'=>'failed','error_msg'=>'You do not have access to this page'));
		}
		$input = Input::all() ;
		
		if(!isset($input['status']))
		{
			$input['status'] = 'all' ;
		}
		
		
		switch($input['status'])
		{
			case 'all':
				//查看所有
				$attServers = AttachResource::getAllServers() ;
				break ;
			case 'success':
				$attServers = AttachResource::getServersByStatus(1) ;
				//查看授权成功的
				break ;
			case 'fail':
				$attServers = AttachResource::getServersByStatus(2) ;
				//查看授权失败的
				break ;
			case 'undo':
				$attServers = AttachResource::getServersByStatus(0) ;
				//查看未处理的
				break ;
		}
		
		return View::make('resources.show',array('attServers'=>$attServers,'active_tab'=>$input['status'],'nav_active'=>'resources')) ;//转至资源服务器列表
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return View::make('resources.create') ;//转向资源服务器注册页面
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all() ;
		$rules = array(
			'name'=>'required|alpha_num|unique:resource_servers',
			'password'=>'required|min:6|confirmed',
			'password_confirmation'=>'required'
		) ;
		
		$validator = Validator::make($input,$rules) ;
		
		if($validator->fails())
		{
			//输入不符合要求
			return View::make('resources.create')->withErrors($validator->errors()) ;
		}
		
		//对资源服务器密码进行加密
		$input['password'] = Hash::make($input['password']) ;
		
		$attactServer = new AttachResource(array('name'=>$input['name'],'password'=>$input['password'])) ;
		if($attactServer->save())
		{
			return Redirect::to('')->with('success', '资源服务器注册 '.$input['name'].' 成功。');
		}
		else
		{
			return View::make('resources.create')->withErrors($attactServer->errors()) ;
		}
		
	}

//	public function updateServerInfo()
	public function update($id)
	{
		$input = Input::all() ;
		
		switch($input['status'])
		{
			case "undo":
				$input['status'] = 0 ;
				break ;
			case "success":
				$input['status'] = 1 ;
				break ;
			case "fail":
				$input['status'] = 2 ;
				break ;
		}
		
		DB::table('resource_servers')->where('name',$input['name'])->update(array("status"=>$input['status'],'reason'=>$input['reason'])) ;
		$ret = array('result'=>'success') ;
		return Response::json($ret) ;
	}
	

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
/*	public function update($id)
	{
		return "hello ajax!" ;
	}*/


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
