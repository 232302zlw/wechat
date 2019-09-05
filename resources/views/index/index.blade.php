@extends('layout.layout')
@section('content')
<div class="head-top">
      <img src="/index/images/head.jpg" />
      <dl>
       <dt>@if ($user['headimg']=='') <a><img src="/index/images/touxiang.jpg" /></a> @else <a><img src="{{asset($user['headimg'])}}" /></a> @endif</dt>
       <dd>
        <h1 class="username">@if ($user['name']=='') {{$user['email']}} @else {{$user['name']}} @endif</h1>
        <ul>
         <li><a href="prolist.html"><strong>34</strong><p>全部商品</p></a></li>
         <li><a href="javascript:;"><span class="glyphicon glyphicon-star-empty"></span><p>收藏本店</p></a></li>
         <li style="background:none;"><a href="javascript:;"><span class="glyphicon glyphicon-picture"></span><p>二维码</p></a></li>
         <div class="clearfix"></div>
        </ul>
       </dd>
       <div class="clearfix"></div>
      </dl>
     </div><!--head-top/-->
     <form action="#" method="get" class="search">
      <input type="text" class="seaText fl" />
      <input type="submit" value="搜索" class="seaSub fr" />
     </form><!--search/-->
      @if ($user['email']=='')
        <ul class="reg-login-click">
          <li><a href="{{url('login')}}">登录</a></li>
          <li><a href="{{url('register')}}" class="rlbg">注册</a></li>
          <div class="clearfix"></div>
        </ul><!--reg-login-click/-->
      @endif
      <div id="sliderA" class="slider">
        @foreach($is_new as $x)
          <img src="{{asset($x->goods_img)}}" alt="">
        @endforeach
      </div>

     <!-- <div id="sliderA" class="slider">
      <img src="/index/images/image1.jpg" />
      <img src="/index/images/image2.jpg" />
      <img src="/index/images/image3.jpg" />
      <img src="/index/images/image4.jpg" />
      <img src="/index/images/image5.jpg" />
     </div> --><!--sliderA/-->
     <ul class="pronav">
      <li><a href="prolist.html">晋恩干红</a></li>
      <li><a href="prolist.html">万能手链</a></li>
      <li><a href="prolist.html">高级手镯</a></li>
      <li><a href="prolist.html">特异戒指</a></li>
      <div class="clearfix"></div>
     </ul><!--pronav/-->
     <div class="index-pro1">
      @foreach($is_new as $new)
      <div class="index-pro1-list">
       <dl>
        <dt><a href="{{url('index/detail/'.$new->goods_id)}}"><img src="{{asset($new->goods_img)}}"/></a></dt>
        <dd class="ip-text"><a href="{{url('index/detail/'.$new->goods_id)}}">{{$new->goods_name}}</a><span>已售：488</span></dd>
        <dd class="ip-price"><strong>¥{{$new->goods_price}}</strong></dd>
       </dl>
      </div>
      @endforeach

      <!-- <div class="index-pro1-list">
       <dl>
        <dt><a href="proinfo.html"><img src="/index/images/pro1.jpg" /></a></dt>
        <dd class="ip-text"><a href="proinfo.html">这是产品的名称</a><span>已售：488</span></dd>
        <dd class="ip-price"><strong>¥299</strong> <span>¥599</span></dd>
       </dl>
      </div> -->

      <div class="clearfix"></div>
     </div><!--index-pro1/-->
     <div class="prolist">
      @foreach($is_hot as $hot)
      <dl>
       <dt><a href="{{('index/detail/'.$hot->goods_id)}}"><img src="{{asset($hot->goods_img)}}" width="100" height="100" /></a></dt>
       <dd>
        <h3><a href="{{('index/detail/'.$hot->goods_id)}}">{{$hot->goods_name}}</a></h3>
        <div class="prolist-price"><strong>¥{{$hot->goods_price}}</strong>
        <div class="prolist-yishou">
       </dd>
       <div class="clearfix"></div>
      </dl>
      @endforeach
      <!-- <dl>
       <dt><a href="proinfo.html"><img src="/index/images/prolist1.jpg" width="100" height="100" /></a></dt>
       <dd>
        <h3><a href="proinfo.html">四叶草</a></h3>
        <div class="prolist-price"><strong>¥299</strong> <span>¥599</span></div>
        <div class="prolist-yishou"><span>5.0折</span> <em>已售：35</em></div>
       </dd>
       <div class="clearfix"></div>
      </dl> -->

     </div><!--prolist/-->
     <div class="joins"><a href="fenxiao.html"><img src="/index/images/jrwm.jpg" /></a></div>
     <div class="copyright">Copyright &copy; <span class="blue">这是就是三级分销底部信息</span></div>

@include('layout.footer')
@endsection
