<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\index\Users;

class LoginController extends Controller
{
    public function login()
    {
    	return view('index.login');
    }

    public function do_login(Request $request)
    {
    	$data = $request->all();
      unset($data['_token']);
      $data['pwd'] = md5($data['pwd']);
      $where = [
        'email' => $data['name'],
        'pwd' => $data['pwd'],
      ];
      $info = Users::where($where)->first();
    	// dd($info);
      if (empty($info)) {
        echo "<script>alert('账号或密码错误');history.back()</script>";die;
      }
      $user = [
        'id' => $info['id'],
        'name' => $info['name'],
        'email' => $info['email'],
        'headimg' => $info['headimg'],
      ];
      // dd($user);
      Request()->session()->put('user',$user);
      $res = Request()->session()->get('user');
      // dd($res);
      if ($res) {
        echo "<script>alert('登陆成功');location='/'</script>";
      }else{
        echo "<script>alert('未知错误');location='/login'</script>";
      }
    }

    public function register()
    {
    	return view('index.register');
    }

    public function do_register(Request $request)
    {
    	$data = $request->all();
    	dd($data);
    }

    //验证邮箱
   	public function checkemail(Request $request)
   	{
   		$email=request()->all();
   		$res=Users::where('email',$email)->get()->toArray();
   		if($res){
   			return ['font'=>'用户名已存在','code'=>1];
   		}else{
   			return ['font'=>'用户名可用','code'=>2];die;
   		}
   	}

   	// 发送邮件
   	public function send(Request $request)
   	{
   		$email = request()->email;
   		$rand = rand(100000,999999);
   		$msg = "您的验证码是 ".$rand." 请不要泄露！";
   		$this->sendemail($email,$msg);
   		request()->session()->put('rand',$rand);
    	$session = request()->session()->get('rand');
    	if ($session) {
    		return ['font'=>'发送成功','code'=>1];
    	}else{
    		return ['font'=>'发送失败','code'=>2];die;
    	}
    }

    // 发送邮件方法
    public function sendemail($email,$msg)
    {

	    \Mail::raw($msg,function($message)use($email){
		    //设置主题
		    $message->subject("欢迎注册微商城！");
		    //设置接收方
		    $message->to($email);
    	});
	}

	//验证验证码
   	public function checkcode(Request $request)
   	{
   		$data=request()->all();
   		unset($data['cpwd']);
   		$data['created_at'] = time();
   		$data['pwd'] = md5($data['pwd']);
   		// dd($data);
   		$code=$data['code'];
   		// dd($code);
   		// $emailInfo=request()->session()->get('emailInfo','default');
   		$rand=request()->session()->get('rand');
   		// dd($rand);
   		if($code==$rand){
			$res=Users::insertGetId($data);
		}else{
			return ['font'=>'验证码错误','code'=>2];die;
		}
		if ($res) {
			return ['font'=>'添加成功','code'=>1];
		}else{
   			return ['font'=>'未知错误','code'=>2];die;
   		}
   	}
}
