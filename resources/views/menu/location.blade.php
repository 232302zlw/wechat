<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
        <br>
        <h1 align="center">o(*￣▽￣*)o</h1>
    </table>
{{--    步骤一：绑定域名--}}
{{--    先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。--}}
{{--    备注：登录后可在“开发者中心”查看对应的接口权限。--}}

{{--    步骤二：↓↓↓↓引入JS文件↓↓↓↓--}}
    <script src="http://res.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
    <script>
        // 步骤三：↓↓↓↓通过config接口注入权限验证配置↓↓↓↓
        wx.config({
            debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
            appId: 'wxf3c63fea45354eec', // 必填，公众号的唯一标识
            timestamp: '{{$data['timestamp']}}', // 必填，生成签名的时间戳
            nonceStr: '{{$data['noncestr']}}', // 必填，生成签名的随机串
            signature: '{{$data['signature']}}',// 必填，签名
            jsApiList: ['openLocation','getLocation'] // 必填，需要使用的JS接口列表
        });

        // 步骤四：↓↓↓↓通过ready接口处理成功验证↓↓↓↓
        wx.ready(function(){
            // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
            // ↓↓↓↓获取地理位置接口↓↓↓↓
            wx.getLocation({
                type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
                success: function (res) {
                    var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                    var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                    var speed = res.speed; // 速度，以米/每秒计
                    var accuracy = res.accuracy; // 位置精度
                }
            });
        });
    </script>
</body>
</html>
