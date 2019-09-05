<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加用户-有点</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/css.css')}}" />
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
</head>
<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="{{asset('img/coin02.png')}}" /><span><a href="{{url('user/list')}}">首页</a>&nbsp;-&nbsp;<a
					href="#"></a>&nbsp;-</span>&nbsp;管理添加
			</div>
		</div>
		<div class="page ">
			<!-- 会员注册页面样式 -->
			<div class="banneradd bor">
				<div class="baTopNo">
					<span>会员注册</span>
				</div>
				<div class="baBody">
					<form action="{{url('goods/save')}}" method="post" enctype="multipart/form-data">
						@csrf
						<div class="bbD">
							商品名称：<input type="text" class="input3" name="goods_name" />@php echo $errors->first('goods_name'); @endphp
						</div>
						<div class="bbD">
							商品价格：<input type="text"
								class="input3" name="goods_price" />@php echo $errors->first('goods_price'); @endphp
						</div>
						<div class="bbD">
							商品库存：<input type="text"
								class="input3" name="goods_num" />@php echo $errors->first('goods_num'); @endphp
						</div>
						<div class="bbD">
							商品图片：<input type="file" name="goods_img" />
						</div>
						<div class="bbD">
							是否新品：
							<label>
								<input type="radio" name="is_new" value="1" />是
							</label> 
							<label>
								<input type="radio" name="is_new" value="2" checked="checked" />否
							</label>
						</div>
						<div class="bbD">
							是否精品：
							<label>
								<input type="radio" name="is_best" value="1" />是
							</label> 
							<label>
								<input type="radio" name="is_best" value="2" checked="checked" />否
							</label>
						</div>
						<div class="bbD">
							是否热销：
							<label>
								<input type="radio" name="is_hot" value="1" />是
							</label> 
							<label>
								<input type="radio" name="is_hot" value="2" checked="checked" />否
							</label>
						</div>
						<div class="bbD">
							是否上架：
							<label>
								<input type="radio" name="is_up" value="1" />是
							</label> 
							<label>
								<input type="radio" name="is_up" value="2" checked="checked" />否
							</label>
						</div>
						<div class="bbD">
							所属品牌：<select class="input3" name="brand_id">
											<option value="">请选择品牌</option>
										@foreach($brandInfo as $b)
											<option value="{{$b['brand_id']}}">{{$b['brand_name']}}</option>
										@endforeach
									</select>
						</div>
						<div class="bbD">
							所属分类：<select class="input3" name="cate_id">
											<option value="">请选择分类</option>
										@foreach($cateInfo as $c)
											<option value="{{$c['cate_id']}}">{{$c['cate_name']}}</option>
										@endforeach
									</select>
						</div>
						<div class="bbD">
							网站介绍：
							<div class="btext2">
								<textarea class="text2" name="goods_describe"></textarea>
							</div>
						</div>
						<div class="bbD">
							<p class="bbDP">
								<input type="submit" class="btn_ok btn_yes" value="提交" />
								<a class="btn_ok btn_no" href="#">取消</a>
							</p>
						</div>
					</form>
				</div>
			</div>

			<!-- 会员注册页面样式end -->
		</div>
	</div>
</body>
</html>