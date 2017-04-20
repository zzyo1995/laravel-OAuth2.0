<?php

class Role extends \LaravelBook\Ardent\Ardent
{

	protected $table = 'oauth_roles';

	protected $guarded = [];

	protected $fillable = array("name", "scope_name", "description");

	protected $hidden = [
		'created_at',
		'updated_at',
		'pivot'
	];
	public static $rules = [
		'name' => 'required|alphaNum',
	];

	/**
	 * 获取系统中所有的角色
	 */
	public static function getAllRoles()
	{
		$roles = DB::table('oauth_roles')->where('status', 1)->get();
		return $roles;
	}

	/**
	 * 更新scope权限对应的信息
	 */
	public static function updateInfo($id, $name, $value)
	{
		DB::table('oauth_roles')->where('id', $id)->update(array($name => $value));
	}

	/**
	 * 删除角色
	 */
	public static function deleteRoleInfo($id)
	{
		DB::table('oauth_scope_role')->where('role_id', $id)->update(array('status' => 0));
		DB::table('oauth_roles')->where('id', $id)->update(array('status' => 0));
	}

	/**
	 * 得到当前roleId下的权限
	 */
	public static function getCurScopes($roleId)
	{
		$scopes = DB::table('oauth_scope_role')->leftJoin(
				'oauth_scopes',
				'oauth_scopes.id',
				'=',
				'oauth_scope_role.scope_id'
			)->where('role_id', $roleId)->where('oauth_scope_role.status', 1)->get();
		return $scopes;
	}

	/**
	 * 在数据表oauth_roles是否已经存在
	 */
	public static function checkIfExistInRoles($name)
	{
		$chk = DB::table('oauth_roles')->where('name', $name)->where('status', 0)->pluck('id');
		return $chk;
	}

	/**
	 * 添加已经存在数据表中的角色
	 */
	public static function getRole($id, $description)
	{
		DB::table('oauth_roles')->where('id', $id)->update(array('status' => 1, 'description' => $description));
	}


	/**
	 * 角色添加权限值
	 */
	public static function addScopeByName($scopeId, $roleId)
	{
		$chk = DB::table('oauth_scope_role')->where('scope_id', $scopeId)->where('role_id', $roleId)->pluck('id');
		if ($chk) {
			DB::table('oauth_scope_role')->where('id', $chk)->update(array('status' => 1));
		} else {
			DB::table('oauth_scope_role')->insert(['scope_id' => $scopeId, 'role_id' => $roleId]);
		}
	}

	/**
	 * 角色删除权限值
	 */
	public static function deleteScopeByName($scopeId, $roleId)
	{
		DB::table('oauth_scope_role')->where('scope_id', $scopeId)->where('role_id', $roleId)->update(
			array('status' => 0)
		);
	}

	/**
	 * 得到未添加的所有权限
	 */
	public static function getAllScopes($roleId)
	{
		$curScopes = self::getCurScopes($roleId);
		$arr = array();
		foreach ($curScopes as $curScope) {
			$arr[] = $curScope->scope_id;
		}
		if ($arr != null) {
			$scopes = DB::table('oauth_scopes')->whereNotIn('id', $arr)->where('status', 1)->get();
		} else {
			$scopes = DB::table('oauth_scopes')->where('status', 1)->get();
		}
		return $scopes;
	}
}
