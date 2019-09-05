<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\admin\Goods;
use App\admin\Category;
use App\admin\Brand;
use Validator;

class GoodsController extends Controller
{
    public function list()
    {
        $datas = Goods::get();
        foreach ($datas as $k => $v) {
            // echo $v->brand_id;
            $datas[$k]['brand_name'] = Brand::where('brand_id',$v->brand_id)->value('brand_name');
        }
        foreach ($datas as $k => $v) {
            $datas[$k]['cate_name'] = Category::where('cate_id',$v->cate_id)->value('cate_name');
        }
    	return view('admin.goods_list',['datas'=>$datas]);
    }

    /*商品添加视图*/
    public function create()
    {
    	$brandInfo = Brand::get()->toArray();
    	$cateInfo = Category::get()->toArray();
    	return view('admin.goods_create',['brandInfo'=>$brandInfo,'cateInfo'=>$cateInfo]);
    }

    /*商品添加处理入库*/
    public function save(Request $request)
    {
    	$data = $request->all();
    	unset($data['_token']);
        $goods_img = $data['goods_img']??'';
        // dd($data);
    	$validator = Validator::make($request->all(),[
            'goods_name' => 'required|max:10',
            'goods_price' => 'required',
            'goods_num' => 'required',
    	],[
            'goods_name.required' => '商品名称不能为空',
            'goods_name.max' => '商品名称最大10位',
            'goods_price.required' => '商品价格不能为空',
            'goods_num.required' => '商品库存不能为空',
    	]);
    	if ($validator->fails()) {
    		return redirect('goods/create')
    		->withErrors($validator)
    		->withInput();
    	}
        if (!$goods_img) {
            echo "<script>alert('未上传图片');history.back()</script>";die;
        }
        if (request()->hasFile('goods_img')) {
            $data['goods_img'] = upload('goods_img');
        }

        $res = Goods::insertGetId($data);
        if ($res) {
            echo "<script>alert('添加成功');location='/goods/list'</script>";
        }else{
            echo "<script>alert('添加失败');history.back()</script>";
        }
    }
}
