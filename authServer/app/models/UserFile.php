<?php
use LaravelBook\Ardent\Ardent;
class UserFile extends Ardent{
	protected $table = "user_files" ;
	protected $fillable = ['userId','fileId','fileName'] ;
	
	public static function getUserFilesByUID($userId,$pageNum=5)
	{
		return DB::table('user_files')->where('userId',$userId)->paginate($pageNum) ;
	}
	
	public static function getUserFileByUidAndFileName($uid,$filename)
	{
		return DB::table('user_files')->where('userId',$uid)->where('filename',$filename)->get() ;
	}
}