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
        return view('fans.userlist',['info'=>$last_info,'tagid'=>$req['tagid']]);
    }
}
