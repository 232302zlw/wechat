<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\admin\Category;
use Validator;
use DB;

class CategoryController extends Controller
{
	/*分类列表视图*/
	public function list(Request $request)
	{
		$search = $request->input();
		$cate_name = $search['cate_name']??'';
		$pageSize = config('app.pageSize');
		// $where = ['cate_name','like',"%$cate_name%"];
		$data = Category::where('cate_name','like',"%$cate_name%")->paginate($pageSize);
		// dd($data);
		// $data = Category::get();
		return view('admin.category_list',compact('data','search','cate_name'));
	}

	/*分类添加视图*/
    public function create()
    {
    	$data = Category::get()->toArray();
    	return view('admin.category_create',['data'=>$data]);
    }

    /*分类添加处理入库*/
    public function save(Request $request)
    {
    	$data = $request->all();
    	unset($data['_token']);
    	// dd($data);
    	$validator = Validator::make($request->all(),[
    		'cate_name' => 'required|unique:category_info|max:6',
    	],[
    		'cate_name.required' => '分类名称不能为空',
    		'cate_name.unique' => '分类名称已存在',
    		'cate_name.max' => '分类名称不超过6位',
    	]);
    	if ($validator->fails()) {
    		return redirect('category/create')
    		->withErrors($validator)
    		->withInput();
    	}
    	$res = Category::insertGetId($data);
    	if ($res) {
    		echo "<script>alert('添加成功');location='/category/list'</script>";
    	}else{
    		echo "<script>alert('添加失败');history.back()</script>";
    	}
    }

    /*分类修改视图*/
    public function edit(Request $request,$id)
    {
    	$where = ['cate_id'=>$id];
    	$data = Category::where($where)->get();
    	// dump($data[0]->cate_id);
    	$cateinfo = Category::get();
    	// dd($cateinfo);
    	// dump($cateinfo[0]->cate_id);
    	return view('admin.category_update',['data'=>$data,'cateinfo'=>$cateinfo]);
    }

    /*分类修改处理入库*/
    public function update(Request $request,$id)
    {
    	$data = $request->all();
    	unset($data['_token']);
    	$validator = Validator::make($request->all(),[
    		'cate_name' => 'required|unique:category_info|max:6',
    	],[
    		'cate_name.required' => '分类名称不能为空',
    		'cate_name.unique' => '分类名称已存在',
    		'cate_name.max' => '分类名称不超过6位',
    	]);
    	if ($validator->fails()) {
    		return redirect('category/edit/'.$id)
    		->withErrors($validator)
    		->withInput();
    	}
    	$res = Category::where('cate_id',$id)->update($data);
    	if ($res) {
    		echo "<script>alert('修改成功');location='/category/list'</script>";
    	}else{
    		echo "<script>alert('修改失败');history.back()</script>";
    	}
    }

    /*删除分类*/
    public function delete(Request $request,$id)
    {
    	$res = Category::where('cate_id',$id)->delete();
    	if ($res) {
    		echo "<script>alert('删除成功');location='/category/list'</script>";
    	}else{
    		echo "<script>alert('删除失败');location='/category/list'</script>";
    	}
    }
}
