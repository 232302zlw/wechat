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
    <h2 align="center">创建菜单</h2>
    <form action="{{url('menu/save_menu')}}" method="post">
        @csrf
        <table align="center">
            <tr>
                <td>一级菜单</td>
                <td>
                    <input type="text" name="name1" id="">
                </td>
            </tr>
            <tr>
                <td>二级菜单</td>
                <td>
                    <input type="text" name="name2" id="">
                </td>
            </tr>
            <tr>
                <td>菜单类型[click/view]</td>
                <td>
                    <select name="type" id="">
                        <option value="1">click</option>
                        <option value="2">view</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>事件值</td>
                <td>
                    <input type="text" name="event_value" id="">
                </td>
            </tr>
            <td>&nbsp;</td>
            <tr>
                <td align="center" colspan="2">
                    <button>提交</button>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
