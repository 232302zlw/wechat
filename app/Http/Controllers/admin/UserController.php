<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\admin\User;
use Validator;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
	/*用户列表视图*/
    public function list()
    {
    	/************************** cookie存取操作 ***************************/
    	// $name = json_decode(Cookie::get('u_name'));	// 方法一、解析json字符串
    	// $name = unserialize(Cookie::get('u_name'));	// 方法二、反序列化
    	// dd($name);									// 打印
    	/********************************************************************/

        // $session = request()->session()->get('userinfo');
        // dd($session['user_name']);
        
    	$query = request()->input();
    	$user_name = $query['user_name']??'';
    	$user_id = $query['user_id']??'';
    	$where = [];
    	if ($user_name) {
    		$where[] = ['user_name','like',"%$user_name%"];
    	}
    	if ($user_id) {
    		$where[] = ['user_id','=',$user_id];
    	}
    	// dd($query);
    	
    	$pageSize = config('app.pageSize');
    	// $data = DB::table('user_info')->where($where)->paginate($pageSize);
    	// dd($data);
    	$orderFiled = 'user_id';
    	$data = User::getUser($where,$orderFiled,$pageSize);

    	return view('admin.user_list',compact('data','query','name','age'));
    }
    /*用户添加视图*/
    public function create()
    {
    	/******************* 第一种存取session（全局辅助函数）*****************/
    	// $user = ['u_id'=>1,'u_name'=>'Mr.zhou'];		// 设置值
    	// session(['user'=>$user]);					// 存入session
    	// $user = session('user');						// 获取session中的值
    	// session(['user'=>null]);						// 删除session中的值
    	// $user = session('user');						// 获取session中的值
    	// dd($user);									// 打印
    	/*******************************************************************/

    	/******************* 第二种存取session ******************************/
    	// $user = ['u_id'=>2,'u_name'=>'Mis.jiang'];		// 设置值
    	// request()->session()->put('user',$user);			// 存入session
    	// $user = request()->session()->get('user');		// 获取session中的值
    	// request()->session()->pull('user');				// 删除session中的值
    	// $user = request()->session()->get('user');		// 获取session中的值
    	// dd($user);										// 打印
    	/*******************************************************************/

    	/******************* 第三种存取session ******************************/
    	// $user = ['u_id'=>3,'u_name'=>'Ms.jiang'];		// 设置值
    	// request()->session()->put('user',$user);			// 存入session
    	// $user = request()->session()->get('user');		// 获取session中的值
    	// request()->session()->forget('user');			// 删除session中的值	（只是删除不同 forget）
    	// $user = request()->session()->get('user');		// 获取session中的值
    	// dd($user);										// 打印
    	/*******************************************************************/

    	/******************* 第四种存取session ******************************/
    	// $user = ['u_id'=>4,'u_name'=>'Ms.jiang'];		// 设置值
    	// request()->session()->put('user',$user);			// 存入session
    	// $user = request()->session()->get('user');		// 获取session中的值
    	// request()->session()->flush('user');				// 删除session中的值	（只是删除不同 flush）
    	// $user = request()->session()->get('user');		// 获取session中的值
    	// dd($user);	
    	/*******************************************************************/

    	/********************** cookie存取操作（queue队列方式响应*************/
    	// $user = json_encode(['u_id'=>5,'u_name'=>'Mr.zhou']);	// 方法一、json_encode设置值
    	// $user = serialize(['u_id'=>5,'u_name'=>'Mr.zhou']);		// 方法二、序列化设置值
    	// Cookie::queue(Cookie::make('u_name',$user,24*60));		// 将值存入Cookie 

    	// 注：第二个值不能直接使用变量，所以使用json_encode 或者 序列化
    	/*******************************************************************/

    	/********************** session存入数据库 ***************************/
    	// $user = ['u_id'=>2,'u_name'=>'Mis.jiang'];
    	// request()->session()->put('user',$user);
    	// request()->session()->save();
    	// $user = request()->session()->get('user');
    	/*******************************************************************/

    	return view('admin.user_create');
    }

    /*用户添加处理入库*/
    public function save(Request $request)
    {
    	$data=$request->all();
    	unset($data['_token']);
        $headimg = $data['headimg']??'';
		$data['user_pwd'] = md5($data['user_pwd']);
		$data['create_time'] = time();
    	// dd($data);
    	$validator = Validator::make($request->all(),[
            'user_name'=>'required|unique:user_info|max:4',
            'user_pwd'=>'required'
        ],[
            'user_name.required'=>'用户名不能为空',
            'user_name.unique'=>'用户名已存在',
            'user_name.max'=>'用户名最大4位',
            'user_pwd.required'=>'密码不能为空'
        ]);
        if ($validator->fails()) {
            return redirect('user/create')
            ->withErrors($validator)
            ->withInput();
        }
        if(!$headimg){
            // 未上传图片
            echo ("<script>alert('未上传图片');history.back()</script>");die;
        }
        if (request()->hasFile('headimg')) {
        	$data['headimg'] = $this->upload('headimg');
        }
    	$res = DB::table('user_info')->insertGetId($data);
    	if ($res) {
    		echo "<script>alert('添加成功');location='/user/list'</script>";
    	}else{
    		echo "<script>alert('添加失败');location='/user/list'</script>";
    	}
    }

    // /*文件上传方法*/
    // public function upload($name)
    // {
    // 	if (request()->file($name)->isValid()) {
    // 		$headimg = request()->file($name);
    // 		// $extension = $headimg->extension();
    // 		// $store_result = $headimg->syore('headimg');
    // 		$store_result = $headimg->store('','public');
    // 		return $store_result;
    // 	}
    // 	exit('未上传文件');
    // }

    /*删除用户*/
    public function delete(Request $request,$id)
    {
    	// $user_id = $request->all();
    	$where = ['user_id'=>$id];
    	$res = DB::table('user_info')->where($where)->delete();
    	if ($res) {
    		echo "<script>alert('删除成功');location='/user/list'</script>";
    	}else{
    		echo "<script>alert('删除失败');location='/user/list'</script>";
    	}
    }

    /*修改用户*/
    public function edit(Request $request,$id)
    {
    	$where = ['user_id'=>$id];
    	$data = DB::table('user_info')->where($where)->first();
    	return view('admin.user_edit',['data'=>$data]);
    }

    /*修改用户入库*/
    public function update(Request $request,$id)
    {
    	$data = $request->all();
    	unset($data['_token']);
        $headimg =$data['headimg']??'';
        
    	$validator = Validator::make($request->all(),[
    		'user_name'=>'required|unique:user_info|max:4'
    	],[
    		'user_name.required'=>'用户名不能为空',
            'user_name.unique'=>'用户名已存在',
            'user_name.max'=>'用户名最大4位'
    	]);
    	if ($validator->fails()) {
    		return redirect('user/edit/'.$id)
    		->withErrors($validator)
    		->withInput();
    	}
    	if(!$headimg){
            // echo ("<script>alert('未上传图片');location='/user/edit/'+$id</script>");die;
            echo ("<script>alert('未上传图片');history.back()</script>");die;
        }
    	if (request()->hasFile('headimg')) {
    		$data['headimg'] = $this->upload('headimg');
    	}
    	$where = ['user_id'=>$id];
    	$res = DB::table('user_info')->where($where)->update($data);
    	if ($res) {
    		echo "<script>alert('修改成功');location='/user/list'</script>";
    	}else{
    		echo "<script>alert('修改失败');location='/user/list'</script>";
    	}
    }
}
