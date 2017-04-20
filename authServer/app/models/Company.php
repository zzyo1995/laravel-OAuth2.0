<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use LaravelBook\Ardent\Ardent;
use Carbon\Carbon;

class Company extends Ardent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'company';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
//	protected $hidden = [
//		'id',
//		'email',
//		'phone',
//		'address',
//		'state',
//		'created_at',
//		'updated_at',
//		];

	protected $guarded = array();

	public static $errorMessages = array(
		'name.required'  => '请输入公司名',
		'name.alpha_num' => '用户名包含非法字符',
		'name.unique' => '公司已存在',
		'email.email' => '输入邮箱不合法',
		'email.required'  => '请输入邮箱'
	) ;

	public static $rules = array(
		'name' => 'required|alphaNum|unique:company',
		'email' => 'required|email',
		'applier_id' => 'required'
	);

	public function projectGroup() {
		return $this->hasMany('ProjectGroup');
	}

	public function companyUser() {
		return $this->hasMany('CompanyUser');
	}

	public function adminApply() {
		return $this->hasMany('AdminApply');
	}

	/**
	 * 分页获取所有的组织
	 * @return mixed
	 */
	public static function getAllCompanies() {
		return DB::table('company')->orderBy('id', 'desc')->paginate(100000);
	}

	public static function deleteCompany($type, $value, $userId) {
		return DB::table('company')->where($type, $value)->update(array("state"=> 2 , 'applier_id'=> $userId));
	}
	
	public static function changeInfo($id, $type, $value, $userId) {
		return DB::table('company')->where('id', $id)->update(array($type => $value , 'applier_id'=> $userId));
	}
	/**
	 * 根据审核状态分页查询组织
	 * @param $state
	 * 0:待审核    1:审核通过   2:审核不通过
	 */
	public static function getCompaniesByState($state, $user_id) {
      	$uid = DB::table('company_users')->where('user_id', $user_id)->lists('company_id');
		if ($uid){
   		return DB::table('company')
			->where('state', $state)->whereNotIn('id', $uid)->paginate(9);
		}
		return DB::table('company')
			->where('state', $state)->paginate(9);
	}

	public static function getCompanyIdByName($name){

		return DB::table('company')->where('state', 1)->where(
			function($query) use ($name){
				$query->where('name', $name);
			})->get();
	}

	/**
	 * 根据组织名, 状态 查找组织
	 * @param $name
	 * @param $state
	 */
	public static function getCompanyByName($name,$state,$user_id){
//    return DB::table('company')->where('name','like','%'.$name.'%')->paginate(10);
      $uid = DB::table('company_users')->where('user_id', $user_id)->lists('company_id');
	if ($uid){
      return DB::table('company')->where('state',$state)->where(
         function($query) use ($name){
            $query->where('name', 'like','%'.$name.'%');
         })->whereNotIn('id', $uid)->paginate(9);
	}
	  return DB::table('company')->where('state',$state)->where(
         function($query) use ($name){
            $query->where('name', 'like','%'.$name.'%');
         })->paginate(9);
//    $where = array('name'=>$name,'state'=>$state);
//    return DB::table('company')->where($where)->get();
   }

	/******************************************************************
	 **
	 * 提供api方法
	 *
	 *******************************************************************
	 */
	//获取所有组织
	public static function getCompanies($state) {
		return DB::table('company')->where('state',$state)->get();
	}

	/**
	 * 根据组织名查找组织
	 */
	public static function getCmpByName($name){
		return DB::table('company')->where('name',$name)->first();
	}

        public static function getCmpInfoByName($name)
        {
                $companyName = DB::table('company')->where('name',$name)->get() ;
                return $companyName;
        }

        public static function getCmpIdByName($name){

                return DB::table('company')->where('state', 1)->where(
                        function($query) use ($name){
                                $query->where('name', $name);
                        })->first();
        }

}
