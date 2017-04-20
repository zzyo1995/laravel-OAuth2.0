<?php

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
class UserFileController extends \BaseController {
	public function __construct()
	{
		$this->beforeFilter('auth') ;
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Input::has('pageNum'))
		{
			$pageNum = Input::get('pageNum') ;
			Session::put('pageNum',$pageNum) ;
		}
		else 
			if(Session::has('pageNum'))
			{
				$pageNum = Session::get('pageNum') ;
			}
			else
				$pageNum = 5 ;
		$userFiles = UserFile::getUserFilesByUID(Auth::user()->id,$pageNum) ;
		$userFilesInfo = array() ;
		foreach($userFiles as $eachFile)
		{
			$tmpFile = array() ;
			$tmpFile['filename'] = $eachFile->fileName ;
			$resourceFile = ResourceFile::find($eachFile->fileId) ;
			$tmpFile['filetype'] = $resourceFile->type ;
			$tmpFile['filesize'] = $resourceFile->filesize ;
			$userFilesInfo[] = $tmpFile ;
		}
		
		return View::make('userFiles.index',array('userFiles'=>$userFilesInfo,"active"=>"displayUserFiles"))->with('filePaginates',$userFiles) ;
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return View::make('userFiles.create',array("active"=>"addUserFile")) ;
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$file = Input::file('filename') ;
		if($file == NULL)
		{
			return View::make('userFiles.create',array('errorInfo'=>'失败，没有选择文件！',"active"=>"addUserFile")) ;
		}
		if(!$file->isValid())
		{
			return View::make('userFiles.create',array('errorInfo'=>$file->getErrorMessage(),"active"=>"addUserFile")) ;
		}
		$fileSize = $file->getClientSize() ;
		$filename = $file->getClientOriginalName() ;
		$fileType = $file->getClientMimeType() ;
		
		$file->move(app_path().'/storage/uploads') ;
		$md5_name = md5_file(app_path().'/storage/uploads/'.$file->getFileName()) ;
		
		rename(app_path().'/storage/uploads/'.$file->getFileName(),app_path().'/storage/uploads/'.$md5_name) ;
		$resourceFile = new ResourceFile(array('file_str'=>$md5_name,'filesize'=>$fileSize,'type'=>$fileType)) ;
		$resourceFile->save() ;
		
		$fileInfo = ResourceFile::getResourceFileByMd5($md5_name) ;
		
		$userFile = UserFile::getUserFileByUidAndFileName(Auth::user()->id, $filename) ;
		if($userFile != NULL)
			return View::make('userFiles.create',array('fail'=>'文件资源'.$filename.'上传失败，文件已存在！',"active"=>"addUserFile")) ;
		$userFile = new UserFile(array('userId'=>Auth::user()->id,'fileId'=>$fileInfo->id,'fileName'=>$filename)) ;
		if($userFile->save())
			return View::make('userFiles.create',array('success'=>'文件资源'.$filename.'上传成功！',"active"=>"addUserFile")) ;
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
