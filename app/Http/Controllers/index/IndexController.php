<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\index\Users;
use App\index\Goods;
use App\index\Car;
use Validator;
use DB;
use Illuminate\Support\Facades\Redis;

class IndexController extends Controller
{
	/*前台首页视图展示*/
    public function index()
    {
        // Redis
        // Redis::set('name','123456');
        // echo Redis::get('name');

        // Memcache
//        $mem = new \Memcache;
//        $mem -> connect('127.0.0.1','11211');
//        // $memcache -> set('memcache','Never Say Die!',0,10);
//        // echo $memcache -> get('memcache');
//        // $datas = Student::get();
//
//        // 取memcache
//        $is_new = $mem -> get('is_new');
//        if (empty($is_new)) {
//            $datas = json_encode(Goods::where(['is_new'=>1,'is_up'=>1])->get());
//            $mem -> set('is_new',$datas,0,3600);
//        }
//
//        $is_hot = $mem -> get('is_hot');
//        if (empty($is_hot)) {
//            $datas = json_encode(Goods::where(['is_hot'=>1,'is_up'=>1])->get());
//            $mem -> set('is_hot',$datas,0,3600);
//        }


        // dump($is_new);
        // dump($is_hot);die;
         $is_new = Goods::where(['is_new'=>1,'is_up'=>1])->get();
         $is_hot = Goods::where(['is_hot'=>1,'is_up'=>1])->get();
//         dump($is_hot);
//         dd($is_new);
	    $user = request()->session()->get('user');
//    	return view('index.index',['user'=>$user,'is_new'=>json_decode($is_new),'is_hot'=>json_decode($is_hot)]);
    	return view('index.index',['user'=>$user,'is_new'=>$is_new,'is_hot'=>$is_hot]);
    }

    /*商品详情视图*/
    public function detail(Request $request,$id)
    {
        $info = Goods::where('goods_id',$id)->first();
        // dump($info);
        return view('index.detail',['info'=>$info]);
    }

    /*添加商品到购物车*/
    public function add_car(Request $request,$id)
    {
        $user = request()->session()->get('user');
        $data['user_id'] = $user['id'];
        $data['goods_id'] = $id;
        $res = Car::insertGetId($data);
        if ($res) {
            echo "<script>alert('添加成功');history.back()</script>";
        }else{
            echo "<script>alert('未知错误');history.back()</script>";
        }
    }

    /*购物车视图*/
    public function car()
    {
        $user = request()->session()->get('user');
        $user_id = $user['id'];
        $num = Car::count();
        $info = DB::table('car_info')
            ->where(['user_id'=>$user_id])
            ->join('goods_info','car_info.goods_id','=','goods_info.goods_id')
            ->get()->toArray();
        return view('index.car',['info'=>$info,'num'=>$num]);
    }

    /*支付视图*/
    public function pay()
    {
        return view('index.pay');
    }









    /*用户详情视图*/
    public function user()
    {
    	$user = request()->session()->get('user');
    	return view('index.user',['user'=>$user]);
    }

    /*用户信息修改视图*/
    public function info()
    {
    	$user = request()->session()->get('user');
    	$info = Users::where('id',$user['id'])->first();
    	return view('index.info',['user'=>$user,'info'=>$info]);
    }

    /*用户修改信息处理入库*/
    public function do_info(Request $request)
    {
    	$data = $request->all();
    	unset($data['_token']);
    	// $headimg = $data['headimg']??'';
        $data['updated_at'] = time();
    	$validator = Validator::make($request->all(),[
    		'name' => 'required|max:6',
    		'email' => 'required',
    	],[
    		'name.required' => '昵称不能为空',
    		'name.max' => '昵称最长6位',
    		'email.required' => '邮箱不能为空',
    	]);
    	if ($validator->fails()) {
    		return redirect('index/info')
    		->withErrors($validator)
    		->withInput();
    	}
    	// if (!$headimg) {
    	// 	echo "<script>alert('未上传图片');history.back()</script>";die;
    	// }
    	if (request()->hasFile('headimg')) {
            $data['headimg'] = $this->upload('headimg');
        }
        Request()->session()->pull('user');
        $info = Users::where('id',$data['id'])->first();
        $user = [
            'id' => $info['id'],
            'name' => $info['name'],
            'email' => $info['email'],
            'headimg' => $info['headimg'],
        ];
        // dd($user);
        Request()->session()->put('user',$user);
        $session = Request()->session()->get('user');
        if (!$session) {
            echo "<script>alert('修改失败，稍后再试');location='/index/user'</script>";die;
        }
        $res = Users::where('id',$data['id'])->update($data);
        if ($res) {
            echo "<script>alert('修改成功');location='/index/user'</script>";
        }else{
            echo "<script>alert('修改失败，稍后再试');location='/index/user'</script>";die;
        }
    }

    /*文件上传方法*/
    public function upload($name)
    {
        if (request()->file($name)->isValid()) {
            $headimg = request()->file($name);
            $store = $headimg->store('index','public');
            return $store;
        }
        exit('未知错误');
    }

    /*退出登录*/
    public function logout()
    {
        // $res = request()->session()->pull('user');
        $res = request()->session()->flush('user');
        if (!$res) {
            echo "<script>alert('退出成功');location='/'</script>";
        }
    }
}
