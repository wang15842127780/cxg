<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>校园管理系统</title>
	<script type="text/javascript" src="/cxg/Public/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="/cxg/Public/js/fun.js"></script>
	<script type="text/javascript" src="/cxg/Public/js/livequery.js"></script>
	<link rel="stylesheet" href="/cxg/Public/css/admin.css" type="text/css">
	<style type="text/css">
		.hide{
			display:none;
		}
		.color{
			background:#434343 !important;
		}
		.tmenu{
			margin-left:20px;
			font-size:9pt;
			margin-top: 10px;
			text-align:center;
			display:inline-block;
			color:#fff;
			text-decoration:none;
		}
		.user b{
			display:inline-block;
			width:60px;
			height:18px;
			background:#CB0303;
			text-align:center;
			font-weight:normal;
			color:#fff;
			font-size:14px;
			margin-right:13px;
			/*margin-top:7px;*/
			line-height:18px;
			cursor:pointer;
			font-size:9pt;
		}
		.content{
			border:1px solid #aaa;
			width:350px;
			height:160px;
			display:inline-block;
			margin-left:100px;
			margin-top:50px;
			cursor:pointer;
		}
		.img{
			position:absolute;
			margin-left:10px;
			margin-top:15px;
			width:130px;
		}
		.title{
			/*background:red;	*/
			position:absolute;
			margin-left:160px;
			margin-top:24px;
			font-size:17px;
			color:#555;
		}
		.second{
			/*background:green;*/
			position:absolute;
			margin-left:160px;
			margin-top:75px;
			font-size:17px;
			color:#555;
		}
		.number{
			color:orange;
			font-size:35px;
		}
	</style>
</head>
<body>

	<div id="body">
		<!-- 顶部图片 -->
		<!-- <img src="./images/top3.jpg" style="height:75px;width:1280px;" /> -->
		<div id="top" style="background-image:url(/cxg/Public/images/top.png);background-size:100% 60px;height:60px;">
			<a href="/cxg/index.php?m=Admin" style="display:inline-block;">
				<img src="/cxg/Public/iconfont/logo.jpg" alt="系统首页" height="60">
			</a>
			<div style="display:inline-block;position:absolute;">
				<a href="/cxg/index.php?m=Admin" class="tmenu">
				<img src="/cxg/Public/iconfont/home.png" alt="系统首页" height="25">
				<p>工作台首页</p>
			</a>
			<a href="/cxg/index.php?m=Admin&c=Setting&a=index&id=7.25" class="tmenu">
				<img src="/cxg/Public/iconfont/student.png" alt="学生信息" height="25">
				<p>学生信息</p>
			</a>
			<a href="/cxg/index.php?m=Admin&c=Leave&a=index&id=60.62" class="tmenu">
				<img src="/cxg/Public/iconfont/leave.png" alt="请假管理" height="25">
				<p>请假管理</p>
			</a>
			<a href="/cxg/index.php?m=Admin&c=Teacher&a=index&id=75.76" class="tmenu">
				<img src="/cxg/Public/iconfont/teacher_attend.png" alt="教师考勤" height="25">
				<p>教师考勤</p>
			</a>
			<a href="/cxg/index.php?m=Admin&c=Health&a=index&id=7.73" class="tmenu">
				<img src="/cxg/Public/iconfont/health.png" alt="宿舍卫生管理" height="25">
				<p>宿舍卫生</p>
			</a>
			<a href="/cxg/index.php?m=Admin&c=Face&a=index&id=77.78" class="tmenu">
				<img src="/cxg/Public/iconfont/face_manage.png" alt="人脸库管理" height="25">
				<p>人脸库管理</p>
			</a>
			</div>
			<span class="user" style='display:inline-block;height:20px;margin-right:30px;margin-top:10px;background:#b8ceda;padding:7px;color:#b8ceda;background:rgb(0,52,113) repeat-x;border-radius:30px;'>&nbsp;&nbsp;&nbsp;&nbsp;用户名：【<?php echo (cookie('auser')); ?>】&nbsp;&nbsp;&nbsp;&nbsp;<b id="editPass">修改密码</b>&nbsp;&nbsp;&nbsp;&nbsp;<b id="logout">退出</b></span>
		</div>
		<!-- 主菜单 -->
		<div style="display:inline-block;float:left;">
			<div style="height:40px;line-height:40px;position:fixed;width:150px;font-weight:bold;color:#fff;margin-left:12px;"><img src="/cxg/Public/iconfont/menu_logo.png" height="16">菜单管理</div>
			<div id="main_menu">
				<!-- <ul>
					<?php if(is_array($main_menu)): foreach($main_menu as $key=>$list): ?><li><span style="display:inline-block;"><img src="/cxg/Public/iconfont/sub_logo.png" width="16"></span>&nbsp;&nbsp;<a href="javascript:void(0);" title="<?php echo ($list["id"]); ?>" class="maina"><?php echo ($list["menu_name"]); ?></a></li><?php endforeach; endif; ?>
				</ul> -->
				<?php if(is_array($main_menu)): foreach($main_menu as $k=>$lists): ?><ul class="menu<?php echo ($lists["id"]); ?> sub">
						<li class="main_menu"><span style="display:inline-block;"><img src="/cxg/Public/iconfont/sub_logo.png" width="16">
						<?php echo ($lists["menu_name"]); ?></li>
						<?php if(is_array($lists["sub_menu"])): foreach($lists["sub_menu"] as $key=>$min): ?><li class="fun" title="7.<?php echo ($min["id"]); ?>" id="m<?php echo ($min["id"]); ?>">
								><?php echo ($min["menu_name"]); ?>
							</li><?php endforeach; endif; ?>
					</ul><?php endforeach; endif; ?>
			</div>
		</div>
		<!-- 主页内容  -->
		<div id="home">
			
<style type="text/css">
	#con_div{
		background:#c8fafa;
	}
	.parent{
		display:flex;
	}
	.left{
		flex:none;
		width:10%;
		text-align:center;
		border-right:1px solid #ccc;
		font-size:20px;
	}
	.right{
		flex:none;
		width:90%;
	}
	.content{
		width:102px;
		height:90px;
		display:inline-block;
		text-align:center;
		border:1px solid #ddd;
		margin:2px 5px;
	}
	.number{
		display:inline-block;
		width:7px;
		height:7px;
		margin-top:12px;
		margin:6px;
		margin-bottom:0;
		border-radius:10px;
	}
	.exam{
		display:inline-block;
		width:20px;
		height:10px;
	}
</style>
<br>
<h1 class="tt_h1">位置：宿舍管理>入住信息</h1>
<p style="margin-left:50px;display:inline-block;width:50%;margin-top:-20px;">
	<span class="exam" style="background:red;"></span>&nbsp;&nbsp;&nbsp;已住
	<br>
	<span class="exam" style="background:green;"></span>&nbsp;&nbsp;&nbsp;未住
</p>
<div id="con_div">
	<?php if(is_array($hostelList)): foreach($hostelList as $k=>$list): ?><span class="parent">
			<div class="left">
				<span><?php echo ($k); ?></span>
			</div>
			<div class="right">
				<?php if(is_array($list)): foreach($list as $ks=>$lists): ?><p style="padding-left:10px;font-size:16px;">第<?php echo ($ks); ?>层</p>
					<?php if(is_array($lists)): foreach($lists as $kss=>$listss): if($listss["contain"] == 0): ?><div class='content' style='background:#ccc;'>
								<p style="line-height:30px;">&nbsp;</p>
								<p style="line-height:30px;"><?php echo ($listss["no"]); ?></p>
								<p style="line-height:30px;"><?php echo ($listss["type_text"]); ?></p>
							</div>
						<?php else: ?>
							<div class='content'>
								<p style="height:30px;vertical-align:middle;">
									<?php $__FOR_START_252491597__=0;$__FOR_END_252491597__=$listss["contain"];for($i=$__FOR_START_252491597__;$i < $__FOR_END_252491597__;$i+=1){ if($listss["num"] > $i): ?><span class="number" style="background:red;"></span>
										<?php else: ?>
											<span class="number" style="background:green;"></span><?php endif; } ?>
								</p>
								<p style="line-height:30px;"><?php echo ($listss["no"]); ?></p>
								<p style="line-height:30px;"><?php echo ($listss["type_text"]); ?></p>
							</div><?php endif; endforeach; endif; endforeach; endif; ?>
			</div>
		</span>
		<div style="height:1px;background:black;"></div><?php endforeach; endif; ?>
</div>
<!-- <div id="shell" class="zshow">

</div>
<div  id="shell_img" class="zshow">
        <img src="/cxg/Public/iconfont/loading.gif" width="35" height="35" />
        <p>加载中...</p>
</div> -->

<script type="text/javascript">
	$(".left").each(function()
	{
		var _this = $(this);
		var h = _this.context.clientHeight;
		_this.css('lineHeight',h+"px");
		console.info(_this);
		console.info(h);
	})
</script>

		</div>
	</div>
</body>
</html>
<script type="text/javascript">
	$("#logout").click(function()
	{
		window.location.href = "/cxg/index.php?m=Admin&c=Log&a=logout";
	})
	$(".sub").click(function()
	{
		var _this = $(this);
		_this.siblings(".sub").find("li:gt(0)").slideUp();
		_this.find('li').slideDown();
	})

	$(".fun").click(function()
	{
		var type = $(this).attr("title");
		window.location.href = "/cxg/index.php?m=Admin&c=Index&a=index&act="+type;
	})

	$(".edit").click(function()
	{
		$(".edit").remove();
	})

	$("#editPass").click(function()
	{
		window.location.href = 'index.php?m=Admin&c=Setting&a=index&id=7.21';
	})

	var url = window.location.href;
	var arr = url.split(".");
	var count = arr.length;
	var num = parseInt(count)-1;
	var nn = arr[num];
	if(parseInt(nn) == 32)
	{
		nn = 26;
	}
	if(parseInt(nn) == 33)
	{
		nn = 31;
	}
	if(parseInt(nn) == 62)
	{
		nn = 25;
	}
	if(parseInt(nn) == 73)
	{
		nn = 27;
	}
	if(parseInt(nn) == 76)
	{
		nn = 58;
	}
	$(".fun").hide();
	$("#m"+nn).show();
	$("#m"+nn).siblings().show();

</script>