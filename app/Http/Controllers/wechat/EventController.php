<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function event()
    {
//        dd($_POST);
        $xml_string = file_get_contents('php://input'); // 获取

        $wechat_log_path = storage_path('/logs/wechat/'.date("Y-m-d").'.log');
        file_put_contents($wechat_log_path,"<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n",FILE_APPEND);
        file_put_contents($wechat_log_path,$xml_string,FILE_APPEND);
        file_put_contents($wechat_log_path,"\n<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n\n",FILE_APPEND);

//        dd($xml_string);
        $xml_obj = simplexml_load_string($xml_string,'SimpleXMLElement',LIBXML_NOCDATA);
        $xml_arr = (array)$xml_obj;
        \Log::Info(json_encode($xml_arr,JSON_UNESCAPED_UNICODE));
//        echo $_GET['echostr'];
    }
}
