<?php
/**
 * Created by PhpStorm.
 * User: zzyo
 * Date: 2017/2/27
 * Time: 10:35
 */

class PostData{

    /**
     * PostData to a API
     * $data  Array
     * Return Array
     */
    public function post($url, $data){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($curl);
        $result = json_decode($data,true);
        curl_close($curl);
        return $result;
    }
}