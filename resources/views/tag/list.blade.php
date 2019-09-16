<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>微信公众号标签管理</title>
</head>
<body>
    <h1 align="center">微信公众号标签管理</h1>
    <h3 align="center"><a href="{{url('wechat/addtag')}}">添加标签</a>&ensp;&ensp;&ensp;&ensp;<a href="{{url('wechat/userlist')}}">关注列表</a></h3>
    <table border="1" width="800" align="center">
        <tr align="center">
            <td>标签ID</td>
            <td>标签名称</td>
            <td>粉丝数量</td>
            <td width="150">标签操作</td>
            <td width="200">粉丝操作</td>
            <td width="100">用户操作</td>
        </tr>
        @foreach($info as $v)
        <tr align="center">
            <td>{{$v['id']}}</td>
            <td>{{$v['name']}}</td>
            <td>{{$v['count']}}</td>
            <td>
                <a href="{{url('wechat/edittag')}}?id={{$v['id']}}&name={{$v['name']}}">修改</a> |
                <a href="{{url('wechat/deletetag/'.$v['id'])}}">删除</a>
            </td>
            <td>
                <a href="{{url('/wechat/fanslist')}}?tagid={{$v['id']}}">粉丝列表</a> |
                <a href="{{url('/wechat/push_message')}}?tagid={{$v['id']}}">推送消息</a>
            </td>
            <td>

                <a href="{{url('/wechat/taguserlist')}}?tagid={{$v['id']}}">用户加标签</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>
