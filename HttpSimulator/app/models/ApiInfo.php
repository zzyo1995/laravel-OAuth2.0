<?php
/**
 * Created by PhpStorm.
 * User: zzyo
 * Date: 2017/3/6
 * Time: 13:53
 */
class ApiInfo extends Eloquent{

    protected $table = "api_info";

    protected $guarded = array();

    public static $errorMessages = array(
        'name.required'  => '请输入公司名',
        'name.alpha_num' => '用户名包含非法字符',
        'name.unique' => '公司已存在',
        'email.email' => '输入邮箱不合法',
        'email.required'  => '请输入邮箱'
    ) ;

    public static $rules = array(
        'name' => 'required|alphaNum|unique:company',
        'email' => 'required|email',
        'applier_id' => 'required'
    );

    public static function getListByGroupID($groupID){
        return DB::table('api_info')->select('id','name','url')->where('group_id',$groupID)->get();
    }

    public static function getApiByID($id){
        return DB::table('api_info')->where('id',$id)->first();
    }

    public static function addApi($apiInfo){
        return DB::table('api_info')->insert($apiInfo);
    }

    public static function updateApi($id,$apiInfo){
        return DB::table('api_info')->where('id',$id)->update($apiInfo);
    }

    public static function deleteByID($id){
        return DB::table('api_info')->where('id',$id)->delete();
    }

}