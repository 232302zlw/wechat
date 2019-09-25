<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use App\Tools\Tools;
use DB;

class TagController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }

    /**
     * 标签列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/get?access_token='.$this->tools->get_wechat_access_token();
        $res = file_get_contents($url);
        $result = json_decode($res,1);
//        dd($result);
        return view('tag.list',['info'=>$result['tags']]);
    }

    /**
     * 添加标签视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('tag.create');
    }

    /**
     * 添加标签、数据处理
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function save(Request $request)
    {
        $req = $request->all();
        $data = [
            'tag' => [
                'name' => $req['name']
            ]
        ];
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/create?access_token='.$this->tools->get_wechat_access_token();
        $res = $this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        $result = json_decode($res,1);
        if ($result) {
            return redirect('/wechat/taglist');
        }
    }

    /**
     * 修改标签视图
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $data = $request->all();
        return view('tag.edit',['id'=>$data['id'],'name'=>$data['name']]);
    }

    /**
     * 修改标签、数据处理
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $req = $request->all();
        $data = [
            'tag' => [
                'id' => $req['id'],
                'name' => $req['name']
            ]
        ];
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/update?access_token='.$this->tools->get_wechat_access_token();
        $res = $this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        $result = json_decode($res,1);
        if ($result) {
            return redirect('/wechat/taglist');
        }
    }

    /**
     * 删除标签
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        $data = [
            'tag' => [
                'id' => $id
            ]
        ];
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/delete?access_token='.$this->tools->get_wechat_access_token();
        $res = $this->tools->curl_post($url,json_encode($data));
        $result = json_decode($res,1);
        if ($result){
           return redirect('wechat/taglist');
        }
    }

    /**
     * 标签下粉丝列表
     */
    public function fans_openid_list(Request $request)
    {
        $req = $request->all();
        $url = 'https://api.weixin.qq.com/cgi-bin/user/tag/get?access_token='.$this->tools->get_wechat_access_token();
        $data = [
            'tagid' => $req['tagid'],
            'next_openid' => ''
        ];
        $res = $this->tools->curl_post($url,json_encode($data));
        $result = json_decode($res,1);
        return view('fans.list',['info'=>$result]);
    }

    /**
     * 获取所有关注的 用户列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get_user_list(Request $request)
    {
        $req = $request->all();
        $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$this->tools->get_wechat_access_token().'&next_openid=');
        $res = json_decode($result,1);
        $last_info = [];
        foreach ($res['data']['openid'] as $k => $v) {
            $user_info = file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->tools->get_wechat_access_token().'&openid='.$v.'&lang=zh_CN');
            $user = json_decode($user_info,1);
            $last_info[$k]['nickname'] = $user['nickname'];
            $last_info[$k]['openid'] = $v;
        }
//        dd($last_info);
//        dd($res['data']['openid']);
        return view('fans.userlist',['info'=>$last_info]);
    }

    /**
     * 获取所有关注的 用户列表（添加标签专用）
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get_tag_user_list(Request $request)
    {
        $req = $request->all();
        $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$this->tools->get_wechat_access_token().'&next_openid=');
        $res = json_decode($result,1);
        $last_info = [];
        foreach ($res['data']['openid'] as $k => $v) {
            $user_info = file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->tools->get_wechat_access_token().'&openid='.$v.'&lang=zh_CN');
            $user = json_decode($user_info,1);
            $last_info[$k]['nickname'] = $user['nickname'];
            $last_info[$k]['openid'] = $v;
        }
//        dd($last_info);
//        dd($res['data']['openid']);
        return view('fans.taguserlist',['info'=>$last_info,'tagid'=>isset($req['tagid'])?$req['tagid']:'']);
    }

    /**
     * 给用户添加标签
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function tag_openid(Request $request)
    {
        $req = $request->all();
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token='.$this->tools->get_wechat_access_token();
        $data = [
            'openid_list' => $req['openid_list'],
            'tagid' => $req['tagid']
        ];
        $res = $this->tools->curl_post($url,json_encode($data));
        $result = json_decode($res,1);
        if ($result['errmsg'] == 'ok') {
            return redirect('/wechat/taglist');
        }else{
            dd($result);
        }
    }

    /**
     * 当前用户下有哪些标签
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function user_tag_list(Request $request)
    {
        $req = $request->all();
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/getidlist?access_token='.$this->tools->get_wechat_access_token();
        $data = [
            'openid' => $req['openid']
        ];
        $res = $this->tools->curl_post($url,json_encode($data));
        $result = json_decode($res,1);
        $tag = file_get_contents('https://api.weixin.qq.com/cgi-bin/tags/get?access_token='.$this->tools->get_wechat_access_token());
//        dd($tag);
        $tag_result = json_decode($tag,1);
        $tag_arr = [];
        foreach ($tag_result['tags'] as $v) {
            $tag_arr[$v['id']] = $v['name'];
        }
        foreach ($result['tagid_list'] as $v) {
            $result['tagid_list'] = $tag_arr[$v];
//            $v = $tag_arr[$v];
        }
//        dd($result);
        return view('fans.userTagList',['info'=>$result]);
    }

    /**
     * 根据标签 群发消息视图
     */
    public function push_message(Request $request)
    {
        $req = $request->all();
        return view('fans/pushMessage',['info'=>$req['tagid']]);
    }

    /**
     * 根据标签 群发信息处理
     * @param Request $request
     */
    public function do_push_message(Request $request)
    {
        $req = $request->all();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token='.$this->tools->get_wechat_access_token();
        $data = [
            "filter" => [
                "is_to_all" => false,
                "tag_id" => $req['tagid']
            ],
            "text" => [
                "content" => $req['message']
            ],
            "msgtype" => "text"
        ];
        $res = $this->tools->curl_post($url,json_encode($data));
        $result = json_decode($res,1);
        if($result['errcode'] == 0){
            echo "<script>alert('发送成功');localtion.href='/wechat/taglist'</script>";
        }else{
            dd($result);
        }
    }

    /**
     * 发送模板消息
     */
    public function send_template_message()
    {
        $openid = 'oYLShjkrIrRkZkMcZ20-1_VBSJ6c';
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->tools->get_wechat_access_token();
        $data = [
            'touser' => $openid,
            'template_id' => 'w-4r643TOSeyQKfYZE_UujfnS1N6c2KIBcllZhu5tkU',
            'url' => 'http://www.wechat.com',
            'data' => [
                'first' => [
                    'value' => '尊敬的Mr.周',
                    'color' => 'red'
                ],
                'keyword1' => [
                    'value' => '果冻',
                    'color' => 'green'
                ],
                'keyword2' => [
                    'value' => '双击666，点点关注，老铁没毛病！',
                    'color' => 'blue'
                ]
            ]
        ];
        $res = $this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        $result = json_decode($res,1);
        dd($result);
    }

    /**
     * 单个用户 发送消息 视图
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function send_message(Request $request)
    {
        $req = $request->all();
        unset($req['_token']);
        return view('fans.sendMessage',['info'=>json_encode($req['openid_list'])]);
    }


    public function do_send_message(Request $request)
    {
        $req = $request->all();
//        dd($req);
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.$this->tools->get_wechat_access_token();
        $data = [
            'touser' =>json_decode($req['openid'],1),
            'msgtype' => 'text',
            'text' => [
                'content' => $req['message']
            ]
        ];
//        dd($data);
        $res = $this->tools->curl_post($url,json_encode($data));
        $result = json_decode($res,1);
        if($result['errcode'] == 0){
            echo "<script>alert('发送成功');localtion.href='/wechat/userlist'</script>";
        }else{
            dd($result);
        }
    }
}
