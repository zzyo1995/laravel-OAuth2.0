<?php

class ProjectRole extends \LaravelBook\Ardent\Ardent {

	protected $table = 'oauth_project_roles';

	protected $guarded = [];

	protected $fillable = array("name", "value");

	protected $hidden = [
		'created_at',
		'updated_at',
		'pivot'
	];
	public static $rules = [
		'name' => 'required|alphaNum',
		'value' => 'required|alphaNum',
	];

	/**
	 * 获取系统中所有的角色
	 */
	public static function getAllRoles()
	{
		$roles = DB::table('oauth_project_roles')->get();
		return $roles;
	}

	/**
	 * 删除角色
	 */
	public static function deleteRole($id)
	{
		DB::table('oauth_project_roles')->where('id', $id)->delete();
	}
	
	public static function updateInfo($id, $input)
	{
		DB::table('oauth_project_roles')->where('id', $id)->update(
			array('name' => $input['name'], 'value' => $input['value'])
		);
	}
}
