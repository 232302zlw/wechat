<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools\Tools;
use App\admin\Menu;
use DB;

class MenuController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }

    /** 创建菜单视图 */
    public function create_menu()
    {
        return view('menu.create_menu');
    }

    /** 创建菜单入库 */
    public function save_menu(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        $data['button_type'] = empty($data['name2'])?1:2;
        $res = DB::table('wechat_menu')->insertGetId($data);
        if (!$res) {
            dd($res);
        }
        $this->menu();
    }

    /** 数据库中菜单列表 */
    public function list_menu()
    {
        $datas = Menu::get()->toArray();
//        dd($datas);
        return view('menu.list_menu',['info'=>$datas]);
    }

    /** 数据库菜单表格数据*/
    public function menu()
     {
         $data = [];
         $menu_list = DB::table('wechat_menu')->select(['name1'])->groupBy('name1')->get(); // 获取一级菜单
         foreach($menu_list as $vv) {
             $menu_info = DB::table('wechat_menu')->where(['name1'=>$vv->name1])->get(); // 获取一级菜单下所有 三维数组
             $menu = [];
             foreach ($menu_info as $v) {
                 $menu[] = (array)$v; // 获取一级菜单下所有中的一个 二维数组
             }
             $arr = [];
             foreach ($menu as $v) { // 获取一级菜单下所有中的一个 一维数组
                 if ($v['button_type'] == 1) { // 普通一级菜单
                     if ($v['type'] == 1) { // click
                         $arr = [
                             'type' => 'click',
                             'name' => $v['name1'],
                             'key'  => $v['event_value']
                         ];
                     }elseif ($v['type' == 2]) { // view
                         $arr = [
                             'type' => 'view',
                             'name' => $v['name1'],
                             'url'  => $v['event_value']
                         ];
                     }
                 }elseif ($v['button_type'] == 2) { // 带有二级菜单的一级菜单
                     $arr['name'] = $v['name1'];
                     if ($v['type'] == 1) { // click
                         $button_arr = [
                             'type' => 'click',
                             'name' => $v['name2'],
                             'key'  => $v['event_value']
                         ];
                     }elseif ($v['type'] == 2) { // view
                         $button_arr = [
                             'type' => 'view',
                             'name' => $v['name2'],
                             'url'  => $v['event_value']
                         ];
                     }
                     $arr['sub_button'][] = $button_arr;
                 }
             }
             $data['button'][] = $arr;
         }
//         dd($data);

         $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$this->tools->get_wechat_access_token();
         /*$data = [
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
         ];*/
         $res = $this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
         $result = json_decode($res,1);
         dd($result);
     }


     public function location()
     {
         $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
         $jsapi_ticket = $this->tools->get_wechat_jsapi_ticket();
         $noncestr  = rand(1000,9999).'wechat';
         $timestamp = time();
         $sign_str = 'jsapi_ticket='.$jsapi_ticket.'&noncestr='.$noncestr.'&timestamp='.$timestamp.'&url='.$url;
         $signature = sha1($sign_str);
         $data['noncestr']  = $noncestr;
         $data['timestamp'] = $timestamp;
         $data['signature'] = $signature;
         return view('menu.location',['data'=>$data]);
     }

}
