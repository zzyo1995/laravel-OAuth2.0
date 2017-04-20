<?php
use League\OAuth2\Server\Util\RedirectUri ;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use League\OAuth2\Server\Resource;
use Illuminate\Auth\Guard;
use Illuminate\Support\Facades\Redirect;
class ResourceInfoController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('users.getUsers',array("active"=>"getUsers")) ;
	}
	
	/**
	 * 提供ajax后台获取资源服务器信息接口
	 */
	public function getResourceInfo()
	{
		//获取资源服务器信息
		$resourceInfo = ResourceInfoModel::getResourceInfo() ;
		if($resourceInfo == NULL)
		{
			return Response::json(array('result'=>'error','error_msg'=>'resource info does not exist')) ;
		}
		$ret = array('result'=>'success','name'=>$resourceInfo->name,'server_ip'=>$resourceInfo->server_ip) ;
		return Response::json($ret) ;
	}
	
	/**
	 * 保存设置资源服务器信息到数据库中
	 */
	public function saveResourceInfo()
	{
		//获取输入，并初始化资源服务器model对象
		$input = Input::only('server_ip','source_name','password','password_confirmation') ;
		
		$rules = array(
				'server_ip'=>'required',
				'source_name'=>'required|min:4',
				'password'=>'required|min:6|confirmed',
				'password_confirmation'=>'required'
		) ;
		
		$validator = Validator::make($input,$rules) ;
		if($validator->fails())
		{
			return View::make('users.getUsers',array('fail'=>'资源服务器信息设置失败！'))->withErrors($validator->errors()) ;
		}
		
		$resourceInfo = ResourceInfoModel::getResourceInfo() ;
		if($resourceInfo == NULL)
		{
			//数据库中不存在对应记录
			$resourceInfo = new ResourceInfoModel(array('server_ip'=>$input['server_ip'],'name'=>$input['source_name'],'password'=>$input['password'])) ;
			$resourceInfo->exists = false ;
		}
		else
		{
			//存在对应记录，只需要更新资源服务器信息即可
			$id = $resourceInfo->id ;
			$resourceInfo = new ResourceInfoModel(array('server_ip'=>$input['server_ip'],'name'=>$input['source_name'],'password'=>$input['password'])) ;
			$resourceInfo->id = $id ;
			$resourceInfo->exists = true ;
			$resourceInfo->name = $input['source_name'] ;
			$resourceInfo->password = $input['password'] ;
		}
		//保存数据
		if($resourceInfo->save())
		{
			return View::make('users.getUsers',array('success'=>'资源服务器信息设置成功！')) ;
		}
		else
		{
			return View::make('users.getUsers',array('fail'=>'资源服务器信息设置失败！'))->withErrors($resourceInfo->errors()) ;
		}
	}
	
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
	
	/**
	 * 获取所有的用户信息
	 */
	public function getAllUsers()
	{
		$resourceInfo = ResourceInfoModel::getResourceInfo() ;
		$url = 'https://'.$resourceInfo->server_ip.'/resources/getAllUsers' ;
		
		if($resourceInfo == NULL)
			return Response::json(array("result"=>"error","error_message"=>"resource info does not exist")) ;
		
		$input = array('resourcename'=>$resourceInfo->name,'secret'=>$resourceInfo->password) ;
		$result = $this->postData($url, $input) ;
	
		if($result['result'] == 'invalid')
		{
			//resource server auth error
			return Response::json(array("result"=>"error")) ;
		}
	
		$users = $result['users'] ;
		foreach($users as $eachuser)
		{
			User::updateUserInfo($eachuser['id'], $eachuser['email'], $eachuser['username']) ;
		}
		return Response::json(array("result"=>"success")) ;
	}
	
	/**
	 * 进行网络账号登陆功能，跳转到网络账号认证服务器
	 */
	public function netLogin()
	{
		$params = array('client_id'=>'testid','redirect_uri'=>'https://172.29.10.174/netGetAuthCode','response_type'=>'code') ;
		$redirect_uri = RedirectUri::make('https://172.29.10.159/oauth/authorize',$params,'?') ;
		return Redirect::to($redirect_uri) ;
	}
	
	/**
	 * 获取认证服务器端返回的授权码
	 */
	public function getAuthCode()
	{
		/**
			分为3种返回值：
			1. 用户成功授权，则返回值为code=....&state=...
			2. 用户取消授权，则返回值为error=...&error_message=...
			3. 上一步输入有错，则不会出现在这个页面中
		 */
		$params = Input::all();
		
		//对返回值进行判断
		if(!isset($params['code']))
		{
			//认证服务器返回用户未成功进行授权
			if(isset($params['error']))
			{
				return Response::json(array("error"=>$params["error"],"error_msg"=>$params["error_message"])) ;
			}

			//服务器端返回信息有误
			return Response::json(array("error"=>"auth server error","error_msg"=>"auth server response error")) ;
		}
		
		$auth_code = $params['code'] ;
		
		//post信息给access_token接口，实现获取用户token
		$input = array(
				'grant_type'=>'authorization_code',
				'client_id'=>'testid',
				'client_secret'=>'testsecret',
				'redirect_uri'=>'https://172.29.10.174/netGetAuthCode',
				'code'=>$auth_code
			) ;

		$result = $this->postData("https://172.29.10.159/oauth/access_token", $input) ;
		/**
		 * 成功返回{{"access_token":"11VvWOq7WwZ549sueZWNXcgrMbjVjdsmcESHABnV","token_type":"Bearer","expires":1411980804,"expires_in":3600,"refresh_token":"yVxyThTuTLkC8k1fNUgKrInshurpF35de1XDkqCC"}}
		 */
		//对result结果进行解析 
		if(!isset($result['access_token']))
		{
			//获取access_token输入有错
			return Response::json($result) ;
		}
		
		$access_token = $result['access_token'];
		
		//通过access_token获取服务器端用户信息
		$userInfoInput = array('access_token'=>$access_token) ;
		$getUserResult = $this->postData("https://172.29.10.159/api/userInfo", $userInfoInput) ;
		
		if($getUserResult == NULL)
		{
			//连接服务器失败，无法发送消息
			return Response::json(array("status"=>"failed","error_msg"=>"connect to server error!")) ;
		}
		if($getUserResult["status"] != "success")
		{
			//服务器获取用户信息失败，返回错误信息
			return Response::json($getUserResult) ;
		}
		//对用户信息进行解析
		$userInfo = User::getUserInfoByUserAuthID($getUserResult['userId']) ;
		if($userInfo == NULL)
		{
			//连接服务器失败，无法发送消息
			return Response::json(array("status"=>"failed","error_msg"=>"get user info error!")) ;
		}
		
		$userInfo = $userInfo[0] ;
		$curUser = new User(array('id'=>$userInfo->id,'username'=>$userInfo->username,'email'=>$userInfo->email,'password'=>$userInfo->password)) ;
		
		$currentUser = Auth::loginUsingId($userInfo->id) ;
		return Redirect::to(URL::to('/')) ;
	}
}