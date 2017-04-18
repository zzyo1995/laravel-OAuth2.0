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
        return View::make('api.index')->with(array('admin'=>'', 'groupList'=>$groupList, 'apiList'=>$apiList, 'activeGroup'=>$group_id));
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

    public function updateApi()
    {
        $api_id = Input::get('api_id');
        $apiInfo = Input::all();
        unset($apiInfo['api_id']);
        $result = ApiInfo::updateApi($api_id,$apiInfo);
        if($result){
            return '修改成功';
        }
        else{
            return '修改失败';
        }

    }

    public function deleteApi()
    {
        $api_id = Input::get('api_id');
        $result = ApiInfo::deleteByID($api_id);
        if($result){
            return '删除成功';
        }
        else{
            return '删除失败';
        }
    }


    public function manageApi(){
        $apiID = Input::get('api_id');
        $apiInfo = ApiInfo::getApiByID($apiID);
        $params = $apiInfo->params;
        $params = json_decode($params,true);
        $apiInfo->params = $params;
        $groupList = ApiGroup::getAllGroup();
        return View::make('api.create')->with(array('action'=>'manage','apiInfo'=>$apiInfo,'groupList'=>$groupList));
    }

    public function getApiInfo(){
        $api_id = Input::get('api_id');
        $apiInfo = ApiInfo::getApiByID($api_id);
        $params = $apiInfo->params;
        $params = json_decode($params,true);
        $apiInfo->params = $params;
        $groupList = ApiGroup::getAllGroup();
        return View::make('api.create')->with(array('action'=>'info', 'apiInfo'=>$apiInfo,'groupList'=>$groupList));
    }

    public function apiTest(){
        if(Input::exists('api_id')){
            $apiInfo = ApiInfo::getApiByID(Input::get('api_id'));
            $params = $apiInfo->params;
            $params = json_decode($params,true);
            $apiInfo->params = $params;
            //var_dump($apiInfo);
            $groupList = ApiGroup::getAllGroup();
            return View::make('api.create')->with(array('action'=>'test', 'apiInfo'=>$apiInfo,'groupList'=>$groupList));
        }
        else{
            //var_dump(Input::all());
            $url = Input::get('url');
            $method = Input::get('method');
            $params = Input::get('params');
            $params = json_decode($params,true);
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            if($method == 'GET'){
                curl_setopt ($curl, CURLOPT_POST, 0);
            }
            else{
                curl_setopt ($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
            }
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            $data = curl_exec($curl);
            $headsize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
            $body = substr($data, $headsize);
            curl_close($curl);
            return $body;
        }
    }


}