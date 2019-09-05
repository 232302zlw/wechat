@extends('layout.layout')
@section('content')
<script src="/index/js/jquery.min.js"></script>
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>会员注册</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/index/images/head.jpg" />
     </div><!--head-top/-->
     <form action="{{url('do_register')}}" method="post" class="reg-login">
      <h3>已经有账号了？点此<a class="orange" href="/login">登陆</a></h3>
      <div class="lrBox">
       <div class="lrList"><input type="text" name="type" placeholder="输入手机号码或者邮箱号" /></div>
       <div class="lrList2"><input type="text" name="code" placeholder="输入短信验证码" /> <button id="yz">获取验证码</button></div>
       <div>
          <span id="spanb"> </span>
       </div>
       <div class="lrList"><input type="text" name="pwd" placeholder="设置新密码（6-18位数字或字母）" /></div>
       <div class="lrList"><input type="text" name="cpwd" placeholder="再次输入密码" /></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="submit" value="立即注册" />
      </div>
     </form><!--reg-login/-->
<script type="text/javascript">
$(function(){
  layui.use('layer',function(){
    var layer=layui.layer;
  });


  //验证邮箱
  $('input[name=type]').blur(function(){
      var email=$(this).val();
      $(this).next().empty();
      var _this=$(this);
      var reg = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
      data = {email:email};
      if(email==''){
        $(this).after("<span style='color:red'>手机号码或邮箱不能为空！</span>");
        return false;
      }else if(!reg.test(email)){
        $(this).after("<span style='color:red'>邮箱格式错误！</span>");
        return false;
      }else{
        $.ajaxSetup({
          headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
        });

        $.post(
          "{{url('checkemail')}}",
          data,
          function(res){
            // console.log(res);
            if(res.code==1){
              _this.after('<span style="color:red">该邮箱已存在！</span>')
            }else if(res.code==2){
              _this.after('<span style="color:green">邮箱可以使用！</span>')
            }
          }
        );
      }
  });

  // 发送邮件、获取验证码
  $('#yz').click(function(){
    var email=$('input[name=email]').val();
    // alert(email);
    data = {email:email};
    $('input[name=email]').next().empty();
    if(email==''){
      $('input[name=email]').after("<span style='color:red'>注册邮箱不能为空！</span>");
      return false;
    }

    $.ajaxSetup({
      headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
    });

    $.post(
      "{{url('send')}}",
      data,
      function(res){
        layer.msg(res.font,{icon:res.code,time:3000});
      }
    );
    return false;
  })

  //验证验证码
  $('input[name=code]').blur(function(){
    var code=$(this).val(); 
    var reg=/^\d{6}$/;
    $(this).next('spanb').empty();
    if(code==''){
      $('#spanb').html("<span style='color:red'>验证码不能为空！</span>");
      return false;  
    }else if(!reg.test(code)){
      $('#spanb').html("<span style='color:red'>验证码格式不对！</span>");
      return false;
    }else{
      $('#spanb').html("<span style='color:green'>验证码格式正确！</span>");
    }
  })

  //验证密码
  $('input[name=pwd]').blur(function(){
    var pwd=$(this).val();
    $(this).next().empty();
    var reg=/^\w{6,10}$/;
    if(pwd==''){
      $(this).after("<span style='color:red'>注册密码不能为空！</span>");
      return false;
    }else if(!reg.test(pwd)){
      $(this).after("<span style='color:red'>注册密码要6~10位！</span>");
      return false;
    }else{
      $(this).after('<span style="color:green">√</span>')
    }
  })

  //验证确认密码
  $('input[name=cpwd]').blur(function(){
    var cpwd=$(this).val();
    var pwd=$('input[name=pwd]').val();
    $(this).next().empty();
    var reg=/^\w{6,10}$/;
    if(cpwd==''){
      $(this).after("<span style='color:red'>确认密码不能为空！</span>");
      return false;
    }else if(!reg.test(cpwd)){
      $(this).after("<span style='color:red'>确认密码格式不对！</span>");
      return false;
    }else if(pwd!=cpwd){
      $(this).after("<span style='color:red'>两次密码不一致！</span>");
      return false;
    }else{
      $(this).after('<span style="color:green">√</span>')
    }
  })  

  // 检测各数据是否合法
  $('input[type=submit]').click(function(){
    var email=$('input[name=email]').val();
    var code=$('input[name=code]').val();
    var pwd=$('input[name=pwd]').val();
    var cpwd=$('input[name=cpwd]').val();
    var data = {code:code,email:email,pwd:pwd,cpwd:cpwd};
    var flag=false;

    $.ajaxSetup({     
        headers: {         
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')   
        } 
      }); 

    $.post(
      "{{url('checkcode')}}",
      data,
      function(res){
        console.log(res);
        if (res.code==1) {
          layer.msg(res.font,{icon:res.code,time:2000});
          location.href=('login');
        }else if (res.code==2) {
          layer.msg(res.font,{icon:res.code,time:2000});
          flag = false;
        }
      }
    );
    return flag;
  })

});
</script>
@include('layout.footer')
@endsection
