<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MailController extends Controller
{
    public function index()
    {
    	$email = '1160687529@qq.com';
    	$this->send($email);
    }
    
 //    public function send($email)
 //    {
	//     \Mail::send('mail' , ['name'=>'Mis.jiang'] ,function($message)use($email){
	// 	    //设置主题
	// 	    $message->subject("欢迎注册滕浩有限公司");
	// 	    //设置接收方
	// 	    $message->to($email);
 //    	});
	// }


	public function sendemail($email)
    {
    	$msg = "您的验证码是".rand(10000,99999)."请不要泄露！";
	    \Mail::raw($msg,function($message)use($email){
		    //设置主题
		    $message->subject("欢迎注册滕浩有限公司");
		    //设置接收方
		    $message->to($email);
    	});
	}
}
