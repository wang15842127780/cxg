<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>校园管理系统</title>
  <script type="text/javascript" src="/cxg/Public/js/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="/cxg/Public/js/fun.js"></script>
  <link rel="stylesheet" href="/cxg/Public/css/index.css" type="text/css">
  <style type="text/css">
    body{
      background:url("/cxg/Public/images/xingkong.jpg");
      background-repeat:no-repeat;
      background-size:100%;
    }
    span{
      font-size:25px;
      height:80px;
      line-height:80px;
      display:inline-block;
      width:100%;
      border:2px solid #06bbc3;
      margin-top:10px;
      background:#fff;
    }
    span div{
      display:inline;
      margin-left:25px;
    }
    span img{
      max-width:80px;
      max-height:80px;
      float:left;

    }
    p{
      background: #EEE url(data:image/gif;base64,iVBORw0KGgoAAAANSUhEUgAAAAQAAAAECAIAAAAmkwkpAAAAHklEQVQImWNkYGBgYGD4//8/A5wF5SBYyAr+//8PAPOCFO0Q2zq7AAAAAElFTkSuQmCC) repeat;
      text-shadow: 5px -5px #fff, 4px -4px white;
      font-weight: bold;
      -webkit-text-fill-color: transparent;
      -webkit-background-clip: text
    }
  </style>
</head>
<body>
  <p style="width:100%;text-align:center;color:#fff;font-size:50px;line-height:60px;margin-top:20px;">学&nbsp;生&nbsp;进&nbsp;出&nbsp;记&nbsp;录</p>
  <div style="display:inline-block;margin-top:50px;">
  <!--[if IE]>  
     <object type='application/x-vlc-plugin' id='vlc' events='True'  
         classid='clsid:9BE31822-FDAD-461B-AD51-BE1D1C159921' codebase="http://downloads.videolan.org/pub/videolan/vlc/latest/win32/axvlc.cab" width="720" height="540">  
            <param name='mrl' value='rtsp://admin:admin@192.168.1.114:554/h264/ch1/main/av_stream' />  
            <param name='volume' value='50' />  
            <param name='autoplay' value='true' />  
            <param name='loop' value='false' />  
            <param name='fullscreen' value='false' />  
      </object>  
  <![endif]-->  
  <!--[if !IE]>-->
      <object type='application/x-vlc-plugin' id='vlc' events='False' width="820" height="462" pluginspage="http://www.videolan.org" codebase="http://downloads.videolan.org/pub/videolan/vlc-webplugins/2.0.6/npapi-vlc-2.0.6.tar.xz" style="margin-left:50px;margin-top:75px;">  
          <param name='mrl' value='rtsp://admin:admin@192.168.1.114:554/h264/ch1/main/av_stream' />  
          <param name='volume' value='1' />  
          <param name='autoplay' value='true' />  
          <param name='loop' value='false' />  
          <param name='fullscreen' value='false' /> 
      </object>  
  <!--<![endif]-->  
</div>
  
<div id="show-box" style="border:1px solid black;width:600px;height:560px;float:right;margin-top:50px;margin-right:50px;border:2px solid #eee;border-radius:3px;padding:10px;overflow:hidden;" >
    <span><img src="http://192.168.1.120/cxg/Public/images/1.jpg"><div>汪汪汪</div><div>3-2班</div><div>2016-10-10 10:10:10</div></span>
</div>
</body>
</html>
<script type="text/javascript">
        ws = new WebSocket('ws://127.0.0.1:80/HappyChat');
        ws.onopen = function(){
            
        };

        ws.onmessage = function(e){
            var data = $.parseJSON( e.data );
            var url = "index.php?m=Home&c=Hostel&a=getInfo";
            var dd = {id:data.msg,typ:'json'};
            var res = ajax(url,dd);
            console.info(res);
            if(res.status == 'success')
            {
              $("#show-box").prepend("<span><img src='"+res.content[0].img+"'><div>"+res.content[0].name+"</div><div>"+res.content[0].class+"</div><div>"+res.content[0].datetime+"</div></span>");
            }
            else
            {
              tips(res.content,2);
            }
        };

        ws.onerror = function(){
            alert('错误！');
        };
</script>