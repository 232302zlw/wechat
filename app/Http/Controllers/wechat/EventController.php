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
//        echo $_GET['echostr'];
        $xml_string = file_get_contents('php://input'); // 获取微信发过来的xml数据
        $wechat_log_path = storage_path('/logs/wechat/'.date("Y-m-d").'.log');  // 生成日志文件
        file_put_contents($wechat_log_path,"<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n",FILE_APPEND);
        file_put_contents($wechat_log_path,$xml_string,FILE_APPEND);
        file_put_contents($wechat_log_path,"\n<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n\n",FILE_APPEND);

//        dd($xml_string);
        $xml_obj = simplexml_load_string($xml_string,'SimpleXMLElement',LIBXML_NOCDATA);
        $xml_arr = (array)$xml_obj;
        \Log::Info(json_encode($xml_arr,JSON_UNESCAPED_UNICODE));

        if (!empty($xml_arr['EventKey'])){
            if ($xml_arr['EventKey'] == 'second_one'){
//            $xml_string = (array)$xml_string;
//            $aa=DB::table('wechat_openid')->where(['openid'=>$xml_arr['FromUserName']])->update([
//                'xml'=>$xml_string
//            ]);
//            dd($aa);
                $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->get_wechat_access_token().'&openid='.$xml_arr['FromUserName'].'&lang=zh_CN';
                $user_re = file_get_contents($url);
                $uinfo = json_decode($user_re,1);
//                dd($uinfo);
                $user_info = DB::table('wechat_openid')->where(['openid'=>$xml_arr['FromUserName']])->first();
//                dd($user_info);
                $message = 'hello'.$uinfo['nickname'];
//                dd($message);
                $xml_str = '<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                echo $xml_str;
            }
        }

        if (!empty($xml_arr['Content']))
        {
            $data = [
                'openid' => $xml_arr['FromUserName'],
                'add_time' => $xml_arr['CreateTime'],
                'type' => $xml_arr['MsgType'],
                'content' => $xml_arr['Content'],
                'msgid' => $xml_arr['MsgId']
            ];
            $time = date('Y-m-d H:i:s',$data['add_time']);
            DB::table('msg')->insert($data);
            $message = $time.','.$data['content'];
            $xml_str = '<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
            echo $xml_str;
        }

//        composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/













//        // 业务逻辑（防止刷业务）
//        if ($xml_arr['MsgType'] == 'event') {
//            if ($xml_arr['Event'] == 'subscribe') {
//                $share_code = explode('_',$xml_arr['EventKey'])[1];
//                $user_openid = $xml_arr['FromUserName']; // 粉丝的openid
//                // 判断是否已经在日志里
//                $wechat_openid = DB::table('wechat_openid')->where('openid',$user_openid)->first();
//                if (empty($wechat_openid)) {
//                    DB::table('users')->where('id',$share_code)->increment('share_num',1);
//                    DB::table('wechat_openid')->insert([
//                        'openid' => $user_openid,
//                        'add_time' => time()
//                    ]);
//                }
//            }
//        }
//
//        //签到逻辑
//        if($xml_arr['MsgType'] == 'event' && $xml_arr['Event'] == 'CLICK'){
//            if($xml_arr['EventKey'] == 'sign'){
//                //签到
//                $today = date('Y-m-d',time()); //当天日期
//                $last_day = date('Y-m-d',strtotime('-1 days'));  //昨天
//                $openid_info = DB::table("wechat_openid")->where(['openid'=>$xml_arr['FromUserName']])->first();
//                if(empty($openid_info)){
//                    //没有数据，存入
//                    DB::table("wechat_openid")->insert([
//                        'openid'=>$xml_arr['FromUserName'],
//                        'add_time'=>time()
//                    ]);
//                }
//
//                $openid_info = DB::table("wechat_openid")->where(['openid'=>$xml_arr['FromUserName']])->first();
//                if($openid_info->sign_day == $today){
//                    //已签到
//                    $message = '您今天已经签到！';
//                    $xml_str = '<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
//                    echo $xml_str;
//                }else{
//                    //未签到  加积分
//                    if($last_day == $openid_info->sign_day){
//                        //连续签到 五天一轮
//                        if($openid_info->sign_days >= 5){
//                            DB::table("wechat_openid")->where(['openid'=>$xml_arr['FromUserName']])->update([
//                                'sign_days'=>1,
//                                'score' => $openid_info->score + 5,
//                                'sign_day'=>$today
//                            ]);
//                        }else{
//                            DB::table("wechat_openid")->where(['openid'=>$xml_arr['FromUserName']])->update([
//                                'sign_days'=>$openid_info->sign_days + 1,
//                                'score' => $openid_info->score + 5 * ($openid_info->sign_days + 1),
//                                'sign_day'=>$today
//                            ]);
//                        }
//                    }else{
//                        //非连续 加积分  连续天数变1
//                        DB::table("wechat_openid")->where(['openid'=>$xml_arr['FromUserName']])->update([
//                            'sign_days'=>1,
//                            'score' => $openid_info->score + 5,
//                            'sign_day'=>$today
//                        ]);
//                    }
//                    $message = '签到成功！';
//                    $xml_str = '<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
//                    echo $xml_str;
//                }
//            }
//
//            if($xml_arr['EventKey'] == 'score'){
//                //查积分
//                $openid_info = DB::table("wechat_openid")->where(['openid'=>$xml_arr['FromUserName']])->first();
//                if(empty($openid_info)){
//                    //没有数据，存入
//                    DB::table("wechat_openid")->insert([
//                        'openid'=>$xml_arr['FromUserName'],
//                        'add_time'=>time()
//                    ]);
//                    $message = '积分：0';
//                    $xml_str = '<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
//                    echo $xml_str;
//                }else{
//                    $message = '积分：'.$openid_info->score;
//                    $xml_str = '<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
//                    echo $xml_str;
//                }
//            }
//        }
//
//        //关注逻辑
//        if($xml_arr['MsgType'] == 'event' && $xml_arr['Event'] == 'subscribe'){
//            //关注
//            //opnid拿到用户基本信息
//            $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->tools->get_wechat_access_token().'&openid='.$xml_arr['FromUserName'].'&lang=zh_CN';
//            $user_re = file_get_contents($url);
//            $user_info = json_decode($user_re,1);
//            //存入数据库
//            $db_user = DB::table("wechat_openid")->where(['openid'=>$xml_arr['FromUserName']])->first();
//            if(empty($db_user)){
//                //没有数据，存入
//                DB::table("wechat_openid")->insert([
//                    'openid'   => $xml_arr['FromUserName'],
//                    'nickname' => $user_info['nickname'],
//                    'add_time' => time()
//                ]);
//            }
//            $message = '欢迎'.$user_info['nickname'].'，感谢您的关注!';
//            $xml_str = '<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
//            echo $xml_str;
//        }



//        $message = '欢迎关注！大爷常来玩啊！';
//        $xml_str = '<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
//        echo $xml_str;
    }
    public function get_wechat_access_token()
    {
            $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxf3c63fea45354eec&secret=6ccc59fd6ec3879bad2ad8d420536da3');
            $re = json_decode($result, 1);
            return $re['access_token'];
    }
}
