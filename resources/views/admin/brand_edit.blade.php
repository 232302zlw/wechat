<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>头部-有点</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/css.css')}}" />
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
</head>
<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="{{asset('img/coin02.png')}}" /><span><a href="{{url('brand/list')}}">首页</a>&nbsp;-&nbsp;&nbsp;-</span>&nbsp;品牌修改
			</div>
		</div>
		<div class="page ">
			<!-- 上传广告页面样式 -->
			<div class="banneradd bor">
				<div class="baTop">
					<span>上传广告</span>
				</div>
				<form action="{{url('brand/update/'.$data->brand_id)}}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="baBody">
						<div class="bbD">
							品牌名称：<input type="text" class="input1" name="brand_name" value="{{$data->brand_name}}" />
						</div>
						<div class="bbD">
							链接地址：<input type="text" class="input1" name="brand_url" value="{{$data->brand_url}}" />
						</div>
						<div class="bbD">
							上传图片：
							<div class="bbD">
								&ensp;&ensp;&ensp;&ensp;&ensp;<input type="file" name="brand_img" />
								<img src="http://www.pic.com/{{$data->brand_img}}" height="100" />
							</div>
						</div>
						<div class="bbD">
							是否展示：
							<label>
								<input type="radio" name="brand_status" @if ($data->brand_status=='1') checked @endif value="1" />是
							</label> 
							<label>
								<input type="radio" name="brand_status" @if ($data->brand_status=='2')  checked @endif  value="2" />否
							</label>
						</div>
						<!-- <div class="bbD">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;排序：<input class="input2"
								type="text" />
						</div> -->
						<div class="bbD">
							<p class="bbDP">
								<input type="submit" class="btn_ok btn_yes" value="提交" />
								<a class="btn_ok btn_no" href="#">取消</a>
							</p>
						</div>
					</div>
				</form>
			</div>

			<!-- 上传广告页面样式end -->
		</div>
	</div>
</body>
</html>