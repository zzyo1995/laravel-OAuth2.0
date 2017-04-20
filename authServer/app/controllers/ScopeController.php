<?php

class ScopeController extends \BaseController {

	public function __construct()
	{
		$this->beforeFilter('user.admin');//运行类中方法之前，必须要经过user.admin过滤
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
		$scopes = Scope::all() ;
		return View::make('scope.index',array('scopes'=>$scopes,'active'=>'scopes','nav_active'=>'scopes')) ;//转至系统权限管理页面
	}


	/**
	 * 异步更新scope信息
	 */
	public function updateScopeInfo()
	{
		//获取输入信息
		$input = Input::all() ;
		
		//对应的输入验证
		$rules = array(
			'id'=>'required',
			'name'=>'required',
			'value'=>'required'
		) ;
		
		$validator = Validator::make($input,$rules) ;
		
		if($validator->fails())
		{
			return Response::json($validator->errors()) ;
		}
		Scope::updateInfo($input['id'],$input['name'],$input['value']) ;
		return Response::json(array('result'=>'success')) ;
	}
	
	/**
	 * 异步删除对应id的scope信息
	 */
	public function deleteScopeInfo()
	{
		if(!Input::has('id'))
		{
			//输入参数有误
			return Response::json(array('result'=>'error','error_msg'=>'parameter id null error')) ;
		}
		
		$id = Input::input('id') ;
		Scope::deleteScopeInfo($id) ;
		return Response::json(array('result'=>'success')) ;
	}
	
	/**
	 * 添加scope权限类型到数据库中
	 */
	public function addScopeInfo()
	{
		$input = Input::all() ;
		
		//定义输入规则
		$rules = array(
			'name'=>'required',
			'scope'=>'required',
			'description'=>'required'
		) ;
		
		$validator = Validator::make($input,$rules) ;
		if($validator->fails())
		{
			//输入参数验证失败
			return Response::json($validator->errors()) ;
		}
		
		$scope = new Scope($input) ;
		$scope->exists = false ;
		if($scope->save())
		{
			return Response::json(array('result'=>'success','id'=>$scope->id)) ;
		}
		else
		{
			//保存数据失败
			return Response::json($scope->errors()) ;
		}
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
	public function update($id)
	{
		//
	}


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
