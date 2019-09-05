<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>分类修改</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/css.css')}}" />
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
</head>
<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="{{asset('img/coin02.png')}}" /><span><a href="{{url('category/list')}}">首页</a>&nbsp;-&nbsp;<a
					href="#"></a>&nbsp;-</span>&nbsp;分类修改
			</div>
		</div>
		<div class="page ">
			<!-- 会员注册页面样式 -->
			<div class="banneradd bor">
				<div class="baTopNo">
					<span>分类修改</span>
				</div>
				<div class="baBody">
				<form action="{{url('category/update/'.$data[0]->cate_id)}}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="bbD">
						分类名称：<input type="text" class="input3" name="cate_name" value="{{$data[0]->cate_name}}" />@php echo $errors->first('cate_name'); @endphp
					</div>
					<div class="bbD">
						所属分类：<select class="input3" name="pid">
									<option value="0">顶级分类</option>
									@foreach($cateinfo as $v)
										<option value="{{$v['cate_id']}}" @if ($v['cate_id'] == $data[0]->pid) selected @endif >{{$v['cate_name']}}</option>
									@endforeach
								</select>
					</div>
					<div class="bbD">
						是否展示：
						<label>
							<input type="radio" name="is_show" value="1" @if ($data[0]->is_show=='1') checked @endif />是
						</label> 
						<label>
							<input type="radio" name="is_show" value="2" @if ($data[0]->is_show=='2') checked @endif />否
						</label>
					</div>
					<div class="bbD">
						导航展示：
						<label>
							<input type="radio" name="nav_show" value="1" @if ($data[0]->nav_show=='1') checked @endif />是
						</label> 
						<label>
							<input type="radio" name="nav_show" value="2" @if ($data[0]->nav_show=='2') checked @endif />否
						</label>
					</div>
					<div class="bbD">
						<p class="bbDP">
							<input type="submit" class="btn_ok btn_yes" value="提交" />
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