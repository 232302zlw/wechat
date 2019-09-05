<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>添加</title>
</head>
<body>
	<!-- @if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif -->
	<form action="{{url('student/do_add')}}" method="post">
		<h1>学生添加</h1>
		@csrf
		<input type="text" name="s_name" placeholder="请输入学生姓名">@php echo $errors->first('s_name'); @endphp <br/>
		<input type="text" name="s_age" placeholder="请输入学生年龄">@php echo $errors->first('s_age') @endphp<br/>
		<input type="radio" name="s_sex" value="1">男
		<input type="radio" name="s_sex" value="2">女<br/>
		<button>提交</button>
	</form>
</body>
</html>