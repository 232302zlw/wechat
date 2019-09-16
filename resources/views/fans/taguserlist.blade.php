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
<form action="{{url('wechat/tag_openid')}}" method="post">
    @csrf
    <table border="1" width="700" align="center">
        <tr align="center">
            <td></td>
            <td>用户昵称</td>
            <td>用户openid</td>
            <td>用户操作</td>
        </tr>
        <input type="hidden" name="tagid" value="{{$tagid}}">
        @foreach($info as $v)
            <tr align="center">
                <td><input type="checkbox" name="openid_list[]" value="{{$v['openid']}}"></td>
                <td>{{$v['nickname']}}</td>
                <td>{{$v['openid']}}</td>
                <td>
                    <a href="{{url('wechat/usertaglist')}}?openid={{$v['openid']}}">用户标签</a>
                </td>
            </tr>
        @endforeach
        <tr>
            <td align="left" colspan="4">
                <button>提交</button>
            </td>
        </tr>
    </table>
</form>
</body>
</html>
