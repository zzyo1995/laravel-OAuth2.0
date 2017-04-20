<?php

class Scope extends \LaravelBook\Ardent\Ardent {

    protected $table = 'oauth_scopes';

    protected $guarded = [];
	
    protected $fillable = array("name","scope","description") ;
    
    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot'
    ];
    public static $rules = [
        'name'  => 'required|alphaNum',
    ];
    
    /**
     * 获取系统中所有的scope权限
     * @return 所有权限数组
     */
    public static function getAllScopes()
    {
    	$scopes = DB::table('oauth_scopes')->get() ;
    	return $scopes;
    }
    
    /**
     * 更新scope权限对应的信息
     * @param string $id
     * @param string $name
     * @param string $value
     */
    public static function updateInfo($id,$name,$value)
    {
    	DB::table('oauth_scopes')->where('id',$id)->update(array($name=>$value));
    }
    
    /**
     * 通过id删除对应的scope权限值
     * @param string $id
     */
    public static function deleteScopeInfo($id)
    {
    	DB::table('oauth_scopes')->where('id',$id)->delete() ;
    }
}
