<?php
use LaravelBook\Ardent\Ardent;
class UserProfile extends Ardent{
	protected $table = "user_profiles" ;
	protected $fillable=['userId','address','mobile','age'] ;
	
	/**
	 * get user resource by user id
	 * @param string $userId
	 * @return resource object
	 */
	public static function getResourceByUserId($userId)
	{
		$resourceInfo = DB::table('user_profiles')->where('userId',$userId)->get() ;
		return $resourceInfo ;
	}
}