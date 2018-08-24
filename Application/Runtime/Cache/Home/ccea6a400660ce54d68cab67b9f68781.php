<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>登 录</title>
  <link rel="stylesheet" href="/cxg/Public/css/style1.css">
  <script type="text/javascript" src="/cxg/Public/js/jquery-3.2.1.min.js"></script>
</head>
<body style="background:url(/cxg/Public/images/logbk.jpg) 0 0 no-repeat scroll transparent;background-size:100%;">
  <section class="container">
    <div class="login">
      <h1>用 户 登 录</h1>
      <form onsubmit="return false;" id="form">
        <p><input type="text" name="uname" class="uname" placeholder="用 户 名"></p>
        <p><input type="password" name="upass" class="upass" placeholder="密 码"></p>
        <p class="submit" style="text-align:center;">
          <input type="submit" name=submit value="登&nbsp;&nbsp;&nbsp;录" id="submit">
          
        </p>
      </form>
    </div>
  </section>
  <button onclick="window.location.href='/cxg/index.php?m=Admin'" style="padding:0 18px;height:29px;font-size:12px;font-weight:bold;color:#527881;text-shadow:0 1px #e3f1f1;background:#dcf2f7;border:1px solid;border-color:#b4ccce #b3c0c8 #9eb9c2;outline:0;position:absolute;right:25px;top:25px;">管 理 员 入 口</button>
</body>

</html>
<script>
$("#submit").click(function()
{
  var uname = $("input[name='uname']").val();
  if($.trim(uname) == "")
  {
    $(".tname").remove();
    $(".uname").after("<span class='tname' style='color:red;'>请输入用户名！</span>");
    return;
  }
  var upass = $("input[name='upass']").val();
  if($.trim(upass) == "")
  {
    $(".tpass").remove();
    $(".tname").remove();
    $(".upass").after("<span class='tpass' style='color:red;'>请输入密码！</span>");
    return;
  }

  $.ajax({
    url:'/cxg/index.php?m=Home&c=Log&a=dolog',
    data:$("#form").serialize(),
    type:'post',
    dataType:'json',
    success:function(data)
    {
      if(data == 'true')
      {
        window.location.href = "./";
      }
      else
      {
        $(".tpass").remove();
        $(".tname").remove();
        $(".upass").after("<span class='tpass' style='color:red;'>用户名或密码错误！</span>");
      }
    },
    error:function()
    {
      alert("网络繁忙，请稍后尝试！");
    }
  })
})
</script>