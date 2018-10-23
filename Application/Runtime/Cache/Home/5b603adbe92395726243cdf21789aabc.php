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
    .p{
      background: #EEE url(data:image/gif;base64,iVBORw0KGgoAAAANSUhEUgAAAAQAAAAECAIAAAAmkwkpAAAAHklEQVQImWNkYGBgYGD4//8/A5wF5SBYyAr+//8PAPOCFO0Q2zq7AAAAAElFTkSuQmCC) repeat;
      text-shadow: 5px -5px #fff, 4px -4px white;
      font-weight: bold;
      -webkit-text-fill-color: transparent;
      -webkit-background-clip: text
    }
    .content{
      float:left;
      width:245px;
      margin-left:3%;
      border:1px solid #ccc;
      padding-bottom:21%;
      margin-bottom:20px;
      border-radius:5px;
      margin-top: 5px;
      height:60px;
    }
    .content p{
      color:white;
      margin-left: 160px;
      font-size:20px;
      margin-top:50px;
    }
    .content .pp{
      margin-left:10px;
      text-align: center;
      margin-top:100px;

    }
    .img{
      max-width:150px;
      position: absolute;
      max-height: 225px;
    }
  </style>
</head>
<body>
  <p class="p" style="width:100%;text-align:center;color:#fff;font-size:50px;line-height:60px;margin-top:20px;">学&nbsp;生&nbsp;进&nbsp;出&nbsp;记&nbsp;录</p>
  
  
<div style="height:0;overflow-y:hidden;position:relative;width:1200px%;padding-bottom:43%;padding-left:10%;padding-right:10%;" id="box">
    <?php if(is_array($record_list)): foreach($record_list as $key=>$list): ?><div class="content">
          <img src="<?php echo ($list["photo_text"]); ?>" class="img">
          <p><?php echo ($list["name_text"]); ?></p>
          <p><?php echo ($list["class_text"]); ?></p>
          <p class="pp"><?php echo ($list["alarm_time"]); ?> <br><?php echo ($list["inout"]); ?></p>
      </div><?php endforeach; endif; ?>
    <!-- <div class="content">
          <img src="https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=3885187888,766355256&fm=27&gp=0.jpg" class="img">
          <p>张三</p>
          <p>三年1班</p>
          <p class="pp">2018-0806 10:26:54 <br>进入</p>
      </div> -->
  </div>
</body>
</html>
<script type="text/javascript">
        window.unsethostelEntranceRedis = function()
        {
            var url = "index.php?m=Home&c=Hostel&a=unsethostelEntranceRedis";
            var data = {typ:'json'};
            var res = ajax(url,data);
            if(res.status == 'success')
            {
                getNewHostelInfo();
            }
            else
            {
                tips(res.content,2);
            }
        }
        window.getNewHostelInfo = function()
        {
            var url = "index.php?m=Home&c=Hostel&a=getNewHostelInfo";
            var data = {typ:'json'};
            $.ajax({
              url:url,
              data:data,
              timeout:40000,
              type:'post',
              dataType:'json',
              async:true,
              success:function(data)
              {
                if(data.status == 'success')
                {
                    var lists = data.content;
                    addInfo(lists);
                }
                else if(data.content == 'TimeOut')
                {
                    getNewHostelInfo();
                }
                else if(data.content == 'no_person')
                {
                  getNewHostelInfo();
                }
                else
                {
                    window.location.reload();
                }
              },
              error:function(error)
              {
                tips(error,2);
              }
            })
        }
        window.addInfo = function(list)
        {
            var str ='<div class="content"><img src="'+list.photo_text+'" class="img"><p>'+list.name_text+'</p><p>'+list.class_text+'</p><p class="pp">'+list.alarm_time+' <br>'+list.inout+'</p></div>';
            $("#box").prepend(str);
            getNewHostelInfo();
        }
        setTimeout("unsethostelEntranceRedis();",500);
</script>