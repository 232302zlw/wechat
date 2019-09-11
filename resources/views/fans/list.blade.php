<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>粉丝列表</title>
</head>
<body>
    <table border="1" width="700" align="center">
        <tr align="center">
            <td>粉丝昵称</td>
            <td>粉丝openid</td>
            <td>粉丝操作</td>
        </tr>
        @foreach($info as $v)
        <tr align="center">
            <td></td>
            <td>{{$v['openid']}}</td>
            <td>
                <a href="">查看</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>
