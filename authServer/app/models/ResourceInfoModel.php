<?php
use LaravelBook\Ardent\Ardent;

class ResourceInfoModel extends Ardent{
	protected $table = 'resource_info' ;
	protected $fillable = array('server_ip','name','password') ;
	public static $rules = array(
		'name'=>'required|min:4',
		'password'=>'required|min:6'
	) ;
	
	public static function getResourceInfo()
	{
		$resourceInfo = DB::table('resource_info')->first() ;
		return $resourceInfo ;
	}
}