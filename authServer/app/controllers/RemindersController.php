<?php

class RemindersController extends Controller {

	/**
	 * Display the password reminder view.
	 *
	 * @return Response
	 */
	public function getRemind()
	{
		return View::make('password.remind');//转至找回密码页面
	}

	/**
	 * Handle a POST request to remind a user of their password.
	 *
	 * @return Response
	 */
	public function postRemind()//处理忘记密码发送邮件找回的请求
	{
/*		$email=Input::get('email');
		$data = [ 'email' => $email, 'name' => $email ];
		Mail::send('password.hello', $data, function($message) use($data)
		{
			$message->to( $data['email'], "chen")->subject('找回密码');
		});
*/
	//Password::remind("email") 发送密码提示到邮箱
        $response = Password::remind(Input::only('email'), function($message)
        {
            $message->subject(trans('reminders.subject'));
        });
		switch ($response)
		{
			case Password::INVALID_USER:
				return Redirect::back()->withErrors(['email' => Lang::get($response)]);

			case Password::REMINDER_SENT:
				return Redirect::home()->with('success', Lang::get($response));
		}
	}

	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	public function getReset($token = null)//重置密码
	{
		if (is_null($token)) App::abort(404);

		return View::make('password.reset')->with('token', $token);//包含token隐藏域
	}

	/**
	 * Handle a POST request to reset a user's password.
	 *
	 * @return Response
	 */
	public function postReset()//处理重置密码请求
	{
		$credentials = Input::only(
			'email', 'password', 'password_confirmation', 'token'
		);

		//validator方法定义在/vendor/laravel/framework/src/Illuminate/Auth/Reminders/PasswordBroker.php中
        Password::validator(function($credentials)
        {
            if (strlen($credentials['password']) < 6) {
                Cache::put(
                    'reset-form-error',
                    ['password' => Lang::trans('validation.custom.password.min', ['min' => 6])],
                    10);
                return false;
            }
            return true;
        });

		$response = Password::reset($credentials, function($user, $password)
		{
			$user->password = $password;
            $user->password_confirmation = $password;

            if (!$user->updateUniques()) {
                Cache::put('reset-form-error', $user->errors(), 10);
            }
		});

		switch ($response)
		{
			case Password::INVALID_PASSWORD:
				//vendor/laravel/framework/src/Illuminate/Support/Facades/Cache.php
                if (Cache::has('reset-form-error')) {
                    $e = Cache::get('reset-form-error');
                    Cache::forget('reset-form-error');
                    return Redirect::back()->withErrors($e);//返回错误提示
                }
                return Redirect::back()->withErrors([
                    'password_confirmation' => Lang::get('validation.custom.password.confirmed')
                ]);
			case Password::INVALID_TOKEN:
                return Redirect::to('/')->with('error', '密码重置请求已过期。');
			case Password::INVALID_USER:
				return Redirect::back()->withErrors(['email' => Lang::get($response)]);

			case Password::PASSWORD_RESET:
				return Redirect::to('/')->with('success', '密码已修改。');
		}
	}

}
