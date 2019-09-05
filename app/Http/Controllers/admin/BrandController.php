<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\admin\Brand;
use Validator;

class BrandController extends Controller
{
	/*品牌列表视图*/
    public function list(Request $request)
    {
        $query = request()->input();
        $brand_name = $query['brand_name']??'';
        $where = [];
        if ($brand_name) {
            $where[] = ['brand_name','like',"%$brand_name%"];
        }
        $pageSize = config('app.pageSize');
        $data = DB::table('brand_info')->where($where)->paginate($pageSize);
    	return view('admin.brand_list',compact('data','query','brand_name'));
    }

    /*品牌添加视图*/
    public function create()
    {
    	return view('admin.brand_create');
    }

    /*品牌添加处理入库*/
    public function save(Request $request)
    {
    	$data = $request->all();
    	unset($data['_token']);
        $brand_img = $data['brand_img']??'';
    	// dd($data);
    	$validator = Validator::make($request->all(),[
    		'brand_name'=>'required|unique:brand_info|max:10',
    		'brand_url'=>'required'
    	],[
    		'brand_name.required'=>'品牌名称不能为空',
    		'brand_name.unique'=>'品牌名称已存在',
    		'brand_name.max'=>'品牌名称最多10个字节',
    		'brand_url.required'=>'链接地址不能为空'
    	]);
    	if ($validator->fails()) {
    		return redirect('brand/create')
    		->withError($validator)
    		->withInput();
    	}
        if (!$brand_img) {
            echo "<script>alert('未上传图片');history.back()</script>";die;
        }
    	if (request()->hasFile('brand_img')) {
    		$data['brand_img'] = $this->upload('brand_img');
    	}

    	$res = DB::table('brand_info')->insertGetId($data);
    	if ($res) {
    		echo "<script>alert('添加成功');location='/brand/list'</script>";
    	}else{
            echo "<script>alert('添加失败');location='/brand/list'</script>";
        }
    }

    /*文件上传*/
	public function upload($name)
	{
		if (request()->file($name)->isValid()) {
			$brand_img = request()->file($name);
			$store_result = $brand_img->store('','public');
			return $store_result;
		}
		exit('未上传文件');
	}

    /*品牌修改*/
    // public function edit($brand_id)
    public function edit(Request $request,$id)
    {
        // $brand_id = request()->input();
        // dd($id);
        $where = ['brand_id'=>$id];
        $data = DB::table('brand_info')->where($where)->first();
        // $data = DB::table('brand_info')->find($id);
        return view('admin.brand_edit',['data'=>$data]);
    }

    /*品牌修改处理入库*/
    public function update(Request $request,$id)
    {
        $data = request()->all();
        unset($data['_token']);
        $brand_img = $data['brand_img']??'';
        // dd($data);
        // $validator = Validator::make($request->all(),[
        //     'brand_name' => 'required|unique:brand_info|max:10',
        //     'brand_url'=>'required',
        // ],[
        //     'brand_name.required'=>'品牌名称不能为空',
        //     'brand_name.unique'=>'品牌名称已存在',
        //     'brand_name.max'=>'品牌名称最多10个字节',
        //     'brand_url.required'=>'链接地址不能为空',
        // ]);
        // if ($validator->fails()) {
        //     return redirect('brand/edit/'.$id)
        //     ->withErrors($validator)
        //     ->withInput();
        // }hhm 
        if (!$brand_img) {
            echo "<script>alert('未上传图片');history.back()</script>";die;
        }
        if (request()->hasfile('brand_img')) {
            $data['brand_img'] = $this->upload('brand_img');
        }
        $where = ['brand_id'=>$id];
        $res = DB::table('brand_info')->where($where)->update($data);
        if ($res) {
            echo "<script>alert('修改成功');location='/brand/list'</script>";
        }else{
            echo "<script>alert('修改失败');history.back()</script>";
        }
    }

    /*品牌删除*/
    public function delete(Request $request,$id)
    {
        // $brand_id = request()->all();
        $where = ['brand_id'=>$id];
        $res = DB::table('brand_info')->where($where)->delete();
        if ($res) {
            echo "<script>alert('删除成功');location='/brand/list'</script>";
        }else{
            echo "<script>alert('删除失败');location='/brand/list'</script>";
        }
    }



    public function brand_list(Request $request)
    {
        $search = $request->all();
        $brand_name = $search['brand_name']??'';
        $where = [];
        if ($brand_name) {
            $where[] = ['brand_name','like',"%$brand_name%"];
        }
        // dump($where);
        $datas = Brand::where($where)->paginate(1);
        // dd($datas);
        return view('brand_list',compact('datas','search','brand_name'));
    }
}
