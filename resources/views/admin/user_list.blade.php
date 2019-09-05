<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员管理-有点</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/css.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}" />
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
<!-- <script type="text/javascript" src="js/page.js" ></script> -->
</head>

<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="{{asset('img/coin02.png')}}" /><span>管理列表&nbsp;-&nbsp;-</span>&nbsp;<a href="{{url('user/create')}}">管理添加</a>
			</div>
		</div>

		<div class="page">
			<!-- user页面样式 -->
			<div class="connoisseur">
				<div class="conform">
					<form>
						<div class="cfD">
							<input class="userinput" type="text" name="user_name" placeholder="输入用户名关键字" />&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;
							<input class="userinput vpr" type="text" name="user_id" placeholder="输入用户序号关键字" />
							<button class="userbtn">查找</button>
							<!-- <a href="{{url('user/create')}}" class="userbtn">添加管理</a> -->
						</div>
					</form>
				</div>
				<!-- user 表格 显示 -->
				<div class="conShow">
					<table border="1" cellspacing="0" cellpadding="0">
						<tr>
							<td width="66px" class="tdColor tdC">序号</td>
							<td width="435px" class="tdColor">用户名</td>
							<td width="400px" class="tdColor">头像</td>
							<td width="630px" class="tdColor">添加时间</td>
							<td width="130px" class="tdColor">操作</td>
						</tr>
						@foreach($data as $v)
						<tr height="40px">
							<td>{{$v->user_id}}</td>
							<td>{{$v->user_name}}</td>
							<td><img class="operation" src="http://www.pic.com/{{$v->headimg}}" height="100"></td>
							<td>{{date('Y-m-d H:i:s',$v->create_time)}}</td>
							<td>
								<a href="{{url('user/edit/'.$v->user_id)}}">
									<img class="operation" src="{{asset('img/update.png')}}">
								</a> 
								<a href="{{url('user/delete/'.$v->user_id)}}">
									<img class="operation " src="{{asset('img/delete.png')}}">
								</a>
							</td>
						</tr>
						@endforeach
					</table>
					<p>{{$data->appends($query)->links()}}</p>
					<!-- <div class="paging">此处是分页</div> -->
				</div>
				<!-- user 表格 显示 end-->
			</div>
			<!-- user页面样式end -->
		</div>

	</div>


	<!-- 删除弹出框 -->
	<div class="banDel">
		<div class="delete">
			<div class="close">
				<a><img src="{{asset('img/shanchu.png')}}" /></a>
			</div>
			<p class="delP1">你确定要删除此条记录吗？</p>
			<p class="delP2">
				<a href="#" class="ok yes">确定</a><a class="ok no">取消</a>
			</p>
		</div>
	</div>
	<!-- 删除弹出框  end-->
</body>

<script type="text/javascript">
// 广告弹出框
$(".delban").click(function(){
  $(".banDel").show();
});
$(".close").click(function(){
  $(".banDel").hide();
});
$(".no").click(function(){
  $(".banDel").hide();
});
// 广告弹出框 end
</script>
</html>