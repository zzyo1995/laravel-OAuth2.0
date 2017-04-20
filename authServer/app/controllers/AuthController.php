<?php

class AuthController extends BaseController {
	
	public function helloworld()
	{
		return View::make('auth/test') ;
	}

	public function showLogin()
	{
		// Already logged in? check方法定义在/vendor/laravel/framework/src/Illuminate/Auth/Guard.php文件中
		if (Auth::check()) {
			// Redirect to homepage
			return Redirect::to('')->with('info', '您已处于登录状态。');
		}
		//make方法定义在/vendor/laravel/framework/src/Illuminate/View/Environment.php文件中
		return View::make('auth/login');//转至登录页面
	}

	public function authLogin()
	{
		// Already logged in?
		if (Auth::check()) {
			// Redirect to homepage
			SeasLog::info('access | success | '.Auth::user()->email);
			return Redirect::to('')->with('info', '您已处于登录状态。');
		}
		
		return View::make('auth/authlogin');//网络帐号授权页面
	}
	
	public function postLogin()
    {
        // Get all the inputs
        // id is used for login, username is used for validation to return correct error-strings
        $userdata = array(
            'email'    => Input::get('email'),//获得用户输入的数据
            'password' => Input::get('password')
        );
		session_start();
		if (isset($_SESSION['attempt_login_num']))
		if ($_SESSION['attempt_login_num'] > 3 ) {
			$vcode = Input::get('vcode');

			if(strtoupper($_SESSION['code']) != strtoupper($vcode) ) {
    			SeasLog::info('access | error | '.Input::get('email'));
				if (Input::has('action'))
					return Redirect::to('api/auth-login')
						->withErrors(array('vcode' => '请输入正确的验证码'))
						->withInput(Input::except('vcode'));

				// Redirect to the login page.
				return Redirect::to('login')
					->withErrors(array('vcode' => '请输入正确的验证码'))
					->withInput(Input::except('vcode'));//保留已输入的电子邮件信息，清除错误验证码

			}

		}
        // Declare the rules for the form validation.
        $rules = array(
            'email'    => 'required|email',	//数据规则
            'password' => 'required|min:6'
        );

        // Validate the inputs. make方法定义在/vendor/laravel/framework/src/Illuminate/Validation/Factory.php中
        $validator = Validator::make($userdata, $rules);//按规则检验用户输入的数据
        // Check if the form validates with success. passes方法定义在/vendor/laravel/framework/src/Illuminate/Validation/Validator.php中
        if ($validator->passes()) {
				// Try to log the user in.
				//在调用 attempt 方法时，auth.attempt 事件将会触发。如果验证成功以及用户登陆了，auth.login 事件也会被触发。
				//如果你想在应用中提供“记住我”功能，你可以传递true作为第二个参数传递给attempt方法，应用程序将会无期限地保持用户验证状态（除非手动退出）。
				if (Auth::attempt($userdata)) {
					//Auth::attempt方法定义在/vendor/laravel/framework/src/Illuminate/Auth/Guard.php
					Auth::user()->activate();//该方法定义在models/User.php中，将当前用户列为在线用户

					$_SESSION['attempt_login_num'] = 0;
    				SeasLog::info('access | success | '.Input::get('email'));
					// Redirect to homepage
					return Redirect::intended('/')->with('success', '您已经成功登录。');//跳转到被用户验证过滤器拦截之前用户试图访问URL页面，并输出提示信息
				} else {
                    if (!isset($_SESSION['attempt_login_num'])) {
                        $_SESSION['attempt_login_num'] = 0;
                    }
					$_SESSION['attempt_login_num'] ++;
					
    				SeasLog::info('access | error | '.Input::get('email'));
					if (Input::has('action'))
						return Redirect::to('api/auth-login')
							->withErrors(array('password' => '错误的用户名或密码'))
							->withInput(Input::except('password', 'vcode'));

					// Redirect to the login page.
					return Redirect::to('login')
						->withErrors(array('password' => '错误的用户名或密码'))
						->withInput(Input::except('password', 'vcode'));//保留已输入的电子邮件信息，清除错误密码

				}

        }
		$_SESSION['attempt_login_num'] ++;
    	SeasLog::info('access | error | '.Input::get('email'));
		if(Input::has('action'))
			return Redirect::to('api/auth-login')
        		->withErrors($validator)
        		->withInput(Input::except('password', 'vcode'));

        // Something went wrong.
        return Redirect::to('login')
        	->withErrors($validator)
        	->withInput(Input::except('password', 'vcode'));
    }

    public function getLogout()
    {
        Auth::user()->deactivate();//该方法定义在models/User.php中，将该用户从在线用户列表中删除
		// Log out
		Auth::logout();//登出，该方法定义在Guard.php中，

		// Redirect to homepage
		return Redirect::to('')->with('success', '您已经退出登录。');
    }

    public function switchUser()
    {
        $params['client_id'] = Session::get('switch_client_id');
        $params['redirect_uri'] = Session::get('switch_redirect_uri');
        $params['state'] = Session::get('switch_state');
        Session::forget('switch_client_id');
        Session::forget('switch_redirect_uri');
        Session::forget('switch_state');
        Auth::user()->deactivate();//该方法定义在models/User.php中，将该用户从在线用户列表中删除
        Auth::logout();//登出，该方法定义在Guard.php中
        $str = 'oauth/authorize?client_id='.$params["client_id"].'&redirect_uri='.$params['redirect_uri'].'&response_type=code'.'&state='.$params['state'];
        return Redirect::to($str);
    }

}
