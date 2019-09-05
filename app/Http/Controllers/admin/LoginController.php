<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\admin\Login;

class LoginController extends Controller
{
	/*登陆视图*/
    public function login()
    {
    	return view('admin.login');
    }

    /*登陆处理*/
    public function do_login(Request $request)
    {
    	$data = $request->all();
    	$data['user_pwd'] = md5($data['user_pwd']);
    	unset($data['_token']);
    	$where=[
	        ['user_name','=',$data['user_name']],
	        ['user_pwd','=',$data['user_pwd']],
	    ];

    	$info = DB::table('user_info')->where($where)->get()->toArray();
    	// dd($info[0]->user_name);
    	if (!$info) {
    		echo "<script>alert('账号或密码错误');history.back()</script>";die;
    	}
    	$userinfo = [
    		'user_id' => $info[0]->user_id,
    		'user_name' => $info[0]->user_name,
    		'headimg' => $info[0]->headimg,
    	];
    	request()->session()->put('userinfo',$userinfo);
    	echo "<script>alert('登陆成功');location='/goods/list'</script>";
    }
}
