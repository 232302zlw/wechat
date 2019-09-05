<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>学生列表</title>
</head>
<body>
	<table border="1" align="center" width="500">
	<h1 align="center">学生列表</h1>
		<tr align="center">
			<td>学生ID</td>
			<td>学生姓名</td>
			<td>学生年龄</td>
			<td>学生性别</td>
		</tr>
		@foreach($data as $v)
		<tr align="center">
			<td>{{$v->s_id}}</td>
			<td>{{$v->s_name}}</td>
			<td>{{$v->s_age}}</td>
			<td>{{$v->s_sex}}</td>
		</tr>
		@endforeach
	</table>
</body>
</html>