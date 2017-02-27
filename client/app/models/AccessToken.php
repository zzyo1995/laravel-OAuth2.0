<?php
/**
 * Created by PhpStorm.
 * User: zzyo
 * Date: 2017/2/25
 * Time: 21:16
 */

class AccessToken extends Eloquent{

    protected $table = 'access_token';

    protected $fillable = array('access_token', 'token_type', 'expires','expires_in', 'refresh_token');

    public function getAccessToken(){
        return $this->access_token;
    }

    public function getRefreshToken(){
        return $this->refresh_token;
    }

    public function getExpires(){
        return $this->expires;
    }

    public function getExpiresIn(){
        return $this->expires_in;
    }

}