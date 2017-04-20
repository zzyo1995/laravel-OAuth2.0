<?php

use LaravelBook\Ardent\Ardent;

define("MAXSIZE", 2000000000);
class Client extends Ardent {

    protected $table = 'oauth_clients';
    protected $guarded = array();

    public static $rules = array(
        'id'       => 'required|alphaNum|unique:oauth_clients',
        'name'     => 'required|alphaNum');

    public function scopes() {
        return $this->belongsToMany('scope', 'oauth_client_scopes');
    }

    public static function getClientsByUid($uid) {
        return DB::table('oauth_clients')->where('user_id', $uid)->orderBy('created_at','desc')->get();
    }

    public static function getJurisSecfileUsers($juris_type)//提取指定客户端
    {
        $curMax = DB::table('user_jurisdiction')->max('secfile_type');
        if($curMax > MAXSIZE)
        {
            DB::table('user_jurisdiction')->update(array('secfile_type' => 0));
        }
        if($juris_type === '0')
        {
            return DB::table('user_jurisdiction')
                ->join('users', 'users.id', '=', 'user_jurisdiction.user_id')
                ->where('user_jurisdiction.secfile_type',0)
                ->where('users.group_id','<>', 2)->get() ;
        }
        else
        {
            return DB::table('user_jurisdiction')
                ->join('users', 'users.id', '=', 'user_jurisdiction.user_id')
                ->where('user_jurisdiction.secfile_type','<>',0)
                ->where('users.group_id','<>', 2)
                ->orderBy('user_jurisdiction.secfile_type')->get() ;
        }
    }

    public static function getJurisGitlabUsers($juris_type)//提取指定客户端
    {
        $curMax = DB::table('user_jurisdiction')->max('gitlab_type');
        if($curMax > MAXSIZE)
        {
            DB::table('user_jurisdiction')->update(array('gitlab_type' => 0));
        }
        if($juris_type === '0')
        {
            return DB::table('user_jurisdiction')
                ->join('users', 'users.id', '=', 'user_jurisdiction.user_id')
                ->where('user_jurisdiction.gitlab_type',0)
                ->where('users.group_id','<>', 2)->get() ;
        }
        else
        {
            return DB::table('user_jurisdiction')
                ->join('users', 'users.id', '=', 'user_jurisdiction.user_id')
                ->where('user_jurisdiction.gitlab_type','<>',0)
                ->where('users.group_id','<>', 2)
                ->orderBy('user_jurisdiction.gitlab_type')->get() ;
        }
    }

    public static function getJurisRiochatUsers($juris_type)//提取指定客户端
    {
        $curMax = DB::table('user_jurisdiction')->max('riochat_type');
        if($curMax > MAXSIZE)
        {
            DB::table('user_jurisdiction')->update(array('riochat_type' => 0));
        }
        if($juris_type === '0')
        {
            return DB::table('user_jurisdiction')
                ->join('users', 'users.id', '=', 'user_jurisdiction.user_id')
                ->where('user_jurisdiction.riochat_type','0')
                ->where('users.group_id','<>', 2)->get() ;
        }
        else
        {
            return DB::table('user_jurisdiction')
                ->join('users', 'users.id', '=', 'user_jurisdiction.user_id')
                ->where('user_jurisdiction.riochat_type','<>','0')
                ->where('users.group_id','<>', 2)
                ->orderBy('user_jurisdiction.riochat_type')->get() ;
        }
    }
}
