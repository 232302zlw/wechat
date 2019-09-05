<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>分类管理</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/css.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}" />
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
<!-- <script type="text/javascript" src="js/page.js" ></script> -->
</head>

<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="{{asset('img/coin02.png')}}" /><span>首页&nbsp;-&nbsp;</a>&nbsp;-</span>&nbsp;<a href="{{url('category/create')}}">添加分类</a>
			</div>
		</div>
		<div class="page">
			<!-- banner页面样式 -->
			<div class="banner">
				<div class="conform">
					<form>
						<div class="cfD">
							<input class="userinput" type="text" name="cate_name" placeholder="输入品牌关键字" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<!-- <input class="userinput vpr" type="text" name="brand_id" placeholder="输入用户序号关键字" /> -->
							<button class="userbtn">查找</button>
						</div>
					</form>
				</div>
				<!-- banner 表格 显示 -->
				<div class="banShow">
					<table border="1" cellspacing="0" cellpadding="0">
						<tr>
							<td width="100px" class="tdColor tdC">分类序号</td>
							<td width="400px" class="tdColor">分类名称</td>
							<td width="300px" class="tdColor">是否显示</td>
							<td width="300px" class="tdColor">是否导航显示</td>
							<td width="200px" class="tdColor">操作</td>
						</tr>
						@foreach($data as $v)
						<tr>
							<td height="50">{{$v->cate_id}}</td>
							<td>{{$v->cate_name}}</td>
							<td>{{$v->is_show}}</td>
							<td>{{$v->nav_show}}</td>
							<td>
								<a href="{{url('category/edit/'.$v->cate_id)}}">
									<img class="operation" src="{{asset('img/update.png')}}">
								</a> 
								<a href="{{url('category/delete/'.$v->cate_id)}}">
									<img class="operation delban" src="{{asset('img/delete.png')}}">
								</a>
							</td>
						</tr>
						@endforeach
						<tr>
							<td colspan="6" align="center">
								{{$data->appends($search)->links()}}
							</td>
						</tr>
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