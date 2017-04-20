<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use LaravelBook\Ardent\Ardent;
use Carbon\Carbon;

class User extends Ardent implements UserInterface, RemindableInterface {

	public $autoPurgeRedundantAttributes = true;
	public static $passwordAttributes  = array('password', 'password_confirmation');
	public $autoHashPasswordAttributes = true;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'id',
		'group_id',
		'created_at',
		'updated_at',
		'phone',
		'address',
		'sex',
		'remark',
		'room_number',
		'extension_number',
		'portrait'
		];

	protected $guarded = array();

	public static $rules = array(
		'username' => 'required|alphaNum',
		'email'    => 'required|email|unique:users',
		'user_category' => 'required',
		'password' => 'required|min:6|confirmed',
		'password_confirmation' => 'required',
	);
	
	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	public function getRememberToken()
	{
		return $this->remember_token;
	}

	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	public function isActive()
	{
		$au = $this->hasOne('ActiveUser')->first();
		if ($au == null) return false;
		if (!$au->persistent && $au->updated_at->diffInHours() >= 1) {
			$au->delete();
			return false;
		}
		return true;
	}

	public function activate()
	{
		$aur = $this->hasOne('ActiveUser');//一对一关系
		if ($aur->first() == null) {
			$au = new ActiveUser();
			$au->user_id = $this->id;
			$au->device_id = 1;	// for test; not sure if it's effectively needed
			$au->save();
		} else {
			$aur->touch();
		}
	}

	public function deactivate()
	{
		$au = $this->hasOne('ActiveUser')->first();
		if ($au != null) {
			$au->delete();
		}
	}

	public function group()
	{
		return $this->belongsTo('Group','group_id','id');
	}

	public function updatePassword()
	{

	}

	public function updateUniques(array $rules = array(),
		array $customMessages = array(),
		array $options = array(),
		Closure $beforeSave = null,
		Closure $afterSave = null)
	{
		// 密码已修改，则删除用户的所有oauth session，需要重新获取token
		$need_revoke = $this->isDirty('password');
		$success = parent::updateUniques($rules, $customMessages, $options, $beforeSave, $afterSave);
		if ($success && $need_revoke) {
			// Invalidate all tokens associated to the user
			DB::table('oauth_sessions')->where('owner_id', $this->id)->where('owner_type', 'user')->delete();
		}
		return $success;
	}

	public function deleteExpiredTokens()
	{
		$time = time();                                                                              
		$expiredSessions = DB::select(
			"SELECT LS.id FROM
				(SELECT t.id as id
				FROM oauth_sessions as t
				WHERE t.owner_type='user' AND t.owner_id=?) LS
				JOIN oauth_session_access_tokens ON oauth_session_access_tokens.session_id=LS.id
				LEFT JOIN oauth_session_refresh_tokens ON oauth_session_refresh_tokens.session_access_token_id=oauth_session_access_tokens.id
			WHERE oauth_session_access_tokens.access_token_expires < ?
			AND (oauth_session_refresh_tokens.refresh_token_expires < ? OR oauth_session_refresh_tokens.refresh_token_expires IS NULL)", array($this->id, $time, $time));

		if (count($expiredSessions) == 0) {                                                          
			return 0;                                                                                
		} else {
			foreach ($expiredSessions as $session) {                                                 
				DB::table('oauth_sessions')                                                          
					->where('id', $session->id)                                         
					->delete();                                                                      
			}

			return count($expiredSessions);                                                          
		}                                    
	}

	public function getSessions()
	{
		$sessions = DB::select(
			"SELECT
				LS.id,
				oauth_session_access_tokens.access_token,
				oauth_session_refresh_tokens.refresh_token, oauth_session_access_tokens.access_token_expires
			FROM
				(SELECT *
				FROM oauth_sessions as t
				WHERE t.owner_type='user' AND t.owner_id=?) LS
			JOIN oauth_session_access_tokens ON oauth_session_access_tokens.session_id=LS.id
			LEFT JOIN oauth_session_refresh_tokens ON oauth_session_refresh_tokens.session_access_token_id=oauth_session_access_tokens.id", array($this->id));

		return $sessions;
	}
	
	/**
	 * 从oauth_sessions表中获取ownerType为user的用户信息，并且此用户必须在5分钟内进行过心跳检测
	 */
	public static function getClientActiveUsers()
	{
		$exprieTime = Carbon::createFromTimestamp(time()-20*60) ;
		//获取所有客户端在线用户的id
		$users = DB::table('oauth_sessions')->select('owner_id')->where('owner_type','=','user')->where('updated_at','>',$exprieTime)->get() ;
		$clientActiveUsers = array() ;
		
		//通过id循环获取在线用户信息
		foreach($users as $user)
		{
			$temp = User::find($user->owner_id) ;
			if($temp == NULL)
				continue ;
			$clientActiveUsers[] = $temp ;			
		}
		
		return $clientActiveUsers ;
	}
	
	/**
	 * 通过email获取用户信息
	 * @param string $email
	 * @return user对象
	 */
	public static function getUserInfoByEmail($email)
	{
		$users = DB::table('users')->where('email',$email)->get() ;
		return $users ;
	}
        
       // public static function getAllusers() {
		//return DB::table('users')->orderBy('id', 'desc')->paginate(10);
	//}
        
        public static function getUserInfoById($id)
        {
                $users = DB::table('users')->where('id',$id)->get() ;
                return $users ;
        }
     
        public static function getUserListByEmail($email)
        {
                $users = DB::table('users')->select()->get() ;
                return $users ;
        }
        public static function getListByEmail($email,$offset,$limit)
        {
                if ($limit == 0 && $offset==0) {
                     
                     $users = DB::table('users')->select('username','name','portrait as photo','id as userId','user_category','sex','phone','address','email')->get() ;
                     return $users ;
                }else if ($limit == 0 && $offset!=0){
                        $total = DB::table('users')->count();
			$users = DB::table('users')->skip($offset)->take($total)->select('username','name','portrait as photo','id as userId','user_category','sex','phone','address','email')->get();
		}else {
                $users = DB::table('users')->skip($offset)->take($limit)->select('username','name','portrait as photo','id as userId','user_category','sex','phone','address','email')->get();
		}
                return $users ;
        }

	public static function changeInfo($id, $type, $value)
	{
		return DB::table('users')->where('id', $id)->update([$type => $value]);
	}

}
