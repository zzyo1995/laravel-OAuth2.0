<?php
use LaravelBook\Ardent\Ardent;
class AttachResource extends Ardent
{
	protected $table = "resource_servers" ;
	protected $fillable = array('name','password') ;
	
	/**
	 * status:
	 * 0：表示未处理
	 * 1：表示成功
	 * 2：表示失败
	 */
	
	/**
	 * 获取resources_servers表中所有的数据
	 */
	public static function getAllServers()
	{
		return DB::table('resource_servers')->get() ;
	}
	
	/**
	 * 通过状态来获取对应的服务器的信息
	 * @param int $status
	 */
	public static function getServersByStatus($status)
	{
		return DB::table('resource_servers')->where('status',$status)->get() ;
	}
	
	public static function getServerByNameAndPwd($name)
	{
		return DB::table('resource_servers')->where('name',$name)->get() ;
	}
}
