<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use App\Http\Requests\StudentBlogPost;

class StudentController extends Controller
{
    public function add()
    {
    	return view('admin.add');
    }

    public function do_add(Request $request)
    // 第二种验证方法（验证器）*********************************************
    // public function do_add(StudentBlogPost $request)
    {
        // 第一种验证方法**************************************************
        // $request->validate([
        //     's_name'=>'required|unique:info|max:4',
        //     's_age'=>'required|numeric',
        // ],[
        //     's_name.required'=>'学生姓名不能为空',
        //     's_name.unique'=>'学生姓名已存在',
        //     's_name.max'=>'学生姓名最大4位',
        //     's_age.required'=>'学生年龄不能为空',
        //     's_age.numeric'=>'学生年龄只能是数字'
        // ]);

        
        // 第三种验证方法**************************************************
    	$post = $request->all();
        $validator = Validator::make($request->all(),[
            's_name'=>'required|unique:info|max:4',
            's_age'=>'required|numeric',
        ],[
            's_name.required'=>'学生姓名不能为空',
            's_name.unique'=>'学生姓名已存在',
            's_name.max'=>'学生姓名最大4位',
            's_age.required'=>'学生年龄不能为空',
            's_age.numeric'=>'学生年龄只能是数字'
        ]);
        if ($validator->fails()) {
            return redirect('student/add')
            ->withErrors($validator)
            ->withInput();
        }
    	unset($post['_token']);
    	// dd($post);
    	$res = DB::table('info')->insertGetId($post);
    	if ($res) {
    		return redirect('student/list');
    	}
    }

    public function list(Request $request)
    {
    	$data = DB::table('info')->get();
    	return view('admin.list',['data'=>$data]);
    }
}
