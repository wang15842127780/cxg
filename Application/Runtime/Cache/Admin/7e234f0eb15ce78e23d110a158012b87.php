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
			
<br>
<h1 class="tt_h1">位置：请假管理>查看教师请假记录</h1>
<style type="text/css">
	#show_box{
		position:absolute;
		height:280px;
		width:300px;
		text-align:center;
		background:#fff;
		left:450px;
		top:160px;
		border-radius:10px;
	}
	.tb_tr_th th{
		width:130px;
		height:30px;
		font-size:10pt;
	}
	.tb_tr_td td{
		width:130px;
		height:30px;
		font-size:10pt;
	}
	#receive_all{
		float:right;
		margin-right:150px;
		margin-top:4px;
		padding:2px;
		border-radius:5px;
		background:orange;
		color:#fff;
	}
	.p{
		width:100%;
		margin-top:30px;
		font-size:18px;
	}
	.left{
		display:inline-block;
		width:50%;
		text-align:right;
		padding-right:5px;
	}
	.right{
		display:inline-block;
		text-align: center;
	}
	.lp{
		text-align:left;
		font-size:16px;
		padding:8px 0;
		border: 1px solid #ccc;
		border-top:0;
	}
</style>
<div id="cond">
	<form onsubmit="return false;">
		姓名：<input type="text" name="uname" id="uname" style="width:60px;">
		&nbsp;
		开始时间：<input class="sang_Calender" type="text" name="stime" value="<?php echo ($_POST['stime']); ?>" id="stime" placeholder="请选择"  readonly style="width:130px;">&nbsp;
		结束时间：<input class="sang_Calender" type="text" name="etime" value="<?php echo ($_POST['etime']); ?>" id="etime" placeholder="请选择"  readonly style="width:130px;">&nbsp;
		<input type="submit" id="submit" value="搜索" style="padding:1px;margin-left:10px;padding-top:0;padding-bottom:0;">
		<!-- <button id="receive_all">
			全部签收
		</button> -->
	</form>
	
</div>
<br>
<div style="position:absolute;left:0;top:111px;right:0;bottom:0;overflow:auto;">
	<table id="table" class="new_table" style="display:none;margin-left:10px;margin-top:15px;">
		<tr class="tb_tr_th">
			<th>ID</th>
			<th>姓名</th>
			<th>原因</th>
			<th>开始时间</th>
			<th>结束时间</th>
			<th>审批人</th>
			<th>审批意见</th>
			<th>操作</th>
		</tr>
	</table>
</div>
<div id="shell" class="zshow">
	
</div>
<div id="shell_img" class="zshow">
        <img src="/cxg/Public/iconfont/loading.gif" width="35" height="35">
        <p>加载中...</p>
</div>
<div id="check_box" style="position:absolute;left:0;top:0;right:0;bottom:0;text-align:center;display:none;">
	<div style="width:400px;height:410px;border:1px solid #ccc;border-radius:5px;background:#fff;margin-top:50px;display:inline-block;">
		<p style="height:50px;margin-top:5px;font-size:20px;">详细信息</p>
		<p style="height:50px;margin-top:5px;">
			<span style="display:inline-block;width:200px;text-align:right;font-size:18px;">姓名：</span>
			<span style="display:inline-block;width:196px;text-align:left;font-size:18px;" id="tname"></span>
		</p>
		<p style="height:50px;margin-top:5px;">
			<span style="display:inline-block;width:200px;text-align:right;font-size:18px;">事由：</span>
			<span style="display:inline-block;width:196px;text-align:left;font-size:18px;" id="treason"></span>
		</p>
		<p style="height:50px;margin-top:5px;">
			<span style="display:inline-block;width:200px;text-align:right;font-size:18px;">开始时间：</span>
			<span style="display:inline-block;width:196px;text-align:left;font-size:18px;" id="tstime"></span>
		</p>
		<p style="height:50px;margin-top:5px;">
			<span style="display:inline-block;width:200px;text-align:right;font-size:18px;">结束时间：</span>
			<span style="display:inline-block;width:196px;text-align:left;font-size:18px;" id="tetime"></span>
		</p>
		<p style="height:50px;margin-top:5px;">
			<span style="display:inline-block;width:200px;text-align:right;font-size:18px;">审核意见：</span>
			<span style="display:inline-block;width:192px;text-align:left;font-size:16px;">
				<input type="text" id="tnote" style="width:100px;background:#eee;">
			</span>
		</p>
		<p style="height:50px;margin-top:5px;text-align:center;">
			<button class="confirm-btn">同意</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button class="cancel-btn">退回</button>
		</p>
		<p style="height:50px;margin-top:5px;">
			
		</p>
	</div>
</div>
<input type="hidden" id="hid">
<script type="text/javascript" src="/cxg/Public/js/admindate.js"></script>
<script type="text/javascript">
	window.getLeaveList = function(data={})
	{
		var url = "index.php?m=Admin&c=Leave&a=getTeacherLeaveList";
		data.typ = 'json';
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			if(res.leader != 1)
			{
				$("#receive_all").hide();
			}
			$("#table").show();
			$(".zshow").hide();
			var list = res.content;
			var field = Array();
			field[0] = 'id';
			field[1] = 'teacher_name';
			field[2] = 'reason';
			field[3] = 'begin_date';
			field[4] = 'end_date';
			field[5] = 'auditby';
			field[6] = 'auditby_note';
			field[7] = 'status_text';
			listPage(list,1,30,field);
		}
		else
		{
			tips(res.content,2);
			$(".zshow").hide();
		}
	}


	$(".check").live("click",function()
	{
		var id = $(this).parents("tr").find("td:eq(0)").html();
		$("#hid").val(id);
		var name = $(this).parents("tr").find("td:eq(1)").html();
		var reason = $(this).parents("tr").find("td:eq(2)").html();
		var stime = $(this).parents("tr").find("td:eq(3)").html();
		var etime = $(this).parents("tr").find("td:eq(4)").html();

		$("#tname").html(name);
		$("#treason").html(reason);
		$("#tstime").html(stime);
		$("#tetime").html(etime);
		// $("#ee").html(ee);
		$("#check_box").show();
		$(".zshow").show();
	})

	$(".confirm-btn").live("click",function()
	{
		var id = $("#hid").val();
		var tnote = $("#tnote").val();
		if($.trim(tnote) == "")
		{
			tips('请填写您的意见！',2);
			return;
		}
		var url = "index.php?m=Admin&c=Leave&a=agreeTeacherLeave";
		var data = {id:id,reason:tnote,status:5,typ:'json'};
		// var res = ajax(url,data);
		$("#show_box").hide();
		$(".zshow").show();
			// var url1 = "index.php?m=Admin&c=Leave&a=person_register";
		$.ajax({
			url:url,
			type:'post',
			async:true,
			data:data,
			dataType:'json',
			success:function(res)
			{
				if(res.status == 'success')
				{
					tips("操作成功！",1);
					setTimeout("window.location.reload();",500);
				}
				else
				{
					tips(res.content,2);
				}
			}
		});
		
			
	})

	$(".cancel-btn").live("click",function()
	{
		var id = $("#hid").val();
		var tnote = $("#tnote").val();
		if($.trim(tnote) == "")
		{
			tips('请填写您的意见！',2);
			return;
		}
		var url = "index.php?m=Admin&c=Leave&a=disagreeTeacherLeave";
		var data = {id:id,reason:tnote,status:7,typ:'json'};
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			tips(res.content,1);
			setTimeout("window.location.reload();",500);
		}
		else
		{
			tips(res.content,2);
		}
	})

	$("#submit").click(function()
	{
		var uname = $("#uname").val();
		var stime = $("#stime").val();
		var etime = $("#etime").val();
		var status = $("#status").val();
		var data = {uname:uname,stime:stime,etime:etime,status:status};
		getLeaveList(data);
	})
	
	setTimeout("getLeaveList();",500);
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
	if(parseInt(nn) == 80)
	{
		nn = 58;
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