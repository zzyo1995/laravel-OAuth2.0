<?php
use League\OAuth2\Server\Storage\SessionInterface;

/**
 * Created by PhpStorm.
 * User: zzyo
 * Date: 2017/2/22
 * Time: 10:25
 */

class TestController extends BaseController
{

    protected $session = null;

    public function __construct(SessionInterface $sessionObj)
    {
        $this->session = $sessionObj;
    }

    public function getRegister()
    {
        if (Input::exists('_token')) {
            $userinfo = Input::all();
            unset($userinfo['_token']);
            $userinfo['password'] = Hash::make($userinfo['password']);
            $user = new User($userinfo);
            $bool = $user->save();
            if($bool)
            {
                return Redirect::to('usersList');
            }
            else{

            }
        } else {
            return View::make('Test.register');
        }
    }

    public function getList(){
        $users = User::all();
        return View::make('Test.userslist', ['users'=>$users]);
    }

    public function getUserInfo(){
        if(!Input::has('access_token'))
        {
            return Response::json(array("status"=>"failed","error_msg"=>"access_token is required")) ;
        }

        $access_token = Input::get('access_token') ;
        $result = $this->session->validateAccessToken($access_token) ;
        if($result === false)
        {
            return Response::json(array("status"=>"failed","error_msg"=>"invalid access_token")) ;
        }

        if($result['owner_type'] !== "user")
        {
            return Response::json(array("status"=>"failed","error_msg"=>"invalid access_token owner type")) ;
        }

        $userId = $result["owner_id"] ;

        $userInfo = User::find($userId) ;

        return Response::json(array(
            "status"=>"success",
            "groupID"=>$userInfo->group_id,
            "userId"=>$userInfo->id,
            "username"=>$userInfo->username,
            "email"=>$userInfo->email));
    }

}
