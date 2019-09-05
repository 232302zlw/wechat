<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>详情</title>
</head>
<body>
    <table border="1" align="center" width="700">
        <tr align="center">
            <td>用户昵称</td>
            <td>用户ID</td>
            <td>用户头像</td>
            <td>所在城市</td>
        </tr>
        @foreach($info as $v)
            <tr align="center">
                <td>{{$v->nickname}}</td>
                <td>{{$v->openid}}</td>
                <td><img src="{{$v->headimgurl}}"></td>
                <td>{{$v->city}}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
