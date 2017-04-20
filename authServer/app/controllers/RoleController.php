<?php

class RoleController extends \BaseController
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
		$roles = Role::getAllRoles();
		return View::make('role.index', array('roles' => $roles, 'active' => 'roles', 'nav_active' => 'roles'));
	}


	/**
	 * 异步更新role信息
	 */
	public function updateRoleInfo()
	{
		//获取输入信息
		$input = Input::all();

		//对应的输入验证
		$rules = array(
			'id' => 'required',
			'name' => 'required',
			'value' => 'required'
		);

		$validator = Validator::make($input, $rules);

		if ($validator->fails()) {
			return Response::json($validator->errors());
		}
		Role::updateInfo($input['id'], $input['name'], $input['value']);
		return Response::json(array('result' => 'success'));
	}

	/**
	 * 异步删除对应id的role信息
	 */
	public function deleteRoleInfo()
	{
		if (!Input::has('id')) {
			//输入参数有误
			return Response::json(array('result' => 'error', 'error_msg' => 'parameter id null error'));
		}

		$id = Input::input('id');
		Role::deleteRoleInfo($id);
		return Response::json(array('result' => 'success'));
	}

	/**
	 * 添加Role数据库中
	 */
	public function addRoleInfo()
	{
		$input = Input::all();

		$chk = Role::checkIfExistInRoles($input['name']);
		if ($chk) {
			Role::getRole($chk, $input['description']);
			return Redirect::action('RoleController@index')->with('success', '创建角色成功！');
		}
		//定义输入规则
		$rules = array(
			'name' => 'required|unique:oauth_roles',
			'description' => 'required'
		);

		$validator = Validator::make($input, $rules);
		if ($validator->fails()) {
			//输入参数验证失败
			return Redirect::action('RoleController@addRoleInfo')->with('error', '输入不能为空并且角色名不能重复！');
		}

		$role = new Role($input);
		$role->exists = false;
		if ($role->save()) {
			return Redirect::action('RoleController@index')->with('success', '创建角色成功！');
		} else {
			//保存数据失败
			return Redirect::action('RoleController@index')->with('error', '创建角色失败！');
		}
	}

	/**
	 * 创建角色
	 */
	public function addRole()
	{
		if ('admin' != Auth::user()->username) {
			return Response::json(array('result' => 'failed', 'error_msg' => 'You do not have access to this page'));
		}
		return View::make('role.addRole', array('active' => 'roles', 'nav_active' => 'roles'));
	}

	/**
	 * 权限管理页面
	 */
	public function showScopes()
	{
		$roleId = Input::get('roleId');
		$Scopes = Role::getCurScopes($roleId);
		$allScopes = Role::getAllScopes($roleId);
		return View::make(
			'role.scopeIndex',
			array(
				'roleId' => $roleId,
				'Scopes' => $Scopes,
				'allScopes' => $allScopes,
				'nav_active' => 'roles'
			)
		);
	}


	/**
	 * 角色添加权限
	 */
	public function addScope()
	{
		$roleId = Input::get('roleId');
		$scopeId = Input::get('scopeId');
		$Scopes = Role::getCurScopes($roleId);
		$allScopes = Role::getAllScopes($roleId);
		Role::addScopeByName($scopeId, $roleId);
		return Redirect::action(
			'RoleController@showScopes',
			array(
				'roleId' => $roleId
			)
		)->with('success', '添加权限成功！');
	}

	/**
	 * 角色删除权限
	 */
	public function deleteScope()
	{
		$roleId = Input::get('roleId');
		$scopeId = Input::get('scopeId');
		Role::deleteScopeByName($scopeId, $roleId);
		return Redirect::action(
			'RoleController@showScopes',
			array(
				'roleId' => $roleId
			)
		)->with('success', '删除权限成功！');
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
