<?php

class ProjectRoleController extends \BaseController
{

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
		if ('admin' != Auth::user()->username) {
			return Response::json(array('result' => 'failed', 'error_msg' => 'You do not have access to this page'));
		}
		$roles = ProjectRole::getAllRoles();
		return View::make('project_role.index', array('roles' => $roles, 'active' => 'project_roles', 'nav_active' => 'project_roles'));
	}


	/**
	 * 删除对应id的project_role信息
	 */
	public function deleteRole($id)
	{

		ProjectRole::deleteRole($id);
		return Redirect::to('admin/project_roles');
	}

	/**
	 * 创建组内角色
	 */
	public function getAddRole()
	{
		if ('admin' != Auth::user()->username) {
			return Response::json(array('result' => 'failed', 'error_msg' => 'You do not have access to this page'));
		}
		return View::make('project_role.addProjectRole', array('active' => 'project_roles', 'nav_active' => 'project_roles'));
	}
	/**
	 * 添加project_role数据库中
	 */
	public function postAddRole()
	{
		$input = Input::all();
		//定义输入规则
		$rules = array(
			'name' => 'required|alphaNum|unique:oauth_project_roles',
			'value' => 'required|alphaNum|unique:oauth_project_roles'
		);
		
		$validator = Validator::make($input, $rules);
		if ($validator->fails()) {
			//输入参数验证失败
			return Redirect::action('ProjectRoleController@getAddRole')->with('error', '输入不能为空并且组内角色名不能重复！');
		}

		$role = new ProjectRole($input);
		$role->exists = false;
		if ($role->save()) {
			return Redirect::action('ProjectRoleController@index')->with('success', '创建组内角色成功！');
		} else {
			//保存数据失败
			return Redirect::action('ProjectRoleController@index')->with('error', '创建组内角色失败！');
		}
	}

	/**
	 * 修改组内角色信息
	 */
	public function getChangeInfo($id)
	{
		if ('admin' != Auth::user()->username) {
			return Response::json(array('result' => 'failed', 'error_msg' => 'You do not have access to this page'));
		}
		
		$roleInfo = ProjectRole::find($id);
		return View::make('project_role.changeProjectRole', array('active' => 'project_roles', 'nav_active' => 'project_roles', 'roleInfo' => $roleInfo));
	}
	/**
	 * 修改组内角色信息
	 */
	public function postChangeInfo($id)
	{
		$roleInfo = Input::all();
		$input = array('name' => $roleInfo['name'], 'value' => $roleInfo['value']);
		
		if ($roleInfo['name'] == $roleInfo['old_name'] && $roleInfo['value'] == $roleInfo['old_value']) {
			return Redirect::action('ProjectRoleController@index')->with('success', '无修改！');
		}
		if ($roleInfo['name'] == $roleInfo['old_name']) {
			$ruleValue = array('value' => 'required|alphaNum|unique:oauth_project_roles');
			$inputValue = array('value' => $roleInfo['value']);
			$validatorValue = Validator::make($inputValue, $ruleValue);
			if ($validatorValue->fails()) {
				//输入参数验证失败
				return Redirect::action('ProjectRoleController@index')->with('error', '输入不能为空并且组内角色名不能重复！');
			}

		}
		
		if ($roleInfo['value'] == $roleInfo['old_value']) {
			$ruleName = array('name' => 'required|alphaNum|unique:oauth_project_roles');
			$inputName = array('name' => $roleInfo['name']);
			$validatorName = Validator::make($inputName, $ruleName);
			if ($validatorName->fails()) {
				//输入参数验证失败
				return Redirect::action('ProjectRoleController@index')->with('error', '输入不能为空并且组内角色名不能重复！');
			}

		}
		
		if ($roleInfo['name'] != $roleInfo['old_name'] && $roleInfo['value'] != $roleInfo['old_value']) {
			//定义输入规则
			$rules = array(
				'name' => 'required|alphaNum|unique:oauth_project_roles',
				'value' => 'required|alphaNum|unique:oauth_project_roles'
			);
		
			$validator = Validator::make($input, $rules);
			if ($validator->fails()) {
				//输入参数验证失败
				return Redirect::action('ProjectRoleController@index')->with('error', '输入不能为空并且组内角色名不能重复！');
			}
		}
		
		ProjectRole::updateInfo($id, $input);
		return Redirect::action('ProjectRoleController@index')->with('success', '创建组内角色成功！');
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
	 * @param  int $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
