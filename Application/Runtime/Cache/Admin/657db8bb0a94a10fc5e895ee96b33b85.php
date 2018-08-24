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
	table{
		border-collapse:collapse;
		margin-left:30px;
		margin-top:10px;
	}
</style>
<br>
<h1 class="tt_h1">位置：相机管理>查看相机信息</h1>
<input type="hidden" id="cid">
<br>
<?php if($camera == ''): ?><p style="color:red;text-align:center">暂无相机信息</p>
<?php else: ?>
<table id="table" class="new_table">
	<tr class="tb_tr_th">
		<th>相机ID</th>
		<th>名称</th>
		<th>班级</th>
		<th>操作</th>
	</tr>
	<?php if(is_array($camera)): foreach($camera as $key=>$list): ?><tr class="tb_tr_td">
			<td><?php echo ($list["id"]); ?></td>
			<td><?php echo ($list["name"]); ?></td>
			<td><?php echo ($list["room_text"]); ?></td>
			<td>
				<?php if($list["room_text"] == "无"): ?><a href="javascript:void(0);" sign="<?php echo ($list["id"]); ?>" class="bindc">绑定班级</a>
				<?php else: ?>
					<a href="javascript:void(0);" sign="<?php echo ($list["id"]); ?>" class="editc">修改班级</a><?php endif; ?>
			</td>
		</tr><?php endforeach; endif; ?>
</table><?php endif; ?>
<div id="shell" style="display:none;"></div>
<div id='shell_box' style="position:absolute;z-index:9999;width:100%;height:300px;text-align:center;left:0;top:0;display:none;">
	<div style="width:300px;height:250px;display:inline-block;background:#fff;margin-top:220px;border-radius:5px;">
		<p class="title" style="text-align:left;padding:3px;border-radius:5px;border-bottom:1px solid #ccc;background:#eee;"></p>
		<p style="margin-top:62px;text-align:center;">班级：<select name="clist" id="clist" style="width:100px;padding-left:15px;">
			<?php if(is_array($clist)): foreach($clist as $key=>$lists): ?><option value="<?php echo ($lists["id"]); ?>"><?php echo ($lists["name"]); ?></option><?php endforeach; endif; ?>
		</select></p>
		<p style="margin-top:100px;text-align:right;padding-right:10px;">
			<button id='yes' style="background:#ff8d00;width:50px;height:25px;border-radius:8px;"></button>
			<button id="no" style="width:50px;height:25px;border-radius:8px;">取消</button>
		</p>
	</div>
</div>
<script type="text/javascript">
	$(".bindc").click(function()
	{
		$("#shell").show();
		$("#show_box").show();
		$(".title").html("绑定班绷");
		$("#yes").html("确定");
		var id = $(this).attr('sign');
		$("#cid").val(id);
	})
	$(".editc").click(function()
	{
		$("#shell").show();
		$("#shell_box").show();
		$(".title").html('修改班级');
		$("#yes").html('修改');
		var id = $(this).attr("sign");
		$("#cid").val(id);
	})

	$("#yes").click(function()
	{
		var cid = $("#cid").val();
		var val = $("#clist").val();
		var url = "index.php?m=Admin&c=Setting&a=editCamera";
		var data = {cid:cid,room:val,typ:'json'};
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			tips(res.content,1);
			window.location.reload();
		}
		else
		{
			tips(res.content,2);
		}
	})
	$("#no").click(function()
	{
		$("#shell").hide();
		$("#shell_box").hide();
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