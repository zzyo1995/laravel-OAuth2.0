<?php

use Illuminate\Support\Facades\Validator;
class UserProfileController extends \BaseController {

	
	public function __construct()
	{
		$this->beforeFilter('auth');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$userProfileResource = UserProfile::getResourceByUserId(Auth::user()->id) ;
		if(count($userProfileResource) == 0)
			return View::make('userProfiles.index',array("active"=>"userProfile")) ;
		else
			return View::make('userProfiles.index',array('resourceInfo'=>$userProfileResource[0],"active"=>"userProfile")) ;			
	}
	
	public function store()
	{
		$input = Input::all() ;
		
		$rules = array(
				'mobile'=>'digits:11' ,
				'address'=>'alpha_num',
				'age'=>'numeric'
		) ;
		
		$validator = Validator::make($input,$rules) ;
		
		if($validator->fails())
		{
			return View::make('userProfiles.index',array('resourceInfo'=>$userProfile,"active"=>"userProfile"))->withErrors($validator->errors()) ;
		}
		
		$userProfileInfo = new UserProfile($input) ;
		
		if($userProfileInfo->save())
		{
			return View::make('userProfiles.index',array('resourceInfo'=>$userProfileInfo,"active"=>"userProfile")) ;
		}
		else
		{
			return "user profile info insert error!" ;
		}
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$userProfileInfo = UserProfile::find($id) ;
		if($userProfileInfo == null)
		{
			return "userProfileInfo can not be found" ;
		}
		
		
		$input = Input::all() ;
		
		$rules = array(
			'mobile'=>'digits:11' ,
			'address'=>'alpha_num',
			'age'=>'numeric'
		) ;
		
		$validator = Validator::make($input,$rules) ;
		
		$userProfileInfo->mobile = $input['mobile'] ;
		$userProfileInfo->address = $input['address'] ;
		$userProfileInfo->age = $input['age'] ;
		
		if($validator->fails())
		{
			return View::make('userProfiles.index',array('resourceInfo'=>$userProfileInfo,"active"=>"userProfile"))->withErrors($validator->errors()) ;
		}
		
		
		
		$userProfileInfo->exists = true ;
		if($userProfileInfo->save())
		{
			return View::make('userProfiles.index',array('resourceInfo'=>$userProfileInfo,"active"=>"userProfile")) ;		
		}
		else
		{
			return "user profile info update error!" ;
		}
	}
}
