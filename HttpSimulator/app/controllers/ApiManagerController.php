<?php

/**
 * Created by PhpStorm.
 * User: zzyo
 * Date: 2017/3/6
 * Time: 18:56
 */
class ApiManagerController extends BaseController
{

    public function addGroup(){
        if(Input::exists('_token')){
            $groupInfo = Input::all();
            unset($groupInfo['_token']);
            ApiGroup::addGroup($groupInfo);
            return Redirect::to('/api-manage');
        }
        else{
            return View::make('api.createGroup');
        }
    }

    public function getListByID()
    {
        if(Input::exists('group_id')){
            $group_id = Input::get('group_id');
        }
        else{
            $group_id = 1;
        }
        $groupList = ApiGroup::getAllGroup();
        $apiList = ApiInfo::getListByGroupID($group_id);
        //var_dump($apiList);
        return View::make('api.index')->with(array('admin'=>'1', 'groupList'=>$groupList, 'apiList'=>$apiList, 'activeGroup'=>$group_id));
    }

    public function addApi(){
        if (Input::exists('group_id')){
            $apiInfo = Input::all();
            //unset($apiInfo['_token']);
            ApiInfo::addApi($apiInfo);
            return Redirect::to('/api-manage');
        }
        else{
            $groupList = ApiGroup::getAllGroup();
            return View::make('api.create')->with(array('action'=>'create','groupList'=>$groupList));
        }
    }




    public function manageApi(){
        $apiID = Input::get('api_id');
        $apiInfo = ApiInfo::getApiByID($apiID);
        $groupList = ApiGroup::getAllGroup();
        return View::make('api.create')->with(array('action'=>'manage','apiInfo'=>$apiInfo,'groupList'=>$groupList));
    }

    public function getApiInfo(){}
    public function apiTest(){}


}