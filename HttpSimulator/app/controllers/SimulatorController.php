<?php
/**
 * Created by PhpStorm.
 * User: zzyo
 * Date: 2017/2/28
 * Time: 14:39
 */

class SimulatorController extends BaseController{

    public function getIndex(){
        return View::make('Simulator');
    }

    public function send(){
        $url = Input::get('url');
        $method = Input::get('method');
        $params = Input::get('params');
        $params = json_decode($params,true);
        $headers = Input::get('headers');
        $headers = json_decode($headers);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
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
        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = substr($data, 0, $headerSize);
        $body = substr($data, $headerSize);
        curl_close($curl);
        $res = array('header'=>$header,'body'=>$body);
        return json_encode($res);
    }
}