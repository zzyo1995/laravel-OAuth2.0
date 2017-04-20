<?php
use LucaDegasperi\OAuth2Server\Repositories\FluentSession;
use Carbon\Carbon;
use Guzzle\Http\Message\Header;

date_default_timezone_set('Asia/Shanghai');
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::post('excel/export/{id}', 'ExcelController@export');
Route::get('switchUser', ['as' => 'switchUser', 'uses' => 'AuthController@switchUser']);
// Home Page
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@showWelcome']);

// Login
Route::get('login', array('https', 'uses' => 'AuthController@showLogin'));//转至登录页面
Route::post('login', array('https', 'uses' => 'AuthController@postLogin'));//处理登录信息
// Logout
Route::get('logout', array('uses' => 'AuthController@getLogout'));//登出

// User Register
Route::get('register', array('https', 'uses' => 'UserController@create'));//转至注册页面
Route::get('client-manage', array('https', 'uses' => 'ClientController@manage'));//客户端管理
Route::get('client-register', array('https', 'uses' => 'ClientController@create'));//客户端注册

Route::group(
	array('prefix' => 'api'),
	function () {
		Route::post(
			'register',
			[
				'https',
				'before' => 'oauth:user|oauth-owner:client',
				'uses' => 'ApiController@postRegister'
			]
		);
		/*
		Route::post('user-delete', [
			'https',
			'before' => 'oauth:user|oauth-owner:client',
			'uses'   => 'ApiController@postDeleteUser'
		]);
		 */
		Route::post(
			'token-validation',
			[
				'https',
				'uses' => 'ApiController@postTokenValidation'
			]
		);
		Route::get('auth-login', array('https', 'uses' => 'AuthController@authLogin'));//网络帐号授权登陆
		Route::post(
			'update-profile',
			[
				'https',
				'before' => 'oauth:user',
				'uses' => 'ApiController@postUpdateProfile'
			]
		);
		Route::post('update-user', array('https', 'uses' => 'ApiController@updateUserInfo'));
		Route::post(
			'new-password',
			[
				'https',
				'before' => 'oauth:user',
				'uses' => 'ApiController@postNewPassword'
			]
		);
		Route::post(
			'heartBeat',
			array('https', 'before' => 'oauth:user|oauth-owner:user', 'uses' => 'ApiController@postHeartBeat')
		);
		Route::post(
			'check-user-existence',
			[
				'https',
				'before' => 'oauth:user|oauth-owner:client',
				'uses' => 'ApiController@postCheckUserExistence'
			]
		);
		Route::post('userInfo', array('https', 'uses' => 'ApiController@postGetUserInfo'));//用token换取用户信息
	}
);

include('routes/api-v1.php');
//Route::post('users',array('https', 'uses' => 'UserController@store'));
Route::resource('users', 'UserController');//资源控制器处理（响应注册页面表单提交事件）（已登录用户查看信息）

Route::get(
	'users',
	function () {
		return Redirect::to('admin/users');
	}
);

/**用户信息修改新增接口*/
Route::post('userDetial/saveUserImage', array('https', 'uses' => 'UserController@saveFaceImage'));
Route::post('userDetial/userImageUploadFromWeb', array('https', 'uses' => 'UserController@userImageUploadFromWeb'));
Route::post('userDetial/getUserImage', array('https', 'uses' => 'ApiController@getUserImage'));
Route::post(
	'userDetial/updateUserImage',
	array('https', 'before' => 'oauth:user|oauth-owner:user', 'uses' => 'ApiController@updageUserImage')
);


Route::resource('clients', 'ClientController');//响应客户端注册页面表单提交事件
Route::get(
	'clients',
	function () {
		return Redirect::to('admin/clients');
	}
);

//修改密码
Route::get(
	'users/{id}/new-password',
	array(
		'before' => 'user.current',
		'uses' => 'UserController@newPassword',
		'as' => 'users.new-password'
	)
);
//系统管理员重置用户密码
Route::get(
	'sysadmin/reset-password/{id}',
	array(
		'before' => 'user.admin',
		'uses' => 'UserController@newPassword',
		'as' => 'users.new-password'
	)
);
//管理员重置用户密码
Route::get(
	'admin/reset-password/{id}',
	array(
		'before' => 'user.admin',
		'uses' => 'UserController@newPassword',
		'as' => 'users.new-password'
	)
);
//重置密码
Route::get('password/remind', 'RemindersController@getRemind');
Route::post('password/remind', 'RemindersController@postRemind');//提交表单，发送邮件
Route::get('password/reset/{token}', 'RemindersController@getReset');//得到重置密码页面
Route::post('password/reset', 'RemindersController@postReset');

Route::get(
	'testredirecturi/{code}',
	function ($code) {
		return 'redirected! code: '.$code;
	}
);

Route::get('admin/manage', ['uses' => 'AdminController@home']);//转向admin的管理页面 首页
Route::get('admin/users', ['uses' => 'UserController@index']);//转向admin的用户管理页面
Route::get('admin/clients', ['uses' => 'ClientController@index']);//客户端管理页面

Route::get('admin/groups', array('https', 'uses' => 'GroupController@index'));//组管理
Route::get('admin/group-create', array('https', 'uses' => 'GroupController@create'));//创建新用户组
Route::post('admin/remove_groupuser', array('https', 'uses' => 'GroupController@removeGroupUser'));
Route::post('admin/add_groupuser', array('https', 'uses' => 'GroupController@addGroupUser'));
Route::get('admin/company', ['uses' => 'CompanyController@getCheck']);
Route::get('admin/applier', ['uses' => 'CompanyUserController@getCheckApplier']);
Route::post('admin/checkApply', ['uses' => 'CompanyUserController@checkApplyAdmin']);

Route::get('sysadmin/manage', ['uses' => 'AdminController@syshome']);//转向sysadmin的管理页面 首页
Route::get('sysadmin/users', ['uses' => 'UserController@index']);//转向sysadmin的用户管理页面
Route::get('sysadmin/clients', ['uses' => 'ClientController@index']);//客户端管理页面
Route::get('sysadmin/company', ['uses' => 'CompanyController@getCheck']);
Route::get('sysadmin/applier', ['uses' => 'CompanyUserController@getCheckApplier']);
Route::post('sysadmin/checkApply', ['uses' => 'CompanyUserController@checkApplyAdmin']);//此处是触发同意和拒绝的函数

Route::get('safeadmin/manage', ['uses' => 'AdminController@safehome']);//转向safeadmin的管理页面 首页
Route::get('safeadmin/secfile', ['uses' => 'ClientController@jurisSecfile']);//转向safeadmin的secfile页面
Route::get('safeadmin/gitlab', ['uses' => 'ClientController@jurisGitlab']);//转向safeadmin的gitlab页面
Route::get('safeadmin/riochat', ['uses' => 'ClientController@jurisRiochat']);//转向safeadmin的riochat页面
Route::post('safeadmin/change_juris/{id}/{cname}', ['uses' => 'ClientController@changeJuris']);
Route::post('safeadmin/add_juris_user/{cname}', ['uses' => 'ClientController@addJurisUser']);
Route::post('safeadmin/remove_juris_user/{id}/{cname}', ['uses' => 'ClientController@removeJurisUser']);

Route::get('auditadmin/manage', ['uses' => 'AdminController@audithome']);//转向auditadmin的管理页面 首页

Route::resource('groups', 'GroupController');//响应组管理页面
Route::get('user/getSearchUsers', 'UserController@getSearchUsers');
/*****权限管理添加********/
Route::get('admin/scopes', array('https', 'uses' => 'ScopeController@index'));//权限管理页面
Route::post('scope/update', array('https', 'uses' => 'ScopeController@updateScopeInfo'));
Route::post('scope/delete', array('https', 'uses' => 'ScopeController@deleteScopeInfo'));//删除权限类型
Route::post('scope/add', array('https', 'uses' => 'ScopeController@addScopeInfo'));
/******角色管理**********/
Route::get('admin/roles', ['uses' => 'RoleController@index']);//角色管理页面
Route::post('role/update', array('https', 'uses' => 'RoleController@updateRoleInfo'));
Route::post('role/delete', array('https', 'uses' => 'RoleController@deleteRoleInfo'));
Route::post('role/deleteScope', array('https', 'uses' => 'RoleController@deleteScope'));
Route::post('role/add', array('https', 'uses' => 'RoleController@addRoleInfo'));
Route::get('role/showScopes', ['uses' => 'RoleController@showScopes']);
Route::get('role/add', ['uses' => 'RoleController@addRole']);
Route::post('role/addScope', array('https', 'uses' => 'RoleController@addScope'));
Route::get('admin/project_roles', ['uses' => 'ProjectRoleController@index']);//组内角色管理页面
Route::get('project_role/add', ['uses' => 'ProjectRoleController@getAddRole']);
Route::post('project_role/add', array('https', 'uses' => 'ProjectRoleController@postAddRole'));
Route::get('project_role/changeInfo/{id}', ['uses' => 'ProjectRoleController@getChangeInfo']);
Route::post('project_role/changeInfo/{id}', array('https', 'uses' => 'ProjectRoleController@postChangeInfo'));
Route::post('project_role/delete/{id}', array('https', 'uses' => 'ProjectRoleController@deleteRole'));
/****resource server api start****/
Route::get('authServer-register', array('https', 'uses' => 'ResourceServerController@create'));//注册资源服务器
Route::get('admin/resources', array('https', 'uses' => 'ResourceServerController@index'));//资源服务器管理
Route::post('resources/getAllUsers', array('https', 'uses' => 'ApiController@getAllUsers'));//资源服务器获取所有用户信息
//Route::post('resources/update',array('uses'=>'ResourceServerController@updateServerInfo')) ;//更改资源服务器状态

Route::resource('resources', 'ResourceServerController');//响应资源服务器注册页面的表单提交事件

Route::post(
	'heartBeat',
	function () {
		$time = Carbon::createFromTimestamp(time());

		DB::table('oauth_sessions')->where('client_id', '=', 'testclient')->where('owner_type', '=', 'user')->where(
			'owner_id',
			'=',
			'4'
		)->update(array('updated_at' => $time));
	}
);

Route::post(
	'testTime',
	function () {
		$time = Carbon::createFromTimestamp(time());
		var_dump($time, Carbon::createFromTimestamp(time()));
	}
);

Route::post(
	'testStorage',
	function () {
		//	    $repo = new FluentSession();
		//        $repo->deleteSession('client1id', 'user', '1');

		$session = DB::table('oauth_sessions')
			->where('client_id', '=', 'testclient')
			->where('owner_type', '=', 'user')
			->where('owner_id', '=', '4')
			->first();

		var_dump($session);
	}
);
/****resource server api end****/

//Route::get('auth-login', array('https', 'uses' => 'AuthController@authLogin'));//网络帐号授权登陆

Route::get(
	'oauth/authorize',
	array(
		'before' => 'check-authorization-params|auth-check',
		'as' => 'oauth.authorize',
		function () {
			// get the data from the check-authorization-params filter
			$params = Session::get('authorize-params');

			// get the user id
			$params['user_id'] = Auth::user()->id;

			if (Session::get('first_lgin') == 1) {
				$code = AuthorizationServer::newAuthorizeRequest('user', $params['user_id'], $params);
				Session::forget('authorize-params');
				Session::forget('first_lgin');
				return Redirect::to(AuthorizationServer::makeRedirectWithCode($code, $params));

			} else {
				return View::make('authorization-form', array('params' => $params));//跳转到用户授权页面
			}// display the authorization form
		}
	)
);

Route::post('auth/switch', array('https', 'uses' => 'AuthController@switchUser'));
Route::post(
	'/oauth/authorize',
	array(
		'before' => 'check-authorization-params|auth-check|csrf',
		function () {
			SeasLog::info('access | success | '.Auth::user()->email);
			// get the data from the check-authorization-params filter
			$params = Session::get('authorize-params');

			// get the user id
			$params['user_id'] = Auth::user()->id;

			$authorize = Input::get('authorize');
			// check if the user approved or denied the authorization request
			if ($authorize === 'approve') {
				$code = AuthorizationServer::newAuthorizeRequest('user', $params['user_id'], $params);
				Session::forget('authorize-params');
				return Redirect::to(AuthorizationServer::makeRedirectWithCode($code, $params));
			}//转至params所指定的重定向地址
			else {
				Session::forget('authorize-params');
				return Redirect::to(AuthorizationServer::makeRedirectWithError($params));
			}

		}
	)
);

Route::post(
	'oauth/access_token',
	function () {
		return AuthorizationServer::performAccessTokenFlow();/*该方法定义在vendor/lucadegasperi/oauth2-server-laravel/src
    /LucaDegasperi/OAuth2Server/Proxies/AuthorizationServerProxy.php中*/
	}
);

Route::post('oauth/revoke_token', ['uses' => 'ApiController@postRevokeToken']);//更新token
Route::post('users/{id}/revoke_token', ['https', 'uses' => 'UserController@revokeToken']);

/*new manage api*/
Route::get('manage', ['uses' => 'ManageController@home']);
Route::get('manage/companies', ['uses' => 'ManageController@getCompanies']);//转向manage的人员管理页面
Route::post('manage/deleteUser', ['uses' => 'ManageController@deleteUser']);
Route::get('manage/allUser/{id}', ['uses' => 'ManageController@allUser']);//人员管理
Route::get('manage/changeUserInfo', ['uses' => 'UserController@getChangeUserInfo']);//admin修改员工信息
Route::post('manage/changeUserInfo', ['uses' => 'UserController@postChangeUserInfo']);//admin修改员工信息
Route::get('manage/companyUserSearch', ['uses' => 'ManageController@companyUserSearch']);//组织人员查找
Route::get('manage/check', ['uses' => 'ManageController@check']);


Route::get('manage/chProjectGroup', ['uses' => 'ProjectGroupController@getChProjectGroup']);//修改组信息
Route::post('manage/chProjectGroup', ['uses' => 'ProjectGroupController@postChProjectGroup']);//修改组信息
Route::get('manage/projectGroup', ['uses' => 'ProjectGroupController@index']);
Route::get('manage/showGroups', ['uses' => 'ProjectGroupController@showGroups']);//转向项目组列表
Route::post('manage/addGroupByName', ['uses' => 'ProjectGroupController@AddProjectGroupByName']);
Route::get('manage/addProjectGroup', ['uses' => 'ProjectGroupController@getAddProjectGroup']);//转向添加项目组页面
Route::post('manage/addProjectGroup', ['uses' => 'ProjectGroupController@postAddProjectGroup']);
Route::get('manage/projectGroup/sonGroups', ['uses' => 'ProjectGroupController@sonGroups']);//转向子项目组列表
Route::get('manage/addSonProjectGroup', ['uses' => 'ProjectGroupController@getAddSonProjectGroup']);//转向添加子项目组页面
Route::post('manage/addSonProjectGroup', ['uses' => 'ProjectGroupController@postAddSonProjectGroup']);
Route::post('manage/addSonByName', ['uses' => 'ProjectGroupController@AddSonProjectGroupByName']);
Route::get('manage/projectGroup/member', ['uses' => 'ProjectGroupController@projectMember']);//转向项目组成员列表
Route::post('manage/projectGroup/deleteMember', ['uses' => 'ProjectGroupController@deleteProjectMember']);//删除项目组成员
Route::get('manage/projectGroup/addMember/{id}', ['uses' => 'ProjectGroupController@getAddProjectMember']);//转向添加成员页面
Route::post('manage/projectGroup/addMember', ['uses' => 'ProjectGroupController@postAddProjectMember']);//添加项目组成员
Route::get('manage/projectGroup/searchUser', ['uses' => 'ProjectGroupController@searchUser']);//转向添加成员页面
Route::post('manage/projectGroup/changeProjectRole', ['uses' => 'ProjectGroupController@changeProjectRole']);
Route::post('manage/projectGroup/cancelLeader', ['uses' => 'ProjectGroupController@cancelLeader']);
Route::post('manage/projectSonGroup/{id}', ['uses' => 'ProjectGroupController@Sondestroy']);//删除子项目组
Route::post('manage/projectGroup/{id}', ['uses' => 'ProjectGroupController@destroy']);//删除子项目组


/*create company*/
Route::get('company/getEnabled', 'CompanyController@getEnabled');//可加入的组织
Route::post('company/postAddUser', 'CompanyController@postAddUser');
Route::resource('company', 'CompanyController');

Route::post('companyUser/postApplyAdmin', 'CompanyUserController@postApplyAdmin');
Route::resource('companyUser', 'CompanyUserController');
Route::get('changeCompanyInfo', 'CompanyController@getChangeCompanyInfo');//修改组织信息
Route::post('changeCompanyInfo', 'CompanyController@postChangeCompanyInfo');//修改组织信息
Route::get('company/delete/{id}', 'CompanyController@delete');//删除组织
/*
 * 新增组织关系接口
 */
Route::group(
	array('prefix' => 'org_api'),
	function () {
		/*   Route::post('buildCompany', [
			   'https',
			   'uses'   => 'OrgApiController@postBuildCompany'
		   ]);*/

		Route::post(
			'allCompany',
			[
				'https',
				'before' => 'oauth:basic,user',
				//这里使用逗号分割，是或的关系。
				//验证代码位于：vendor/lucadegasperi/oauth2-server-laravel/src/LucaDegasperi/OAuth2Server/Filters/OAuthFilter.php
				'uses' => 'OrgApiController@postAllCompany',
			]
		);

		/*    Route::post('addToCompany', [
				'https',
				'uses'  => 'OrgApiController@postAddToCompany',
			]);*/

		Route::post(
			'myCompany',
			[
				'https',
				'before' => 'oauth:basic,user',
				'uses' => 'OrgApiController@postMyCompany',
			]
		);

		Route::post(
			'contacts',
			[
				'https',
				'before' => 'oauth:basic,user',
				'uses' => 'OrgApiController@postContacts',
			]
		);

		/*   Route::post('exitOrg', [
			   'https',
			   'uses' => 'OrgApiController@exitOrg',
		   ]);*/

		/*   Route::post('applyAdmin', [
			   'https',
			   'uses' => 'OrgApiController@postApplyAdmin',
		   ]);*/

		/*   Route::post('buildGroup', [
			   'https',
			   'uses' => 'OrgApiController@buildGroup',
		   ]);

		   Route::post('distribute', [
			   'https',
			   'uses' => 'OrgApiController@distributeMember',
		   ]);

		   Route::post('deleteMember', [
			   'https',
			   'uses' => 'OrgApiController@deleteMember',
		   ]);*/

		Route::post(
			'orgStructure',
			[
				'https',
				'before' => 'oauth:basic,user',
				'uses' => 'OrgApiController@orgStructure',
			]
		);

		Route::post(
			'personOrg',
			[
				'https',
				'before' => 'oauth:user,basic',
				'uses' => 'OrgApiController@personOrg',
			]
		);

		Route::post(
			'groupInOrg',
			[
				'https',
				'before' => 'oauth:basic,user',
				'uses' => 'OrgApiController@groupInOrg',
			]
		);

		Route::post(
			'personInGroup',
			[
				'https',
				'before' => 'oauth:basic,user',
				'uses' => 'OrgApiController@personInGroup',
			]
		);

		Route::post(
			'userList',
			[
				'https',
				'before' => 'oauth:basic,user',
				'uses' => 'OrgApiController@userList',
			]
		);
		
		Route::post(
			'userInGroups',
			[
				'https',
				'before' => 'oauth:basic,user',
				'uses' => 'OrgApiController@userInGroups',
			]
		);

		Route::post(
			'groupInfo',
			[
				'https',
				'before' => 'oauth:basic,user',
				'uses' => 'OrgApiController@groupInfo',
			]
		);


	}
);

