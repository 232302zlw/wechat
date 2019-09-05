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
				<form action="{{url('user/save')}}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;用户名：<input type="text" class="input3" name="user_name" />@php echo $errors->first('user_name'); @endphp
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;密码：<input type="password"
							class="input3" name="user_pwd" />@php echo $errors->first('user_pwd'); @endphp
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;头像：<input type="file" name="headimg" />
					</div>
					<!-- <div class="bbD">
						用户等级：<input type="password" class="input3" />
					</div> -->
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