<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
    // 强制转向https
    if( ! Request::secure()) {
        return Redirect::secure(Request::getRequestUri());
    }

    // 处理长时间非活动用户
	if (Auth::check() && !Auth::user()->isActive()) {
        Auth::logout();
        return Redirect::guest('login')->with('info', '会话已过期，请重新登录。');
    }
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login');//如果用户未登录，则重定向到login路由
});

Route::filter('auth-check',function(){
   if (Auth::guest())
    {
        Session::put('first_lgin', 1);
        return Redirect::guest('api/auth-login');
    }
});

Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

// 确认要访问的用户资源是已登录的用户资源
Route::filter('user.current', function($route)
{
    if (!Auth::check()) return Redirect::guest('login');//如果用户未登录，返回登录页面
    $id = $route->parameter('id');//已注册路由id
    if (Auth::user()->id != $id) {
        App::abort(403);//无权限访问
    }
});

// 确认当前登录用户具有管理员权限
Route::filter('user.admin', function()
{
    if (!Auth::check()) return Redirect::guest('login', 302, array(), true);//如果用户未登录，提示302错误，并转到登录界面
    $privileges = Auth::user()->group->getPrivileges();//获取当前用户的权限
    if (!in_array('admin', $privileges)) {//in_array用来判断$privileges中是否存在'users'
        App::abort(404);//若无相应权限，则返回404错误
    }
});

//确认当前登录用户具有manage权限
Route::filter('user.manage', function()
{
    if (!Auth::check()) return Redirect::guest('login', 302, array(), true);//如果用户未登录，提示302错误，并转到登录界面

    $userId = Auth::user()->id;
    if(CompanyUser::isAdmin($userId) == null){
        App::abort(404);//若无相应权限，则返回404错误
    }

/*    $privileges = Auth::user()->group->getPrivileges();//获取当前用户的权限
    if (!in_array('manage', $privileges)) {//in_array用来判断$privileges中是否存在'users'
        App::abort(404);//若无相应权限，则返回404错误
    }*/
});

//组织关系修改, 发送消息到消息队列
Route::filter('rabbit.org' , function(){

    $exchange = 'org';
    $routeKey = 'org.change';
    $message = 'the relation of organization has changed';

    RabbitMQ::publish($exchange, $routeKey, $message);

});
