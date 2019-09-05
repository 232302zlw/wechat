@extends('layout.layout')
@section('content')
    <div class="head-top">
      <img src="images/head.jpg" />
    </div>
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
    <div class="page ">
      <!-- 上传广告页面样式 -->
      <div class="banneradd bor">
        <div class="baTop">
          <span>修改信息</span>
        </div>
        <form action="{{url('index/do_info')}}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="baBody">
            <div class="bbD">
              用户昵称：<input type="text" class="input1" name="name" value="{{$info['name']}}" />@php echo $errors->first('name'); @endphp
            </div>
            <div class="bbD">
              用户邮箱：<input type="text" class="input1" name="email" value="{{$info['email']}}" />@php echo $errors->first('email') @endphp
            </div>
            <div class="bbD">
              上传头像：<input type="file" name="headimg" />
                      @if ($info['headimg']=='') @else <pre>&nbsp;</pre><img src="http://www.pic.com/{{$info['headimg']}}" height="100px" /> @endif
            </div>
            <input type="hidden" name="id" value="{{$info['id']}}" />
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
@include('layout.footer')
@endsection