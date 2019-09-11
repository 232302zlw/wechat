<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>修改标签</title>
</head>
<body>
<form action="{{url('wechat/updatetag')}}" method="post">
    @csrf
    <table align="center">
        <h1 align="center">标签修改</h1>
        <tr>
            <td>
                标签名称：<input type="text" name="name" value="{{$name}}">
                <input type="hidden" name="id" value="{{$id}}">
            </td>
        </tr>
        <td><br></td>
        <tr>
            <td align="center">
                <button>修改</button>
            </td>
        </tr>
    </table>
</form>
</body>
</html>
