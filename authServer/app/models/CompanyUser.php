<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use LaravelBook\Ardent\Ardent;
use Carbon\Carbon;

class CompanyUser extends Ardent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'company_users';

	protected $guarded = array();

	public static $errorMessages = array(

	) ;

	public static $rules = array(
		'user_id' => 'required',
		'company_id' => 'required'
	);

	public function company(){
		return $this->belongsTo('Company');
	}

	/**
	 * 查看已加入的组织
	 */
	public static function myJoin($userId) {
		return DB::table('company_users')->where('user_id',$userId)->where(
			function($query){
				$query->where('state',1);
			}
		)->get();
	}

	/**
	 * 检查用户是否已加入某组织
	 * @param $userId
	 * @param $companyId
	 * @return mixed
	 */
//	public static function getCmpUser($userId, $companyId){
//		return DB::table('company_users')->where('user_id',$userId)->where(
//			function($query) use ($companyId){
//				$query->where('company_id', $companyId);
//			}
//		)->where(
//			function($query){
//				$query->where('state',1);
//			}
//		)->first();
//	}

	public static function getUser($userId, $companyId){
		return DB::table('company_users')->where('user_id',$userId)->where(
			function($query) use ($companyId){
				$query->where('company_id', $companyId);
			}
		)->first();
	}

	/**
	 * 删除公司用户
	 * @param $userId
	 * @param $companyId
	 * @return mixed
	 */
	public static function deleteCmpUser($userId, $companyId){
		$state = DB::table('company_users')->where('user_id',$userId)->where(
			function($query) use ($companyId){
				$query->where('company_id', $companyId);
			})->delete();
                $groups = DB::table('project_group')->where('company_id', $companyId)->get();
                foreach($groups as $g){
                    DB::table('project_group_member')->where('project_group_id', $g->id)->where(
                        function($query) use ($userId){
                                $query->where('user_id', $userId);
                        })->delete();
                }

		return $state;
	}

	/**
	 * 更新状态
	 * @param $cmpUserId
	 * @param $state
	 * @return mixed
	 */
	public static function  updateState($cmpUserId, $state){
		return DB::table('company_users')->where('id',$cmpUserId)->update(array('state'=>$state));
	}

	public static function updateStateByCondition($userId,$companyId,$state,$reason){
		return DB::table('company_users')->where('user_id',$userId)->where(
			function($query) use ($companyId){
				$query->where('company_id', $companyId);
			}
		)->update(array('state'=>$state, 'reason'=>$reason));
	}

	public static function setAdmin($userId,$companyId,$state, $type){
		return DB::table('company_users')->where('user_id',$userId)->where(
			function($query) use ($companyId){
				$query->where('company_id', $companyId);
			}
		)->update(array('state'=>$state, 'type' => $type));
	}

	/**
	 * 判断是否是组织管理员
	 */
	public static function isAdmin($userId){
		return DB::table('company_users')->where('user_id',$userId)->where(
			function($query){
				$query->where('type', 1);
			}
		)->where(
			function($query){
				$query->where('state', 1);
			}
		)->first();
	}

	/**
	 * 判断用户是否是某个组织的管理员
	 * @param $userId
	 * @param $companyId
	 * @return mixed
	 */
	public static function isCompanyAdmin($userId, $companyId){
		return DB::table('company_users')->where('user_id',$userId)->where(
			function($query){
				$query->where('type', 1);
			}
		)->where(
			function($query){
				$query->where('state', 1);
			}
		)->where(
			function($query) use ($companyId) {
				$query->where('company_id', $companyId);
			}
		)->first();
	}


	/**
	 * 根据用户id查询组织管理员, 查询用户可管理的组织
	 * @param $userId
	 * @return mixed
	 */
	public static function getCompanyUserByUserId($userId){
		return DB::table('company_users')->where('user_id',$userId)->where(
			function($query){
				$query->where('type', 1);
			}
		)->where(
			function($query){
				$query->where('state', 1);
			}
		)->get();
	}


	/**
	 * 通过组织id获取所有组织成员
	 * @param $companyId
	 */
	public static function getAllUserByCmpId($companyId){
		return DB::table('company_users')->where('company_id', $companyId)->where(
			function($query){
				$query->where('state', 1);
			}
		)->paginate(9);
	}
	public static function getAllUserByCmpId2($companyId){
		return DB::table('company_users')->where('company_id', $companyId)->where(
			function($query){
				$query->where('state', 1);
			}
		)->get();
	}
	public static function getAllUserByCon($userName, $companyId, $type){
		if ($type == 1) {
			return DB::table('company_users')
		        ->join('users', 'users.id', '=', 'company_users.user_id')
				->where('company_id', $companyId)->where('state', 1)->where(
				function($query) use ($userName){
					$query->where('username', 'like','%'.$userName.'%');
				}
				)->paginate(1000);
		} else {
		
			$suid = DB::table('project_group')
						->leftJoin('project_group_member', 'project_group.id', '=', 'project_group_member.project_group_id')
						->where(function($query) use ($userName){
					$query->where('project_group.name', 'like','%'.$userName.'%');
				}
				)->lists('user_id');
				
			if ($suid == null) {
				$suid = array(-1);
			}		
			return DB::table('company_users')
				->where('company_id', $companyId)->where('state', 1)
				->whereIn('user_id',$suid)->paginate(1000);		
		}
	}
	public static function getAllUserByCon2($userName, $companyId, $type){
		if ($type == 1) {
			return DB::table('company_users')
		        ->join('users', 'users.id', '=', 'company_users.user_id')
				->where('company_id', $companyId)->where('state', 1)->where(
				function($query) use ($userName){
					$query->where('username', 'like','%'.$userName.'%');
				}
				)->get();
		} else {
			$suid = DB::table('project_group')
						->leftJoin('project_group_member', 'project_group.id', '=', 'project_group_member.project_group_id')
						->where(function($query) use ($userName){
					$query->where('project_group.name', 'like','%'.$userName.'%');
				}
				)->lists('user_id');
				
			if ($suid == null) {
				$suid = array(-1);
			}		
			return DB::table('company_users')
				->where('company_id', $companyId)->where('state', 1)
				->whereIn('user_id',$suid)->get();
		}
	}

	/**
	 * 根据组织id,成员加入状态 获取组织成员
	 * @param $companyId
	 * @param $state
	 * @return mixed
	 */
	public static function getAllUserByCondition($companyId, $state) {
		return DB::table('company_users')->where('company_id', $companyId)->where(
			function($query) use ($state){
				$query->where('state', $state);
			}
		)->get();
	}

}
