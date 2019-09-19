<?php

namespace App\Tools;
use Illuminate\Http\File;

class Tools
{
    public $redis;

    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('127.0.0.1', '6379');
    }

    /**
     * 获取access_token
     * @return bool|string
     */
    public function get_wechat_access_token()
    {
        //加入缓存
        $access_token_key = 'wechat_access_token';
        if ($this->redis->exists($access_token_key)) {
            //存在
            return $this->redis->get($access_token_key);
        } else {
            //不存在
            $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxf3c63fea45354eec&secret=6ccc59fd6ec3879bad2ad8d420536da3');
            $re = json_decode($result, 1);
            $this->redis->set($access_token_key, $re['access_token'], $re['expires_in']);  //加入缓存
            return $re['access_token'];
        }
    }

    /**
     * curl_post 方式发送
     * @param $url
     * @param $data
     * @return bool|string
     */
    public function curl_post($url, $data)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);  //发送post
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $data = curl_exec($curl);
        $errno = curl_errno($curl);  //错误码
        $err_msg = curl_error($curl); //错误信息
        curl_close($curl);
        return $data;
    }

    /**
     * guzzle 方式上传素材
     * @param $url
     * @param $path
     * @param $client
     * @return mixed
     */
    public function guzzle_upload($url, $path, $client, $is_video = 0, $title = '', $desc = '')
    {
        $multipart = [
            [
                'name' => 'media',
                'contents' => fopen($path, 'r')
            ]
        ];
        if ($is_video == 1) {
            $multipart[] = [
                'name' => 'description',
                'contents' => json_encode(['title' => $title, 'introduction' => $desc], JSON_UNESCAPED_UNICODE)
            ];
        }
        $result = $client->request('POST', $url, [
            'multipart' => $multipart
        ]);
        return $result->getBody();
    }

    /**
     * jsapi ticket
     * @return bool|string
     */
    public function get_wechat_jsapi_ticket()
    {
        // 加入缓存
        $access_api_key = 'wechat_jsapi_ticket';
        if($this->redis->exists($access_api_key)){
            // 存在
            return $this->redis->get($access_api_key);
        }else{
            // 不存在
            $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$this->get_wechat_access_token().'&type=jsapi');
            $res = json_decode($result,1);
            $this->redis->set($access_api_key,$res['ticket'],$res['expires_in']); // 加入缓存
            return $res['ticket'];
        }
    }
}
