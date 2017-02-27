<?php
/**
 * Created by PhpStorm.
 * User: zzyo
 * Date: 2017/2/24
 * Time: 14:57
 */

class AuthController extends BaseController{

    public function login(){
        if(Input::exists('_token'))
        {
            $user = Input::all();
            unset($user['_token']);
            $nUser = new User($user);
            $credentials = array('email'=>$nUser->getReminderEmail(), 'password'=>$nUser->getAuthPassword());
            if(Auth::attempt($credentials)){
                return Redirect::intended('/');
            }
            else{
                var_dump('login failed!');
            }
        }
        else{
            return View::make('Test.login');
        }
    }

    public function getAuth(){
        $params = Session::get('authorize-params');
        $params['user_id'] = Auth::user()->id;
        return View::make('Test.authorization-form', array('params' => $params));
    }

    public function issueAuthCode(){
        $params = Session::get('authorize-params');
        $params['user_id'] = Auth::user()->id;
        $code = AuthorizationServer::newAuthorizeRequest('user', $params['user_id'], $params);
        Session::forget('authorize-params');
        return Redirect::to(AuthorizationServer::makeRedirectWithCode($code, $params));
    }

    public function issueAccToken(){
        return AuthorizationServer::performAccessTokenFlow();
    }

}