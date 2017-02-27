<?php

class AuthTestController extends BaseController{


	 public  function getIndex(){
        return View::make('authtest');
    }

    public function requestAccToken(){
        $params = Input::all();
        $code = $params['code'];
/*       $postData = 'grant_type='.urlencode('authorization_code').'&client_id='.urlencode('client1id').
            '&client_secret='.urlencode('client1secret').'&redirect_uri='.urlencode('http://localhost:8001/callback').
            '&code='.urlencode($code);*/
        $params = array(
            'grant_type' => 'authorization_code',
            'client_id' => 'client1id',
            'client_secret' => 'client1secret',
            'redirect_uri' => 'http://localhost:8001/callback',
            'code' => $code);
    	$curl = curl_init();
    	curl_setopt($curl, CURLOPT_URL, 'http://localhost:8000/auth/access_token');
    	curl_setopt($curl, CURLOPT_HEADER, 0);
    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($curl);
        $result = json_decode($data,true);
        curl_close($curl);
        if($result['access_token']){
            $accessToken = AccessToken::find(1);
            $accessToken->access_token = $result['access_token'];
            $accessToken->token_type = $result['token_type'];
            $accessToken->expires = $result['expires'];
            $accessToken->expires_in = $result['expires_in'];
            $accessToken->refresh_token = $result['refresh_token'];
            $accessToken->save();
            return View::make('getUserInfo');
        }
        else{
            var_dump('failed');
        }
    }

    public function refreshAccessToken(){
        $access = AccessToken::find(1);
        $refresh_token = $access->refresh_token;
        $params = array(
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token,
            'client_id' => 'client1id',
            'client_secret' => 'client1secret'
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://localhost:8000/auth/access_token');
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($curl);
        $result = json_decode($data,true);
        curl_close($curl);
        if($result['access_token']){
            $accessToken = AccessToken::find(1);
            $accessToken->access_token = $result['access_token'];
            $accessToken->token_type = $result['token_type'];
            $accessToken->expires = $result['expires'];
            $accessToken->expires_in = $result['expires_in'];
            $accessToken->save();
            return View::make('getUserInfo');
        }
        else{
            var_dump('failed');
        }
        return View::make('getUserInfo');
    }

    public function getUserInfo(){
        $access = AccessToken::find(1);
        $access_token = $access->access_token;
        $params = array(
            'access_token' => $access_token);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://localhost:8000/userInfo');
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($curl);
        $result = json_decode($data,true);
        curl_close($curl);
        return View::make('showUserInfo',array('userInfo' => $result));
    }

}