<?php
$curl = curl_init('http://www.baidu.com');
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
$data = curl_exec($curl);
var_dump($data);
curl_close($curl);
