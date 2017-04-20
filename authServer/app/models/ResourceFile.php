<?php
use LaravelBook\Ardent\Ardent;
class ResourceFile extends Ardent{
	protected $table = "files" ;
	protected $fillable = ['file_str','filesize','type'] ;
	
	/**
	 * 通过文件的md5值获取文件信息
	 * @param string $file_str
	 */
	public static function getResourceFileByMd5($file_str)
	{
		return DB::table('files')->where('file_str',$file_str)->get()[0] ;
	}
}