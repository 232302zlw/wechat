<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h3>文件上传</h3>
{{--    访问图片路径--}}
<img src="{{asset('storage/Z57s42KR1LHv0RR2GYykvF9uKtI3QxZjxTdLGYeC.jpeg')}}" width="120" height="120"  alt="">
<form action="{{url('wechat/upload_do')}}" method="post" enctype="multipart/form-data">
    @csrf
    <select name="type">
        <option value="1">图片</option>
        <option value="2">音频</option>
        <option value="3">视频</option>
        <option value="4">缩略图</option>
    </select>
    <input type="file" name="file_name">
    <input type="submit" value="上传文件">
</form>
</body>
</html>
