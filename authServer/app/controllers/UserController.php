<?php
include 'send.php';
use Illuminate\Support\Facades\Input;
class UserController extends BaseController {

    public function __construct()
    {
        $this->beforeFilter('auth', array('only' => array('edit','show','create')));//在访问edit、show之前必须经过auth过滤器
        $this->beforeFilter('user.admin', array('only' => 'index'));
    }

    public function index()
    {
		if ('sysadmin' != Auth::user()->username && 'admin' != Auth::user()->username)
		{
			return Response::json(array('result'=>'failed','error_msg'=>'You do not have access to this page'));
		}
        $deleteButton = 'hide';//隐藏删除按钮
        if (Auth::check()) {
            $privileges = Auth::user()->group->getPrivileges();
            if (in_array('users', $privileges))//如果当前用户是管理员，则使能删除按钮
                $deleteButton = 'show';
        }

        //$allUsers = User::getAllusers();//提取用户信息(翻页)
		$allRoles = Role::getAllRoles();
        $allUsers = User::all();//提取用户信息(不翻页)
        $activeUserRecs = ActiveUser::all();//提取在线用户信息
        $activeUsers = array();
        $clientActiveUsers = User::getClientActiveUsers() ;// 获取客户端在线用户信息
        
        foreach ($activeUserRecs as $auc) {
            $activeUsers[] = $auc->user;
        }
        return View::make('users.index', array('nav_active' => 'users', 'all' => $allUsers, 'roles' => $allRoles, 'active' => $activeUsers,'clientActiveUsers' => $clientActiveUsers, 'delete' => $deleteButton));//转向用户管理页面
    }
    
	public function create()
	{
		$allRoles = Role::getAllRoles();
		$groups = DB::table('project_group')->get();
		return View::make('users.create', array('roles' => $allRoles, 'groups' => $groups));//转至用户注册页面
	}

	public function store()
	{
		$userinfo = Input::all();//取得输入的信息
		$userinfo['group_id'] = 1;
		$pgid = $userinfo['project_group'];
		unset($userinfo['project_group']);
		$u = new User($userinfo);//注册新用户
		
		if($u->save()) {
			DB::table('project_group_member')->insert(
  				['user_id' => $u->id, 'project_group_id' => $pgid, 'created_at' => $u->created_at, 'updated_at' => $u->updated_at]
			);
			$cpid = DB::table('project_group')->where('id', $pgid)->pluck('company_id');
			DB::table('company_users')->insert(
  				['user_id' => $u->id, 'company_id' => $cpid, 'state' => 1, 'created_at' => $u->created_at, 'updated_at' => $u->updated_at]
			);
			//注册成功发送邮件
			$data = array('email' => $u->email);
			Mail::send('emails.register', $data, function($message) use ($data) {
				$message->to($data['email'])->subject('网络账号注册成功');
			});
			
			send2rabbitmq('localhost', 'secfile', '{"action":"RegistUser","user_id":"'.$u->id.'","user_name":"'.$u->username.'","user_email":"'.$u->email.'","user_category":"'.$u->user_category.'","project_group_id":"'.$pgid.'"}');
		//save方法定义在vendor/laravelbook/ardent/src/LaravelBook/Ardent/Ardent.php
			return Redirect::route('users.show', $u->id) //如果保存成功，重定向到users.show
				->with('success', '用户已注册。');
		}//route方法定义在/vendor/laravel/framework/src/Illuminate/Routing/Redirector.php中

    		return Redirect::route('users.create')//重新加载用户注册页面
    			->withInput()
    			->withErrors($u->errors());
	}

	public function show($id)//查看用户信息
	{
        $user = User::find($id);
        $com = is_numeric($id) ;
        //判断输入是否正确，输入必须是数字
        if ($user == null || $com == false)
            App::abort(415);
        $currentId = Auth::check()? Auth::user()->id : -1;
        
        //添加用来判断只有管理员才能访问其余用户信息
		$currentUser = User::find($currentId) ;
		$group = $currentUser->group ;
	
		if(strstr($group->privileges,"users") === false)
		{
			//用户是非管理员，没有查看其他用户的权限
			$currentUser->deleteExpiredTokens();
			$sessions = $currentUser->getSessions();
			return View::make('users.show', array('user' => $currentUser, 'currId' => $currentId, 'sessions' => $sessions,'error'=>'没有权限查看其余用户信息')) ;
		}
		
		$user->deleteExpiredTokens();
		$sessions = $user->getSessions();
		return View::make('users.show', array('user' => $user, 'currId' => $currentId, 'sessions' => $sessions)) ;
	}

	public function edit($id)
	{
        // 已使用filter保证用户已登录
        if (Auth::user()->id != $id)
            return Redirect::route('users.show', $id);

        $user = User::find($id);
		return View::make('users.edit', array('user' => $user));
	}

	public function update($id)
	{
		$user = User::find($id);
        if (Input::get('mode') == 'update-profile') {
            // 修改个人信息
            $user->name = Input::get('name');
            $user->password_confirmation = $user->password;
            if(Input::has('phone'))
            	$user->phone = Input::get('phone') ;
            if(Input::has('sex'))
            	$user->sex = Input::get('sex') ;
            if(Input::has('address'))
            	$user->address = Input::get('address') ;
            if(Input::has('remark'))
            	$user->remark = Input::get('remark') ;
            if(Input::has('room_number'))
            	$user->room_number = Input::get('room_number') ;
            if(Input::has('extension_number'))
            	$user->extension_number = Input::get('extension_number') ;
        } else {
            // 修改密码
            $credentials = array('email' => $user->email, 'password' => Input::get('oldpassword'));

            $privileges = Auth::user()->group->getPrivileges();//获取当前用户的权限
            if (Auth::validate($credentials) || in_array('admin', $privileges)) {//若当前为管理员，则无需验证旧密码
                $user->password = Input::get('password');
                $user->password_confirmation = Input::get('password_confirmation');
            } else {    // 旧密码错误
                return Response::json(array('result'=>'failed','error_msg'=>'1密码错误')) ;
            }
        }
		if ($user->updateUniques()) {
			send2rabbitmq('localhost', 'secfile', '{"action":"UpdateUser","user_id":"'.$user->id.'","user_name":"'.$user->username.'","name":"'.$user->name.'","user_email":"'.$user->email.'","user_phone":"'.$user->phone.'","user_sex":"'.$user->sex.'","user_address":"'.$user->address.'"}');
			return Response::json(array('result'=>'success','error_msg'=>'2用户信息已更新成功！')) ;
		}

        //$e = $user->errors();
		return Response::json(array('result'=>'failed','error_msg'=>'3用户信息已更新失败！'.$user->errors())) ;
	}

	public function destroy($id)//删除用户
	{
		// Need Auth
	DB::table('company_users')->where('user_id', $id)->delete();
	DB::table('project_group_member')->where('user_id', $id)->delete();
        $user = User::find($id);
        $user->delete();
        return Redirect::route('users.index');
	}

	public function revokeToken($id)
	{
		$session_id = Input::get('session_id');
		$session = DB::table('oauth_sessions')
			->where('id', $session_id)
			->first();
		if ($session->owner_type == 'user' && $session->owner_id == $id) {
			DB::table('oauth_sessions')
				->where('id', $session_id)
				->delete();
		}
		return Redirect::route('users.show', $id);
	}

    public function newPassword($id)
    {
        $user = User::find($id);
        return View::make('password.new', array('user' => $user));
    }

	public function getChangeUserInfo()
	{	
		$id = Input::get('id');
		$username = Input::get('username');
		$email = Input::get('email');
		$user_category = Input::get('user_category');
		$roles = Role::all();
		return View::make('users.changeInfo', array('nav_active' => 'users', 'id' => $id, 'username' => $username, 'email' => $email, 'user_category' => $user_category, 'roles' => $roles));
	}
	
	public function postChangeUserInfo()
	{
		$changMark = 0;
		$userInfo = Input::all();
		$subInfo = array(
			'username' => $userInfo['username'],
			'email'    => $userInfo['email'],
			'user_category' => $userInfo['user_category'],
		);
		$rules = array(
			'username' => 'required|alphaNum',
			'email'    => 'required|email',
			'user_category' => 'required',
		);
		
		$validator = Validator::make($subInfo, $rules);
		if ($validator->fails()) {    //验证未通过
			return Redirect::to('manage/changeUserInfo')
				->withInput()
				->withErrors($validator->errors());
		}

		if (isset($userInfo['email']) && ($userInfo['email'] != $userInfo['old_email'])) {
			User::changeInfo($userInfo['id'], 'email', $userInfo['email']);
			$changMark++;
		}
		if (isset($userInfo['username']) && ($userInfo['username'] != $userInfo['old_username'])) {
			User::changeInfo($userInfo['id'], 'username', $userInfo['username']);
			$changMark++;
		}
		if (isset($userInfo['user_category']) && ($userInfo['user_category'] != $userInfo['old_user_category'])) {
			User::changeInfo($userInfo['id'], 'user_category', $userInfo['user_category']);
			$changMark++;
		}
		if ($changMark > 0) {
			$user = User::find($userInfo['id']);
			send2rabbitmq('localhost', 'secfile', '{"action":"UpdateUser","user_id":"'.$user->id.'","user_name":"'.$user->username.'","name":"'.$user->name.'","user_email":"'.$user->email.'","user_phone":"'.$user->phone.'","user_sex":"'.$user->sex.'","user_address":"'.$user->address.'","user_category":"'.$user->user_category.'"}');
		}
		return Redirect::to('admin/users');
	}
    /**
     * web端更新用户头像
     */
    public function saveFaceImage()
    {
    	
    	$input = Input::all() ;
    	
    	//最后的图片应该显示像素值
    	$img_w = 300 ;
    	$img_h = 300 ;
    	$img_quality = 90 ;
    	$filepath = base_path()."/public".$input['path'] ;

    	//取出图片的实际大小
    	list($width,$height,$type,$attr)  = getimagesize($filepath);
    	
    	
    	//计算截取的图片的实际大小
    	$realWidth = round($input['w']*$width/300,0) ;
    	$realHeight = round($input['h']*$height/400,0) ;
    	
    	//计算出截取的图片的起始坐标
    	$x_len = round($input['x']*$width/300,0) ;
    	$y_len = round($input['y']*$height/400,0) ;

    	//生成临时文件，用户存放图片内容
    	$tmpfilename = tempnam(base_path().'/public/img', Auth::user()->id) ;
    	
    	switch ($type)
    	{
    		case 2 :
    			//jpg
    			$img_r = imagecreatefromjpeg($filepath) ;
    			$dst_r = imagecreatetruecolor($img_w, $img_h) ;
    			imagecopyresampled($dst_r, $img_r, 0, 0, $x_len, $y_len,$img_w,$img_h, $realWidth, $realHeight) ;
    			imagejpeg($dst_r,$tmpfilename,$img_quality) ;
    			imagedestroy($img_r) ;
    			imagedestroy($dst_r) ;
	    		break;
    		case 3:
    			//png
    			$img_r = imagecreatefrompng($filepath) ;
    			imagepng($img_r,$tmpfilename) ;
    			$dst_r = imagecreatetruecolor($img_w, $img_h) ;
    			imagesavealpha($img_r, true) ;
    			imagealphablending($dst_r, false) ;
    			imagesavealpha($dst_r, true) ;
    			imagecopyresampled($dst_r, $img_r, 0, 0, $x_len, $y_len,$img_w,$img_h, $realWidth, $realHeight) ;
    			imagepng($dst_r,$tmpfilename) ;
    			imagedestroy($dst_r) ;
    			imagedestroy($img_r) ;
    			break ;
    		default:
    			return Response::json(array("result"=>"failed","error_msg"=>"unsupport image type")) ;
    	}

		//修改文件权限
		chmod($tmpfilename,0755) ;

    	//对图片进行md5
	   	$md5_str = md5_file($tmpfilename) ;
	   	//对文件进行重命名
	   	rename($tmpfilename,base_path()."/public/img/".$md5_str) ;
    	
	   	$user = User::find(Auth::user()->id) ;
	   	
	   	$user->portrait = $md5_str ;
	   	
	   	//默认规则中有密码和密码确认项匹配的规则，需要设置相同
	   	$user->password_confirmation = $user->password;



	   	if($user->updateUniques())
	   	{
			send2rabbitmq('localhost', 'secfile', '{"action":"UpdateUserFaceImage","user_name":"'.$user->username.'","user_email":"'.$user->email.'","user_portrait":"'.$user->portrait.'"}');
	   		return Response::json(array("result"=>"success")) ;
	   	}

	   	return Response::json(array("result"=>"failed","error_msg"=>$user->errors())) ;
       }
       
       /**
        * web端通过ajax上传文件
        */
       public function userImageUploadFromWeb()
       {
	       	//获取上传的文件
	       	$file = Input::file('filename') ;

	       	if($file == NULL)
	       	{
	       		return Response::Json(array('result'=>'failed','error_msg'=>'上传图片失败，未选择图片！')); ;
	       	}
	       	if(!$file->isValid())
	       	{
	       		return Response::Json(array('result'=>'failed','error_msg'=>'上传图片失败，非法图片！'));
	       	}       
	       	
	       	$userid = Auth::user()->id ;
	       	$user = User::find($userid) ;
	       	$file->move(base_path().'/public/img/',$user->username) ;
	       	
	       	list($width,$height,$type,$attr)  = getimagesize(base_path().'/public/img/'.$user->username);
	       	
	       	//判断文件是否是支持的图片格式
	       	if(getimagesize(base_path().'/public/img/'.$user->username) == false)
	       	{
	       		return Response::json(array("result"=>"failed","error_msg"=>"上传图片失败，上传了不支持的文件格式！")) ;
	       	}
	       	
	       	$ret = array("result"=>"success","filepath"=>"/img/".$user->username,"width"=>$width,"height"=>$height) ;
	       	return	Response::json($ret);
       }
       
		public function getSearchUsers()
		{  
			$export = Input::get('export');
			$id = Input::get('id');
			$user_id = Auth::id();
			$user_name = Input::get('name');
			$type = Input::get('type');
			
			if (!isset($user_name)) {
				$user_name = Input::get('dname');
			}
   			if (!isset($user_name)) {
				$companyUsers = CompanyUser::getAllUserByCmpId($id);
				$companyUsersE = CompanyUser::getAllUserByCmpId2($id);
			} else {

				$companyUsers = CompanyUser::getAllUserByCon($user_name, $id, $type);
				$companyUsersE = CompanyUser::getAllUserByCon2($user_name, $id, $type);
			}
			foreach($companyUsers as $companyUser){
			$ugroup = DB::table('project_group_member')
		            ->join('project_group', 'project_group.id', '=', 'project_group_member.project_group_id')
		            ->where('project_group_member.user_id', $companyUser->user_id)
					->select('name')->get();
			$arr = array();
			foreach ($ugroup as $k => $v) {
			
				$arr[] = $v->name;
			}
			$gp = implode("|", $arr);
			$tp = User::find($companyUser->user_id);
			$tp->group_name = $gp;
			$allUser[] = $tp;

			}
			if(!isset($allUser)){
				$allUser = -1;
			}
			if ($export == 'yes') {
				ExcelController::export($companyUsersE);
			}
			return View::make('company.contacts', array('id' => $id, 'type' => $type, 'dname' => $user_name, 'allUser' => $allUser, 'companyUsers' => $companyUsers));
		}       
}
