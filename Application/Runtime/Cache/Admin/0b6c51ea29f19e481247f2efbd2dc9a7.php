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
	#form{
		width:400px;
		height:230px;
		display:inline-block;
		margin-top:220px;
		background:#fff;
	}
	#add_form input{
		height:25px;
		line-height:25px;
		font-size:20px;
		width:173px;
	}
</style>
<br>
<h1 class="tt_h1">位置：宿舍管理>房间类型管理</h1>
<p style="text-align:right;"><button class="add-btn"><i class="add-btn-img"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;添加房间类型</button></p>
<div id="con_div">
	<table id="table" class="new_table">
		<tr style="display:none;">
			<th>ID</th>
			<th>名称</th>
			<th>可住人数</th>
			<th>添加时间</th>
			<th>操作</th>
		</tr>
	</table>
</div>
<div id="shell" class="zshow">
	
</div>
<div  id="shell_img" class="zshow">
	<img src="/cxg/Public/iconfont/loading.gif" width="35" height="35" />
	<p>加载中...</p>
</div>
<div id="add_form" style="position:absolute;left:0;top:0;right:0;z-index:9999;text-align:center;display:none;">
	<form id="form" onsubmit="return false;">
	<br>
		<p>添房间类型</p>
		<br>
		<input type="hidden" id="hid">
		房间类型：<input type="text" name="bname" id="bname"><br><br>
		可住人数：<input type="text" name="bnum" id="bnum" value="0"><br><br><br><br>
		<button class="confirm-btn">确定</button>&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="cancel-btn">取消</button>
	</form>
</div>
<script type="text/javascript">
	window.getList = function()
	{
		var url = "index.php?m=Admin&c=Setting&a=BuildTypeList";
		var data = {typ:'json'};
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			$(".zshow").hide();
			$(".new_table").find('tr').show();
			var list = res.content;
			var field = Array();
			field[0] = "id";
			field[1] = "name";
			field[2] = "number";
			field[3] = "addtime";
			if(res.leader == 1)
			{
				listPage(list,1,10,field,true);
			}
			else
			{
				field[4] = "act_text";
				$(".add-btn").hide();
				listPage(list,1,10,field);
			}
			
		}
		else
		{
			$(".zshow").hide();
			tips(res.content,2);
		}
	}

	setTimeout("getList();",500);

	$(".edit-btn").live("click",function()
	{
		var id = $(this).attr('sign');
		var url = "index.php?m=Admin&c=Setting&a=getBuildType";
		var data = {id:id,typ:'json'};
		var res2 = ajax(url,data);
		if(res2.status == 'success')
		{
			$("#hid").val(id);
			$("#shell").show();
			$("#add_form").show();
			var list = res2.content[0];
			$("#bname").val(list.name);
			$("#bnum").val(list.number);
		}
		else
		{
			tips(res2.content,2);
		}
	})

	$(".del-btn").live("click",function()
	{
		var id = $(this).attr('sign');
		var _this = $(this);
		var msg = "您真的确定要删除吗？\n\n请确认！";
		if(confirm(msg) == true)
		{
			var url = "index.php?m=Admin&c=Setting&a=delBuildType";
			var data = {bid:id,typ:'json'};
			var res = ajax(url,data);
			if(res.status == 'success')
			{
				tips(res.content,1);
				_this.parents("tr").remove();
			}
			else
			{
				tips(res.content,2);
			}
		}
		
			
	})
	$(".add-btn").click(function()
	{
		$("#shell").show();
		$("#add_form").show();
	})

	$(".confirm-btn").click(function()
	{
		var hid = $("#hid").val();
		var bname = $("#bname").val();
		if($.trim(bname) == "")
		{
			tips('类型名称不能为空！',2);
			return;
		}
		var bnum = $("#bnum").val();
		if($.trim(bnum) == "")
		{
			tips('可容不数不能为空！',2);
			return;
		}
		if($.trim(hid) == "")
		{
			var url = "index.php?m=Admin&c=Setting&a=addBuildType";
			var data = {bname:bname,bnum:bnum,typ:'json'};
		}
		else
		{
			var url = "index.php?m=Admin&c=Setting&a=editBuildType";
			var data = {bid:hid,bname:bname,bnum:bnum,typ:'json'};
		}
			
		var res1 = ajax(url,data);
		if(res1.status == 'success')
		{
			tips(res1.content,1);
			setTimeout('window.location.reload();',300);
		}
		else
		{
			tips(res1.content,2);
		}
	})

	$(".cancel-btn").click(function()
	{
		$("#bname").val("");
		$("#bnum").val("");
		$("#shell").hide();
		$("#add_form").hide();
		$("#hid").val("");
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