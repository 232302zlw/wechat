<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>菜单列表</title>
</head>
<body>
    <h2 align="center">菜单列表（数据库）</h2>
    <br>
    <table border="1" align="center" width="1000">
        <tr align="center">
            <td>序号</td>
            <td>一级名称</td>
            <td>二级名称</td>
            <td>click/view</td>
            <td>层级类型</td>
            <td>url/key</td>
        </tr>
        @foreach($info as $v)
        <tr align="center">
            <td>{{$v['id']}}</td>
            <td>{{$v['name1']}}</td>
            <td>{{$v['name2']}}</td>
            <td>@if($v['type'] == 1) click @else view @endif</td>
            <td>@if($v['button_type'] == 1) 一级 @else 二级 @endif</td>
            <td>{{$v['event_value']}}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
