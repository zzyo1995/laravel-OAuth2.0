<?php
/**
 * Created by PhpStorm.
 * User: zzyo
 * Date: 2017/3/8
 * Time: 9:50
 */
class ApiGroup extends Eloquent{

    protected $table = 'api_group';

    protected $guarded = array();

    public static function getAllGroup(){
        return DB::table('api_group')->get();
    }

    public static function getGroupByID($group_id){
        return DB::table('api_group')->where('id',$group_id)->first();
    }

    public static function addGroup($groupInfo){
        return DB::table('api_group')->insert($groupInfo);
    }

    public static function updateGroup($groupInfo){
        return DB::table('api_group')->where('id',$groupInfo->id)->update($groupInfo);
    }

    public static function deleteGroup($groupID){
        return DB::table('api_group')->where('id',$groupID)->delete();
    }
}