<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>用户列表</title>
</head>
<body>
<h1 align="center">用户列表</h1>
<form>
    @csrf
    <table border="1" width="700" align="center">
        <tr align="center">
            <td>用户昵称</td>
            <td>用户openid</td>
            <td>分享二维码</td>
            <td>操作</td>
        </tr>
        @foreach($info as $v)
            <tr align="center">
                <td>{{$v['id']}}</td>
                <td>{{$v['name']}}</td>
                <td><img src="{{asset($v['qrcode_url'])}}" width="100px"></td>
                <td>
                    <a href="{{url('agent/create_qrcode')}}?id={{$v['id']}}">生成二维码</a>
                </td>
            </tr>
        @endforeach
    </table>
</form>
</body>
</html>
