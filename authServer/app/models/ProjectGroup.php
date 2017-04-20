<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use LaravelBook\Ardent\Ardent;
use Carbon\Carbon;

//自定义验证规则hans,检验字符串是否只包含字母数字汉字下划线
Validator::extend(
	'hans',
	function ($attribute, $value, $parameters) {
		$pattern = '/^[0-9a-zA-Z_\x{4e00}-\x{9fa5}]+$/u';
		if (preg_match($pattern, $value)) {
			return true;
		} else {
			echo "输入含有非法字符，请重试.";
			return false;
		}
	}
);


class ProjectGroup extends Ardent
{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'project_group';

	protected $guarded = array();

	public static $errorMessages = array();

	public static $rules = array(
		'name' => 'required|hans',
		'company_id' => 'required',
		'enname' => 'required|alphaNum|unique:project_group'
	);


	public static $rule123 = array(
		'name' => 'required|hans',
		//'company_id' => 'required',
		//'super_id' => 'required'
	);


	public function company()
	{
		return $this->belongsTo('Company');
	}

	public function projectGroupMember()
	{
		return $this->hasMany('ProjectGroupMember');
	}

	/**
	 * query list of projectGroup
	 */
	public static function listGroups($companyId, $superId)
	{
		if ($superId == null) {
			return DB::table('project_group')->whereNull('super_id')->where(
				function ($query) use ($companyId) {
					$query->where('company_id', $companyId);
				}
			)->get();
		}
		return DB::table('project_group')->where('super_id', $superId)->where(
			function ($query) use ($companyId) {
				$query->where('company_id', $companyId);
			}
		)->get();

	}

	/**
	 * 根据条件查询唯一对象
	 */
	public static function queryByCondition($companyId, $superId, $groupName)
	{
		if ($superId != null) {
			return DB::table('project_group')->where("company_id", $companyId)->where(
				function ($query) use ($groupName) {
					$query->where("name", $groupName);
				}
			)->first();
		}
		return DB::table('project_group')->where("company_id", $companyId)->where(
			function ($query) use ($superId) {
				$query->where("super_id", $superId);
			}
		)->where(
			function ($query) use ($groupName) {
				$query->where("name", $groupName);
			}
		)->first();
	}

	public static function queryByEnCondition($companyId, $superId, $groupName)
	{
		if ($superId != null) {
			return DB::table('project_group')->where("company_id", $companyId)->where(
				function ($query) use ($groupName) {
					$query->where("enname", $groupName);
				}
			)->first();
		}
		return DB::table('project_group')->where("company_id", $companyId)->where(
			function ($query) use ($superId) {
				$query->where("super_id", $superId);
			}
		)->where(
			function ($query) use ($groupName) {
				$query->where("enname", $groupName);
			}
		)->first();
	}


	public static function checkNameUnique($companyId, $groupName)
	{
		return DB::table('project_group')->where("company_id", $companyId)->where(
			function ($query) use ($groupName) {
				$query->where("name", $groupName);
			}
		)->first();
	}
	
	public static function checkEnNameUnique($companyId, $groupName)
	{
		return DB::table('project_group')->where("company_id", $companyId)->where(
			function ($query) use ($groupName) {
				$query->where("enname", $groupName);
			}
		)->first();
	}


	/**
	 * 根据项目组id删除
	 */
	public static function deleteGroupById($groupId)
	{
		DB::table('project_group')->where('super_id', $groupId)->update(['super_id' => 0]);
		return DB::table('project_group')->where('id', $groupId)->update(['super_id' => 0]);
	}

	/**
	 * 根据部门id删除项目组
	 * @param int $departmentId
	 */
	public static function deleteGroupsByDepId($departmentId)
	{
		return DB::table("project_group")->where("department_id", $departmentId)->delete();
	}

	/**
	 * 得到除父系组和已经有父组的所有组
	 * @param $id $super_id
	 */
	public static function getAllNoOwnerGroups($projectGroupName, $super_id, $company_id)
	{
		$sid = $super_id;
		$cur_id = NULL;
		do {
			$cur_id = $sid;
			$sid = DB::table("project_group")->where("id", $cur_id)->pluck('super_id');

		} while ($sid);

		return DB::table("project_group")->whereNotIn('id', [$cur_id])->whereNotIn('super_id', [$super_id])->where(
			'super_id',
			0
		)->whereNotIn('name', [$projectGroupName])->where("company_id", $company_id)->get();

	}

}
