<?php

use League\OAuth2\Server\Exception\InvalidAccessTokenException;
use League\OAuth2\Server\Storage\SessionInterface;
use Carbon\Carbon;

class ApiController extends BaseController {

	protected $session = null;

	public function __construct(SessionInterface $sessionObj)
	{
		$this->session = $sessionObj;
	}

	public function postRegister()
	{
		$userinfo = Input::all();
		$userinfo['group_id'] = 1;
		unset($userinfo['access_token']);
		$u = new User($userinfo);

		if($u->save()) {
		//save方法定义在vendor/laravelbook/ardent/src/LaravelBook/Ardent
			$response = array('status' => 'success');
			return Response::json($response);
		} else {
			$response = array(
				'status'        => 'failed',
				'error'         => 'validation failed',
				'error_message' => json_decode($u->errors()),
			);
			return Response::json($response, 422);
		}
	}

	public function postDeleteUser()
	{
		$userinfo = Input::all();
		$credentials = [
			'email' => $userinfo->email,
			'password' => $userinfo->password
		];
		$user = Auth::getProvider()->retrieveByCredentials(credentials);
		if ($user) {
			$user->delete();
			$response = [
				'status'	=> 'success'
			];
			return Response::json($response, 204);
		} else {
			$response = [
				'status'	=> 'failed',
				'error'		=> 'validation failed',
				'error_message'	=> json_decode($user->errors())
			];
			return Response::json($response, 400);
		}
	}

    public function postUpdateProfile()
    {
		//get user input information
    	$username = Input::get('username') ;
    	$email = Input::get('email');
    	$password = Input::get('password');
    	
    	$credentials = [
    	'email' => $email,
    	'password' => $password
    	];
    	
    	//valid user's information
    	if (!Auth::validate($credentials)) {
    		$ret = [
    		'status' => 'failed',
    		'error'  => 'invalid email or password'
    				];
    		return Response::json($ret, 422);
    	}
    	
    	//get user id
    	$id = DB::table('users')->where('email',$email)->pluck('id') ;//通过邮箱在users表里查找到用户ID
    	
    	$userInfo['id'] = $id ;
    	$userInfo['username'] = $username ;
    	$userInfo['email'] = $email ;
    	$userInfo['password'] = $password ;
    	$userInfo['password_confirmation'] = $password ;
    	
    	//initial user object
    	$user = new User($userInfo) ;
    	
    	
    	$user->exists = true ;
    	//$rule = array('username'=>'required|alphaNum|unique:users') ;
    	 
    	//update user's information
    	
    	if($user->updateUniques())
    	{
    		$ret = ['status' => 'success'];
    		return Response::json($ret);
    	}
    	else
    	{
    		$ret = [
    		'status'        => 'failed',
    		'error'         => 'update failed',
    		'error_message' => json_decode($user->errors()),
    		];
    		return Response::json($ret, 422);
    	}
    }

    public function postNewPassword()
    {
        $email = Input::get('email');
        $old_password = Input::get('old_password');
        $new_password = Input::get('password');
        $new_confirmation = Input::get('password_confirmation');
        $credentials = [
            'email' => $email,
            'password' => $old_password
        ];
        if (!Auth::validate($credentials)) {
            $ret = [
                'status' => 'failed',
                'error'  => 'invalid email or password'
            ];
            return Response::json($ret, 422);
        }
        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        $user->password = $new_password;
        $user->password_confirmation = $new_confirmation;
        if ($user->updateUniques()) {
            $ret = ['status' => 'success'];
            return Response::json($ret);
        } else {
            $ret = [
                'status'        => 'failed',
                'error'         => 'validation failed',
                'error_message' => json_decode($user->errors()),
            ];
            return Response::json($ret, 422);
        }
    }

    public function postTokenValidation()
    {
        try {
            ResourceServer::isValid();
	//在vendor/lucadegasperi/oauth2-server-laravel/src/LucaDegasperi/OAuth2Server/
	//OAuth2ServiceProvider.php中注册了该方法，调用了vendor/league/oauth2-server/src/League/OAuth2/Server/Resource类
        } catch (InvalidAccessTokenException $e) {
            return Response::json([
                'status' => 'invalid',
                'error_message' => $e->getMessage(),
            ]);
        }

        $ret = [
            'status' => 'valid',
        ];
        $ret['scopes'] = ResourceServer::getScopes();
        $ret['ownerType'] = ResourceServer::getOwnerType();
        if ($ret['ownerType'] == 'client') {
            $ret['owner'] = ResourceServer::getOwnerId();
        } elseif ($ret['ownerType'] == 'user') {
            $uid = ResourceServer::getOwnerId();
            $user = User::find($uid);
            $ret['owner'] = $user->toArray();

			//将邮箱转化成小写
			$ret['owner']['email'] = strtolower($user->email);

			if($ret['owner']['remember_token'] == null){
				$ret['owner']['remember_token'] = "";
			}
        }
        return Response::json($ret);
    }
//
//	function validateAccessToken($token, $client_id)
//	{
//		$result = $this->session->validateAccessToken($token);
//		if (!$result) {	// invalid token
//			return 1;
//		} else if ($result['client_id'] == $client_id) {	// revoke the token
//			DB::table('oauth_sessions')->where('id', $result['session_id'])->delete();
//			return 0;
//		} else {	// client id not match
//			return 2;
//		}
//	}

	function validateRefreshToken($token, $client_id)
	{
		$result = $this->session->validateRefreshToken($token, $client_id);
		if (!$result) {
			return 1;
		} else {	// revoke the token
			$this->session->removeRefreshToken($token);
			return 0;
		}
	}

	public function postRevokeToken() {
		$client_id = Input::get('client_id');//获取客户端ID
		if (!$client_id) $client_id = Request::server("PHP_AUTH_USER");
		$token = input::get('token');//获取token
		$hint = Input::get('token_type_hint');
		$ret = [];
		if ($hint == 'refresh_token') {//更新令牌
			$response = $this->validateRefreshToken($token, $client_id);
			if ($response != 0) $response = $this->validateAccessToken($token, $client_id);
		} else {
			$response = $this->validateAccessToken($token, $client_id);
			if ($response != 0) $response = $this->validateRefreshToken($token, $client_id);
		}
		switch ($response) {
		case 0:
			$ret['status'] = 'success';
			return Response::json($ret);
		case 1:
			$ret['error'] = 'unsupported_token_type';
			$ret['error_description'] = 'The authorization server does not support the revocation of the presented token type.';
			return Response::json($ret, 400);
		case 2:
			$ret['error'] = 'invalid_client';
			$ret['error_description'] = 'The token was not issued to the requesting client.';
			return Response::json($ret, 400);
		default:
			$ret['error'] = 'this_cannot_happen';
			return Response::json($ret, 500);
		}
	}
	
	/**
	 * 获取认证服务器上所有的用户信息
	 */
	public function getAllUsers()
	{
		$input = Input::all('resourcename','secret') ;
		
		//资源服务器输入要求
		$rules = array(
			'resourcename'=>'required',
			'secret'=>'required'
		) ;
		
		//验证资源服务器的输入
		$validator = Validator::make($input,$rules) ;
		
		if($validator->fails())
		{
			//验证失败
			return Response::json(
					array(
							'result'=>'error',
							'error_msg'=>'resourcename and secret is needed'
			)) ;
		}
		
		//获取资源服务器名所对应的信息
		$serverObj = AttachResource::getServerByNameAndPwd($input['resourcename']) ;
		
		if(count($serverObj) == 0)
		{
			//资源服务器名称不存在
			return Response::json(array(
				'result'=>'error',
				'error_msg'=>'resourcename does not exist!'
			)) ;
		}
		
		//验证资源服务器密码
		$result = Hash::check($input['secret'],$serverObj[0]->password) ;
		if(!$result)
		{
			//密码失败
			return Response::json(array(
				'result'=>'error',
				'error_msg'=>'secret error!'
			)) ;
		}
		
		if( $serverObj[0]->status !=1 )
		{
			//服务器状态验证失败，没有在审批成功状态
			return Response::json(array(
					'result'=>'error',
					'error_msg'=>'server status error!'	
			)) ;
		}
		
		$ret = array() ;
		
		$users = User::all() ;
		foreach($users as $user)
		{
			$temp = array() ;
			$temp['id'] = $user->id ;
			$temp['name'] = $user->name ;
			$temp['username'] = $user->username ;
			$temp['email'] = strtolower($user->email);
			$ret[] = $temp ;
		}
		
		return Response::json(array(
				'result'=>'success',
				'error_msg'=>'',
				'users'=>$ret
		)) ;
	}
	
	/**
	 * 处理客户端的心跳检测请求
	 */
	public function postHeartBeat()
	{
		$expireTime = Carbon::createFromTimestamp(time()-20*60);
		$oauth_session = DB::table('oauth_sessions')->where('owner_id', '=', ResourceServer::getOwnerId())->where('updated_at','>',$expireTime)->first() ;
		if($oauth_session == NULL)
		{
			//access_token已经过期，需要删除此access_token
			DB::table('oauth_sessions')->where('owner_id', '=', ResourceServer::getOwnerId())->delete();
			return Response::json(array('status'=>'fail','error_msg'=>'access_token is out of time')) ;
		}
		//更新数据库表oauth_serssions中updated_at为当前时间
		$time = Carbon::createFromTimestamp(time());
		DB::table('oauth_sessions')->where('owner_id', '=', ResourceServer::getOwnerId())->update(array('updated_at'=>$time)) ;
		
		return Response::json(array('status'=>'success')) ;
	}
	

    public function postCheckUserExistence() {
        $username = Input::get('username');
//        echo $username;
        $email = Input::get('email');
        // user BINARY keyword to ensure case sensitiveness
	$user = DB::table('users')->where('username', '=', $username)->where('email', '=', $email)->first();
        //$user = DB::select('SELECT * FROM oauthdb.users WHERE username = BINARY ? AND email = ?', [$username, $email]);
        if (!empty($user)) {
            return Response::json(['found' => 'true'], 200);
        } 
		else {
            return Response::json(['found' => 'false'], 200);
        }
    }
    
    /**
     * 通过access_token，获取access_token对应的用户信息
     */
    public function postGetUserInfo()
    {
    	//从输入中获取access_token
    	if(!Input::has('access_token'))
    	{
    		//输入不包含access_token，返回错误信息
    		return Response::json(array("status"=>"failed","error_msg"=>"access_token is required")) ;
    	}
    	
    	$access_token = Input::get('access_token') ;
    	//检验token值vendor/league/oauth2-server/src/League/OAuth2/Server/Storage/SessionInterface.php
    	$result = $this->session->validateAccessToken($access_token) ;
    	
    	if($result === false)
    	{
    		//access_token验证失败，返回错误信息
    		return Response::json(array("status"=>"failed","error_msg"=>"invalid access_token")) ;
    	}
    	
    	//access_token验证成功，返回用户信息
    	if($result['owner_type'] !== "user")
    	{
    		//非法的token所有者类型
    		return Response::json(array("status"=>"failed","error_msg"=>"invalid access_token owner type")) ;
    	}
    	
    	$userId = $result["owner_id"] ;

    	//通过用户id获取用户信息
	   	$userInfo = User::find($userId) ;

		$userPhoto = "default";
		$photoPath = base_path()."/public/img/";
		if(file_exists($photoPath.$userInfo->username))
			$userPhoto=$userInfo->username;
	
	   	return Response::json(array("status"=>"success","userId"=>$userInfo->id,"name"=>$userInfo->name,"username"=>$userInfo->username,
			"email"=>$userInfo->email,"photo"=>$userPhoto,"sex"=>$userInfo->sex,"address"=>$userInfo->address,"phone"=>$userInfo->phone)) ;
    }
    
    /**
     * 获取用户头像
     */
    public function getUserImage()
    {
    	if(Input::has('email'))
    	{
    		//参数正确
    		$email = Input::get('email') ;
    	}
    	else
    	{
    		//非法访问，需要提供参数
    		return Response::json(array("result"=>"failed","error_msg"=>"email is missing!")) ;
    	}
    	
    	$users = User::getUserInfoByEmail($email) ;
    	
    	if($users == null || count($users) == 0)
    	{
    		//通过email查找用户信息失败
    		return Response::json(array("result"=>"failed","error_msg"=>"email is invalid!")) ;
    	}
    	
    	$user = $users[0] ;
    	if(!$user->portrait)
    	{
    		//文件不存在
    		return Response::json(array("result"=>"failed","error_msg"=>"user image does not setting!")) ;
    	}
    	$filepath = base_path()."/public/img/".$user->portrait ;
    	
    	if(!file_exists($filepath))
    	{
    		//文件不存在
    		return Response::json(array("result"=>"failed","error_msg"=>"user image does not exist!")) ;
    	}
    	
    	$file = fopen($filepath,"rb") ;

    	header("Content-type: application/octet-stream") ;
    	header("Accept-Ranges: bytes") ;
    	header("Accept-Length: ".filesize($filepath)) ;
    	header("Content-Disposition: attachment;filename=".$user->name) ;
    	echo fread($file,filesize($filepath)) ;
    	fclose($file) ;
    	exit() ;
    	
    }
    
    /**
     * 文件上传接收表单
     */
    public function updageUserImage()
    {
    	//从输入中获取access_token
    	if(!Input::has('access_token'))
    	{
    		//输入不包含access_token，返回错误信息
    		return Response::json(array("result"=>"failed","error_msg"=>"access_token is required")) ;
    	}
    	 
    	$access_token = Input::get('access_token') ;
    	//检验token值
    	$result = $this->session->validateAccessToken($access_token) ;
    	 
    	if($result === false)
    	{
    		//access_token验证失败，返回错误信息
    		return Response::json(array("result"=>"failed","error_msg"=>"invalid access_token")) ;
    	}
    	 
    	//access_token验证成功，返回用户信息
    	if($result['owner_type'] !== "user")
    	{
    		//非法的token所有者类型
    		return Response::json(array("result"=>"failed","error_msg"=>"invalid access_token owner type")) ;
    	}
    	 
    	$userId = $result["owner_id"] ;
    	 
    	//通过用户id获取用户信息
    	$userInfo = User::find($userId) ;
    	
    	$file = Input::file('image') ;
    	 
    	if($file == null || !$file->isValid())
    	{
    		return Response::json(array("result"=>"failed","error_msg"=>"some error occured while file upload")) ;
    	}
    	
//     	if($file->mimeType != "image/jpeg" && $file->mimeType != "image/jpg" && $file->mimeType != "image/png")
//     	{
//     		//非法的文件格式
//     		return Response::json(array("result"=>"failed","error_msg"=>"invalid image type")) ;
//     	}
    	
    	$resulFilepath = base_path()."/public/img/".$userInfo->username ;
    	
    	//从临时目录移动文件到图片存储目录
    	$file->move(base_path()."/public/img/",$userInfo->username) ;
    	
		//对图片进行md5运算    	
    	$md5_string = md5_file($resulFilepath) ;
    	
    	//重命名文件为文件的md5值
    	if(!file_exists(base_path()."/public/img/".$md5_string))
    	{
    		rename($resulFilepath,base_path()."/public/img/".$md5_string) ;
    	}
    	$userInfo->portrait = $md5_string ;
	   	
	   	//默认规则中有密码和密码确认项匹配的规则，需要设置相同
	   	$userInfo->password_confirmation = $userInfo->password;
	   	if($userInfo->updateUniques())
	   	{
	   		return Response::json(array("result"=>"success")) ;
	   	}

	   	return Response::json(array("result"=>"failed","error_msg"=>$userInfo->errors())) ;
    }

	/**
	 * 更新用户的一些非必要信息
	 */
	public function updateUserInfo(){

		//从输入中获取access_token
		if(!Input::has('access_token'))
		{
			//输入不包含access_token，返回错误信息
			return Response::json(array("result"=>"failed","error_msg"=>"access_token is required")) ;
		}

		$access_token = Input::get('access_token') ;
		//检验token值
		$result = $this->session->validateAccessToken($access_token) ;

		if($result === false)
		{
			//access_token验证失败，返回错误信息
			return Response::json(array("result"=>"failed","error_msg"=>"invalid access_token")) ;
		}

		//access_token验证成功，返回用户信息
		if($result['owner_type'] !== "user")
		{
			//非法的token所有者类型
			return Response::json(array("result"=>"failed","error_msg"=>"invalid access_token owner type")) ;
		}

		$userId = $result["owner_id"] ;

		$user = User::find($userId);
		// 修改个人信息
		$user->name = Input::get('name');
		$user->password_confirmation = $user->password;
		if(Input::has('phone'))
			$user->phone = Input::get('phone') ;
		if(Input::has('sex'))
			$user->sex = Input::get('sex') ;
		if(Input::has('address'))
			$user->address = Input::get('address') ;

		if ($user->updateUniques()) {
			return Response::json(array('result'=>'success','error_msg'=>'update succeeded')) ;
		}

		return Response::json(array('result'=>'failed','error_msg'=>'update failed')) ;
	}

}
