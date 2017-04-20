<?php

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Guzzle\Http\Message\Response;
use Whoops\Example\Exception;
class ResourceController extends BaseController {

	public function __construct()
	{
		beforeFilter('auth') ;
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}
	
	/**
	 * post request to the url with input
	 * @param unknown $url
	 * @param unknown $post_data
	 * @return unknown
	 */
	public function postData($url,$post_data)
	{
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_HEADER,0);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$data = curl_exec($ch);
		curl_close($ch) ;
		$result = json_decode($data,true);
		return $result;
	}
	
	public function getAllAuthUsers()
	{
		$url = 'https://domain/resources/getAllUsers' ;
		$input = array('resource_name'=>'resource_test','password'=>'123456') ;
		
		$result = $this->postData($url, $input) ;
		
		if($result['result'] == 'invalid')
		{
			//resource server auth error
			return View::make('getUsersResult',array('result'=>$result)) ;
		}
		
		$users = $result['users'] ;
		foreach($users as $eachuser)
		{
			try{
				User::updateUserInfo($eachuser['id'], $eachuser['email'], $eachuser['username']) ;
				return View::make('getUserResult',array('result'=>'valid')) ;
			}catch(Exception $e)
			{
				//update user info to database error
				return View::make('getUserResult',array('result'=>array('result'=>'error','error'=>'update user info to database error!'))) ;
			}
		}
		
	}
	
	/**
	 * get user info,only grant_type is user can access this api
	 */
	public function getUserDetail()
	{
		//get input
		$access_token = Input::get('access_token') ;
		$client_id = Input::get('access_token') ;
		
		$res = array() ;
		
		//valide input
		if($access_token == NULL)
		{
			$res['result'] = 'error' ;
			$res['error'] = 'access_token must not be null' ;
			return Response::json($res) ;
		}
		if($client_id == NULL)
		{
			$res['result'] = 'error' ;
			$res['error'] = 'client_id must not be null' ;
			return Response::json($res) ;
		}
		
		//post token validation to auth server
		$token_validate = $this->postData('https://domain/api/token-validation', array('access_token'=>$access_token,'client_id'=>$client_id,'resource_name'=>'resource_test','password'=>'123456')) ;
		
		if($token_validate['status'] == 'invalid')
		{
			//token is invalid
			$res['result'] = $token_validate['status'] ;
			$res['error'] = $token_validate['error_message'] ;
			return Response::json($res) ;
		}
		else
		{
			//token is valid
			if($token_validate['owner_type'] != 'user')
			{
				//invalid grant_type
				$res['result'] = 'invalid' ;
				$res['error'] = 'invalid grant_type' ;
				return Response::json($res) ;
			}
			else
			{
				$userInfo = User::getUserInfoByUserAuthID($token_validate['owner_id']) ;
				if($userInfo == NULL)
				{
					//get user info error
					$res['result'] = 'invalid' ;
					$res['error'] = 'get user in resource server error' ;
					return Response::json($res) ;
				}

				$resourceInfo = Resource::getResourceByUserId($userInfo->id) ;
				
				$res['status'] = 'valid' ;
				if($resourceInfo == NULL)
				{
					//user has no resource
					$res['resource_info'] = '' ;
					return Response::json($res) ;
				}
				$res['resource_info']['username'] = $userInfo->username ;
				$res['resource_info']['mobile'] = $resourceInfo->mobile ;
				$res['resource_info']['address'] = $resourceInfo->address ;
				$res['resource_info']['email'] = $userInfo->email ;
				
				return Response::json($res) ;
			}
		}
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
