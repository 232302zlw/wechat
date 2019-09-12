<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>群发消息</title>
</head>
<body>
    <h1 align="center">群发消息</h1>
    <td><br></td>
    <form action="{{url('wechat/do_push_message')}}" method="post">
        @csrf
        <table border="0" align="center">
            <tr align="center">
                <td>
                    消息：
                </td>
                <td>
                    <textarea name="message" id="" cols="30" rows="10"></textarea>
                </td>
            </tr>
            <input type="hidden" name="tagid" value="{{$info}}">
            <td><br></td>
            <tr align="center">
                <td colspan="2" align="center">
                    <button>提交</button>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
