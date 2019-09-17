<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Tools\Tools;
use App\admin\Users;
use DB;

class AgentController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }

    /**
     * 关注用户列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function agent_list()
    {
        $user_info = Users::get()->toArray();


        return view('agent.userlist',['info'=>$user_info]);
    }

    /**
     * 创建二维码
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create_qrcode(Request $request)
    {
        $id = $request->all()['id'];
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->tools->get_wechat_access_token();
        $data = [
            'expire_seconds' => 30*24*3600,
            'action_name' => 'QR_SCENE',
            'action_info' => [
                'scene' => [
                    'scene_id' => $id
                ]
            ]
        ];
//        dd($data);
        $res = $this->tools->curl_post($url,json_encode($data));
        $result = json_decode($res,1);
        $qrcode_info = file_get_contents('https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($result['ticket']));
        $path = '/wechat/qrcode/'.time().rand(1000,9999).'.jpg';
        Storage::put($path,$qrcode_info);
        // 修改数据
        $re = Users::where('id',$id)->update([
            'qrcode_url' => '/storage'.$path,
            'add_qrcode_time' => time()
        ]);
        if ($re) {
            return redirect('/agent/list');
        }else{
            dd($re);
        }
    }
}
