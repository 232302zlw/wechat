<?php
ini_set('display_errors',1);            //错误信息
ini_set('display_startup_errors',1);    //php启动错误信息
error_reporting(-1);                    //打印出所有的 错误信息
//GET
/*$curl = curl_init('http://www.baidu.com');
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
$data = curl_exec($curl);
$errno = curl_errno($curl);  //错误码
$err_msg = curl_error($curl); //错误信息
var_dump($data);
curl_close($curl);*/

//POST
$curl = curl_init('http://wechat.18022480300.com/api/post_test');
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_POST,true);  //发送post
$form_data = [
    'name' => 111,
    'sex' => 2
];
curl_setopt($curl,CURLOPT_POSTFIELDS,$form_data);
$data = curl_exec($curl);
$errno = curl_errno($curl);  //错误码
$err_msg = curl_error($curl); //错误信息
var_dump($data);
curl_close($curl);
