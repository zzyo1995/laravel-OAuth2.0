<?php
use LaravelBook\Ardent\Ardent;
use Illuminate\Database\Connection ;

class Group extends Ardent {
	public static $scopes = NULL ;
	protected $table = 'groups';
	protected $guarded = array();
	
	public function __construct(array $attributes = array()) {
        parent::__construct($attributes);
        if(self::$scopes == NULL)
        {
        	self::$scopes = Scope::getAllScopes() ;
        }
    }
	
	public static $errorMessages = array(
			'name.required'  => '请输入组名',
			'name.alpha_num' => '包含非法字符',
			'name.unique' => '组名已经被使用，请重新填写组名',
			'privileges.required'=> '请选择组的权限'
	) ;
	public function getDescription() {
		return $this->description;
	}
	
	public function getID()
	{
		return $this->id ;
	}
	
	public static $rules = array(
			'name'     => 'required|alphaNum|unique:groups',
			'privileges' => 'required|notin:null'
	);
	public function getPrivileges() {
		return explode('|', $this->privileges);
	}
	
	public static function getGroupUsers($id)
	{
		return DB::table('users')->where('group_id',$id)->get() ;
	}
	
	public static function getNTGroupUsers($id)
	{
		return DB::table('users')->where('group_id','<>',$id)->get() ;
	}
}