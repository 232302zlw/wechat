<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>用户标签列表</title>
</head>
<body>
    <table border="1" width="300" align="center">
        <tr align="center">
            <td>该用户所拥有的标签</td>
        </tr>
        @foreach($info as $v)
            <tr align="center">
                <td>{{$v}}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
