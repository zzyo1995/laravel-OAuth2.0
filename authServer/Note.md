尝试登陆三次输入验证码  
withInput(Input::except('vcode'));数据保持  
$validator = Validator::make($userdata, $rules);//按规则检验用户输入的数据  
操作审计SeasLog::info('access | success | '.Auth::user()->email);　　
OAuth SSO 单点登录　　　
消息队列send2rabbitmq('localhost', 'secfile', '{"action":"RegistUser","user_id":"'.$u->id.'","user_name":"'.$u->username.'","user_email":"'.$u->email.'","user_category":"'.$u->user_category.'","project_group_id":"'.$pgid.'"}');  
模糊查找  
心跳检测  
国际化Lang::trans('validation.custom.password.min', ['min' => 6])]　　
