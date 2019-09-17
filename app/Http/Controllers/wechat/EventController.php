<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

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
        // 业务逻辑（防止刷业务）
        if ($xml_arr['MsgType'] == 'event') {
            if ($xml_arr['Event'] == 'subscribe') {
                $share_code = explode('_',$xml_arr['EventKey'])[1];
                $user_openid = $xml_arr['FromUserName']; // 粉丝的openid
                // 判断是否已经在日志里
                $wechat_openid = DB::table('wechat_openid')->where(['openid',$user_openid])->first();
                if (empty($wechat_openid)) {
                    Users::where('id',$share_code)->increment('share_num',1);
                    DB::table('wechat_openid')->insert([
                        'openid' => $user_openid,
                        'add_time' => time()
                    ]);
                }
            }
        }
        $message = '欢迎关注！大爷常来玩啊！';
        $xml_str = '<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';

    }
}
