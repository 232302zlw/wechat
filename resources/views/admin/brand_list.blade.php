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
							<td width="66px" class="tdColor tdC">品牌序号</td>
							<td width="315px" class="tdColor">品牌图片</td>
							<td width="308px" class="tdColor">品牌名称</td>
							<td width="450px" class="tdColor">链接地址</td>
							<td width="215px" class="tdColor">是否显示</td>
							<!-- <td width="180px" class="tdColor">排序</td> -->
							<td width="125px" class="tdColor">操作</td>
						</tr>
						@foreach($data as $v)
						<tr>
							<td>{{$v->brand_id}}</td>
							<td>
								<div class="bsImg">
									<img src="http://www.pic.com/{{$v->brand_img}}" height="100">
								</div>
							</td>
							<td>{{$v->brand_name}}</td>
							<td>
								<a class="bsA" href="{{$v->brand_url}}">{{$v->brand_url}}</a>
							</td>
							<td>{{$v->brand_status}}</td>
							<td>
								<a href="{{url('brand/edit/'.$v->brand_id)}}">
									<img class="operation" src="{{asset('img/update.png')}}">
								</a> 
								<a href="{{url('brand/delete/'.$v->brand_id)}}">
									<img class="operation delban" src="{{asset('img/delete.png')}}">
								</a>
							</td>
						</tr>
						@endforeach
					</table>
					<p>{{$data->appends($query)->links()}}</p>
					<!-- <div class="paging">此处是分页</div> -->
				</div>
				<!-- banner 表格 显示 end-->
			</div>
			<!-- banner页面样式end -->
		</div>

	</div>


	<!-- 删除弹出框 -->
	<div class="banDel">
		<div class="delete">
			<div class="close">
				<a><img src="img/shanchu.png" /></a>
			</div>
			<p class="delP1">你确定要删除此条记录吗？</p>
			<p class="delP2">
				<a href="#" class="ok yes" onclick="del()">确定</a><a class="ok no">取消</a>
			</p>
		</div>
	</div>
	<!-- 删除弹出框  end-->
</body>

<!-- <script type="text/javascript">
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

function del(){
    var input=document.getElementsByName("check[]");
    for(var i=input.length-1; i>=0;i--){
       if(input[i].checked==true){
           //获取td节点
           var td=input[i].parentNode;
          //获取tr节点
          var tr=td.parentNode;
          //获取table
          var table=tr.parentNode;
          //移除子节点
          table.removeChild(tr);
        }
    }     
}
</script> -->
</html>