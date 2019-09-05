<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>广告-有点</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/css.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}" />
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
<!-- <script type="text/javascript" src="js/page.js" ></script> -->
</head>

<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="{{asset('img/coin02.png')}}" /><span>首页&nbsp;-&nbsp;</a>&nbsp;-</span>&nbsp;<a href="{{url('brand/create')}}">添加品牌</a>
			</div>
		</div>
		<div class="page">
			<!-- banner页面样式 -->
			<div class="banner">
				<div class="conform">
					<form>
						<div class="cfD">
							<input class="userinput" type="text" name="brand_name" placeholder="输入品牌关键字" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<!-- <input class="userinput vpr" type="text" name="brand_id" placeholder="输入用户序号关键字" /> -->
							<button class="userbtn">查找</button>
						</div>
					</form>
				</div>
				<!-- banner 表格 显示 -->
				<div class="banShow">
					<table border="1" cellspacing="0" cellpadding="0">
						<tr>
							<td width="215px" class="tdColor">商品序号</td>
							<td width="215px" class="tdColor">商品名称</td>
							<td width="215px" class="tdColor">商品价格</td>
							<td width="215px" class="tdColor">商品库存</td>
							<td width="215px" class="tdColor">商品图片</td>
							<td width="215px" class="tdColor">是否新品</td>
							<td width="215px" class="tdColor">是否精品</td>
							<td width="215px" class="tdColor">是否热销</td>
							<td width="215px" class="tdColor">是否上架</td>
							<td width="400px" class="tdColor">商品描述</td>
							<td width="215px" class="tdColor">所属品牌</td>
							<td width="215px" class="tdColor">所属分类</td>
							<td width="215px" class="tdColor">操作</td>
						</tr>
						@foreach($datas as $v)
						<tr>
							<td>{{$v->goods_id}}</td>
							<td>{{$v->goods_name}}</td>
							<td>{{$v->goods_price}}</td>
							<td>{{$v->goods_num}}</td>
							<td><img src="http://www.pic.com/{{$v->goods_img}}" height="100" /></td>
							<td>@if ($v->is_new==1) 是 @else 否 @endif</td>
							<td>@if ($v->is_best==1) 是 @else 否 @endif</td>
							<td>@if ($v->is_hot==1) 是 @else 否 @endif</td>
							<td>@if ($v->is_up==1) 是 @else 否 @endif</td>
							<td>{{$v->goods_describe}}</td>
							<td>{{$v->brand_name}}</td>
							<td>{{$v->cate_name}}</td>
							<td>
								<a href="{{url('goods/edit/'.$v->goods_id)}}">
									<img class="operation" src="{{asset('img/update.png')}}">
								</a> 
								<a href="{{url('goods/delete/'.$v->goods_id)}}">
									<img class="operation delban" src="{{asset('img/delete.png')}}">
								</a>
							</td>
						</tr>
						@endforeach
					</table>
					<!-- <div class="paging">此处是分页</div> -->
				</div>
				<!-- banner 表格 显示 end-->
			</div>
			<!-- banner页面样式end -->
		</div>
	</div>
</body>
</html>