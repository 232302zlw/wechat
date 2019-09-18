<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools\Tools;

class MenuController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }

    public function menu()
     {
         $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$this->tools->get_wechat_access_token();
         $data = [
             'button' => [
                 [
                     'type' => 'click',
                     'name' => '今日歌曲',
                     'key' => 'V1001_TODAY_MUSIC'
                 ],
                 [
                     'name' => '菜单',
                     'sub_button' => [
                         [
                             'type' => 'view',
                             'name' => '搜索',
                             'url'  => 'http://www.soso.com/'
                         ],
                         [
                             'type' => 'miniprogram',
                             'name' => 'wxa',
                             'url' => 'http://mp.weixin.qq.com',
                             'appid' => 'wx286b93c14bbf93aa',
                             'pagepath' => 'pages/lunar/index'
                         ],
                         [
                             'type' => 'click',
                             'name' => '赞一下我们',
                             'key'  => 'V1001_GOOD'
                         ]
                     ]
                 ]
             ]
         ];
         $res = $this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
         $result = json_decode($res,1);
         dd($result);
     }
}
