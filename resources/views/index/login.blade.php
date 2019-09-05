@extends('layout.layout')
@section('content')
<header>
  <a href="javascript:history.back(-1)" class="back-off fl">
    <span class="glyphicon glyphicon-menu-left"></span>
  </a>

  <div class="head-mid">
    <h1>会员注册</h1>
  </div>
</header>

  <div class="head-top">
    <img src="/index/images/head.jpg" />
  </div><!--head-top/-->

    <form action="{{url('do_login')}}" method="post" class="reg-login">
      @csrf
      <h3>还没有三级分销账号？点此<a class="orange" href="/register">注册</a></h3>
      <div class="lrBox">
        <div class="lrList"><input type="text" name="name" placeholder="输入手机号码或者邮箱号" /></div>
        <div class="lrList"><input type="password" name="pwd" placeholder="输入密码" /></div>
      </div><!--lrBox/-->
      <div class="lrSub">
        <input type="submit" value="立即登录" /><br/>
        <input type="submit" value="微信登录" id="wechat" />
      </div>
    </form><!--reg-login/-->

    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script>
        $(function(){
            $('#wechat').click(function(){
                location.href='/wechat/wechat_login';
                return false;
            });
        });
    </script>

@include('layout.footer')
@endsection
