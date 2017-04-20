<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use LaravelBook\Ardent\Ardent;
use Carbon\Carbon;

class ProjectGroupMember extends Ardent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'project_group_member';

	protected $guarded = array();

	public static $errorMessages = array(

	) ;

	public static $rules = array(
		'user_id' => 'required',
		'project_group_id' => 'required'
	);

	public function projectGroup(){
		return $this->belongsTo('ProjectGroup');
	}

    public static function getProjectGroupsByUser($groups, &$results)
    {
        if ($groups == null) {
            return;
        }

        foreach ($groups as $group) {
            $leafs = DB::table('project_group')->where('super_id', $group->id)->get();
            $nleafs = DB::table('project_group')->where('super_id', $group->id)->where('leaf', '0')->get();

            foreach ($leafs as $leaf) {
                $results[] = $leaf;
            }

            self::getProjectGroupsByUser($nleafs, $results);
        }
    }


	/**
	 * 根据项目组id查询项目组成员
	 */
	public static function listMembers($groupId){
		return DB::table('project_group_member')->where('project_group_id', $groupId)->get();
	}

	/**
	 * 删除整个项目组成员
	 * @param int $projectGroupId 项目组id
	 */
	public static function deleteMember($projectGroupId){
		return DB::table('project_group_member')->where('project_group_id', $projectGroupId)->delete();
	}

	/**
	 * 根据成员id删除成员
	 * @param $memberId
	 * @return mixed
	 */
	public static function  deleteMemberById($memberId) {
		return DB::table('project_group_member')->where('id', $memberId)->delete();
	}

	/**
	 * 根据项目组id, 用户id查询成员
	 * @param $groupId
	 * @param $userId
	 */
	public static function queryByUid($groupId, $userId){
		return DB::table('project_group_member')->where('project_group_id', $groupId)->where(
			function($query) use ($userId) {
				$query->where('user_id', $userId);
			}
		)->first();
	}

	public static function updateType($groupId, $userId, $type){
		return DB::table('project_group_member')->where('project_group_id', $groupId)->where(
			function($query) use ($userId) {
				$query->where('user_id', $userId);
			}
		)->update(array('type' => $type));
	}

	/**
	 * 根据用户id查询用户所在组
	 * @param $userId
	 * @return mixed
	 */
	public static function findByUid($userId){
		return DB::table('project_group_member')->where('user_id', $userId)->get();
	}

        


}
