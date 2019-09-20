<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Suport\Facades\Storage;
use GuzzleHttp\Client;
use App\Tools\Tools;
use DB;

class WechatController extends Controller
{
    public $tools;
    public $client;
    public function __construct(Tools $tools,Client $client)
    {
        $this->tools = $tools;
        $this->client = $client;
    }


    /**
     * 微信登陆
     */
    public function wechat_login()
    {
        $redirect_uri = 'http://www.wechat.com/wechat/code';
        // 第一步：用户同意授权，获取code
//        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WECHAT_APPID').'&redirect_uri='.urlencode($redirect_uri).'&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect';
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WECHAT_APPID').'&redirect_uri='.urlencode($redirect_uri).'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
        header('Location:'.$url);
    }

    /**
     * 接收code 第二部
     */
    public function code(Request $request)
    {
        $req = $request->all();
        // 第二步：通过code换取网页授权access_token
        $result = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WECHAT_APPID').'&secret='.env('WECHAT_APPSECRET').'&code='.$req['code'].'&grant_type=authorization_code');
        $re = json_decode($result,1);
        $user_info = file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$re['access_token'].'&openid='.$re['openid'].'&lang=zh_CN');
        $wechat_user_info = json_decode($user_info,1);
        dd($wechat_user_info);
    }



    /**
     * 获取用户列表
     */
    public function get_user_list()
    {
//        $app = app('wechat.offcial_account');
//        $users = $app->user->select();
//        $user = $app->user->list($nextOpenId = null);
//        dd($user);
        $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$this->tools->get_wechat_access_token().'&next_openid=');
        $re = json_decode($result,1);
        $last_info = [];
        foreach($re['data']['openid'] as $k=>$v){
            $user_info = file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->tools->get_wechat_access_token().'&openid='.$v.'&lang=zh_CN');
            $user = json_decode($user_info,1);
            $last_info[$k]['nickname'] = $user['nickname'];
            $last_info[$k]['openid'] = $v;
        }
        $last_info = json_encode($last_info);
        $last_info = json_decode($last_info);
        // dd($last_info[0]);
        //dd($re['data']['openid']);
        return view('wechat.list',['info'=>$last_info]);
    }

    /**
     * 用户详情
     */
    public function get_user_detail()
    {
        $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$this->tools->get_wechat_access_token().'&next_openid=');
        $re = json_decode($result,1);
        $last_info = [];
        foreach($re['data']['openid'] as $k=>$v){
            $user_info = file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->tools->get_wechat_access_token().'&openid='.$v.'&lang=zh_CN');
            $user = json_decode($user_info,1);
            $last_info[$k]['nickname'] = $user['nickname'];
            $last_info[$k]['openid'] = $v;
            $last_info[$k]['headimgurl'] = $user['headimgurl'];
            $last_info[$k]['city'] = $user['city'];
        }
        $last_info = json_encode($last_info);
        $last_info = json_decode($last_info);
        // dd($last_info);
        // dd($re['data']['openid']);
        return view('wechat.detail',['info'=>$last_info]);
    }

    /**
     * 调用的方法 获取access_token 方法
     */
    public function get_access_token()
    {
        return $this->tools->get_wechat_access_token();
    }



    /*************************************************************************************/
    /**
     * 简单 GET curl 测试
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function curl_1()
    {
        return view('wechat.curl_1');
    }

    /**
     * POST 方式 curl 测试
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function curl()
    {
        return view('wechat.curl');
    }

    public function post_test()
    {
        dd($_POST);
    }
    /*************************************************************************************/




    /**
     * 上传素材视图
     */
    public function sucai()
    {
        return view('wechat.sucai');
    }

    /**
     * 上传素材处理
     * @param Request $request
     * @param Client $client
     */
    public function upload_do(Request $request,Client $client)
    {
        $name = 'file_name';
        $type = $request->all()['type'];
        $source_type = '';
        switch ($type) {
            case 1: $source_type = 'image' ; break;
            case 2: $source_type = 'voice' ; break;
            case 3: $source_type = 'video' ; break;
            case 4: $source_type = 'thnmb' ; break;
            default;
        }
        if(!empty(request()->hasFile($name)) && request()->file($name)->isValid()){
            // 大小 资源类型限定
            $ext = $request->file($name)->getClientOriginalExtension();     //文件类型
            $size = $request->file($name)->getClientSize() / 1024 /1024;    // 文件大小
//            dd($source_type);
            if ($source_type == 'image') {
                if (!in_array($ext,['png','jpg','jpeg','gif'])) {
                    echo "<script>alert('图片类型不支持，只能是PNG,JPG,JPEG,GIF');history.back()</script>";die;
                }
                if ($size > 2) {
                    echo "<script>alert('图片太大了，不能超过2M');history.back()</script>";die;
                }
            }elseif ($source_type == 'voice') {
                if (!in_array($ext,['AMR','MP3','mp3'])) {
                    echo "<script>alert('语音类型不支持，只能是AMR和MP3');history.back()</script>";die;
                }
                if ($size > 2) {
                    echo "<script>alert('语音太大了，不能超过2M');history.back()</script>";die;
                }
            }elseif ($source_type == 'video') {
                if (!in_array($ext,['MP4'])) {
                    echo "<script>alert('视频类型不支持，只能是MP4');history.back()</script>";die;
                }
                if ($size > 10) {
                    echo "<script>alert('视频太大了，不能超过10M');history.back()</script>";die;
                }
            }elseif ($source_type == 'thumb') {
                if (!in_array($ext,['jpg'])) {
                    echo "<script>alert('缩略图类型不支持，只能是JPG');history.back()</script>";die;
                }
                if ($size > 0.0625) {
                    echo "<script>alert('缩略图太大了，不能超过64K(0.0625M)');history.back()</script>";die;
                }
            }

            $file_name = time().rand(10000,99999).'.'.$ext;
            $path = $request->file($name)->storeAs('wechat/'.$source_type,$file_name);
            $storage_path = '/storage/'.$path;
            $path = realpath('./storage/'.$path);
            $url = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token='.$this->tools->get_wechat_access_token().'&type='.$source_type;
            //$result =$this->tools->curl_upload($url,$path);
            if ($source_type == 'video') {
                $title = '标题';  // 视频标题
                $desc = '描述';   // 视频描述
                $result = $this->tools->guzzle_upload($url,$path,$client,1,$title,$desc);
            }else{
                $result = $this->tools->guzzle_upload($url,$path,$client);
            }

            $res = json_decode($result,1);

            $result = DB::table('wechat_source')->insert([
                'media_id'=>$res['media_id'],
                'type' => $type,
                'path' => $storage_path,
                'add_time'=>time()
            ]);
//            dd($result);
            if ($result) {
                return redirect('/wechat/source?page=1');
            }else{
                echo "$result 为空";
            }
        }
    }


    /**
     * 调用频次清0
     */
    public function  clear_api(){

        $url = 'https://api.weixin.qq.com/cgi-bin/clear_quota?access_token='.$this->tools->get_wechat_access_token();
        dump($url);
        $data = ['appid'=>env('WECHAT_APPID')];
        dump($data);
        $aa = $this->tools->curl_post($url,json_encode($data));
        dump($aa);
    }

    /**
     * 微信素材管理页面
     */
    public function wechat_source(Request $request,Client $client)
    {
        $req = $request->all();
//        dd($req);
        empty($req['source_type'])?$source_type = 'image':$source_type=$req['source_type'];
        if(!in_array($source_type,['image','voice','video','thumb'])){
            dd('类型错误');
        }
        if(!empty($req['page']) && $req['page'] <= 0 ){
            dd('页码错误');
        }
        empty($req['page'])?$page = 1:$page=$req['page'];
        if($page <= 0 ){
            dd('页码错误');
        }

        $pre_page = $page - 1;
        $pre_page <= 0 && $pre_page = 1;
        $next_page = $page + 1;
        // 获取素材列表
        $url = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token='.$this->tools->get_wechat_access_token();
        $data = [
            'type' =>$source_type,
            'offset' => $page == 1 ? 0 : ($page - 1) * 20,
            'count' => 20
        ];

        //guzzle使用方法
//        $r = $client->request('POST', $url, [
//            'body' => json_encode($data)
//        ]);
//        $re = $r->getBody();

//        $re = $this->tools->curl_post($url,json_encode($data));
//        $this->tools->redis->set('source_info',$re);
        $res = $this->tools->redis->get('source_info');
        $info = json_decode($res,1);
        $media_id_list = [];
        $source_arr = ['image'=>1,'voice'=>2,'video'=>3,'thumb'=>4];
        foreach($info['item'] as $v){
            // 同步数据库
            $media_info = DB::table('wechat_source')->where(['media_id'=>$v['media_id']])->select(['source_id'])->first();
            if (empty($media_info)){
                DB::table('wechat_source')->insert([
                    'media_id' => $v['media_id'],
                    'type' => $source_arr[$source_type],
                    'add_time' => $v['update_time'],
                    'path' => $v['name']
                ]);
            }
            $media_id_list[] = $v['media_id'];
//            dd($media_id_list);
        }
        $source_info = DB::table('wechat_source')->whereIn('media_id',$media_id_list)->where(['type'=>$source_arr[$source_type]])->get();
//        dd($source_info);
        foreach($source_info as $k=>$v){
            $is_download = 0;  //是否需要下载文件 是 1 否 0
            if(empty($v->path)){
                $is_download = 1;
            }elseif (!empty($v->path) && !file_exists('.'.$v->path)){
                $is_download = 1;
            }
            $source_info[$k]->is_download = $is_download;
        }
//        dd($source_info);
        return view('Wechat.source',['info'=>$source_info,'pre_page'=>$pre_page,'next_page'=>$next_page,'source_type'=>$source_type]);
    }



    /**
     * curl 方式上传素材
     * @param $url
     * @param $path
     * @return bool|string
     */
    public function curl_upload($url,$path)
    {
        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_POST,true);//发送post请求
        $form_data = [
            'media' => new \CURLFile($path)
        ];
        curl_setopt($curl,CURLOPT_POSTFIELDS,$form_data);
        $data = curl_exec($curl);
        //$errno = curl_errno($curl);  //错误码
        //$err_msg = curl_error($curl); //错误信息
        curl_close($curl);
        return $data;
    }

    /**
     * 下载资源
     * @param Request $request
     */
    public function download_source(Request $request)
    {
        $req = $request->all();
        $source_info = DB::connection('mysql_cart')->table('wechat_source')->where(['id'=>$req['id']])->first();
        $source_arr = [1=>'image',2=>'voice',3=>'video',4=>'thumb'];
        $source_type = $source_arr[$source_info->type]; //image,voice,video,thumb
        //素材列表
        //$media_id = 'dcgUiQ4LgcdYRovlZqP88RB3GUc9kszTy771IOSadSM'; //音频
        //$media_id = 'dcgUiQ4LgcdYRovlZqP88dUuf1H6G4Z84rdYXuCmj6s'; //视频
        $media_id = $source_info->media_id;
        $url = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token='.$this->tools->get_wechat_access_token();
        $re = $this->tools->curl_post($url,json_encode(['media_id'=>$media_id]));
        if($source_type != 'video'){
            Storage::put('wechat/'.$source_type.'/'.$source_info->file_name, $re);
            DB::connection('mysql_cart')->table('wechat_source')->where(['id'=>$req['id']])->update([
                'path'=>'/storage/wechat/'.$source_type.'/'.$source_info->file_name,
            ]);
            dd('ok');
        }
        $result = json_decode($re,1);
        //设置超时参数
        $opts=array(
            "http"=>array(
                "method"=>"GET",
                "timeout"=>3  //单位秒
            ),
        );
        //创建数据流上下文
        $context = stream_context_create($opts);
        //$url请求的地址，例如：
        $read = file_get_contents($result['down_url'],false, $context);
        Storage::put('wechat/video/'.$source_info['file_name'], $read);
        DB::connection('mysql_cart')->table('wechat_source')->where(['id'=>$req['id']])->update([
            'path'=>'/storage/wechat/'.$source_type.'/'.$source_info->file_name,
        ]);
        dd('ok');
        //Storage::put('file.mp3', $re);
    }
}

