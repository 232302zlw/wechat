<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>品牌列表</title>
	<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}" />
</head>
<body>
	<pre>&nbsp;</pre>
	<form>
		&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
		<input type="text" name="brand_name" placeholder="      请输入品牌关键字   ">
		<button>查询</button>
	</form>
	<table border="1" align="center" width="690">
		<tr align="center">
			<td>品牌ID</td>
			<td>品牌名称</td>
			<td>链接地址</td>
			<td>品牌图片</td>
			<td>品牌状态</td>
		</tr>
		@foreach($datas as $v)
		<tr align="center">
			<td>{{$v->brand_id}}</td>
			<td>{{$v->brand_name}}</td>
			<td><a href="{{$v->brand_url}}">{{$v->brand_url}}</a></td>
			<td><img src="http://www.pic.com/{{$v->brand_img}}" height="100px"></td>
			<td>@if ($v->brand_status==1) 使用 @else 禁用 @endif</td>
		</tr>
		@endforeach
		<tr>
			<td align="center" colspan="5">
				<p>{{$datas->appends($search)->links()}}</p>
			</td>
		</tr>
	</table>
</body>
</html>