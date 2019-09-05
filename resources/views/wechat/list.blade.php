<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>列表</title>
</head>
<body>
	<table border="1" width="700" align="center">
		<tr align="center">
			<td>用户昵称</td>
			<td>用户ID</td>
			<td>操作</td>
		</tr>
        @foreach($info as $v)
            <tr align="center">
                <td>{{$v->nickname}}</td>
                <td>{{$v->openid}}</td>
                <td><a href="{{url('wechat/detail')}}">查看详情</a></td>
            </tr>
        @endforeach
	</table>
</body>
</html>
