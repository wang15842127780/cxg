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
<h1 class="tt_h1">位置：请假管理>查看请假记录</h1>
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
		<button id="receive_all">
			全部签收
		</button>
	</form>
	
</div>
<br>
<div style="position:absolute;left:0;top:111px;right:0;bottom:0;overflow:auto;">
	<table id="table" class="new_table" style="display:none;margin-left:10px;margin-top:15px;">
		<tr class="tb_tr_th">
			<th>ID</th>
			<th>姓名</th>
			<th>班级</th>
			<th>原因</th>
			<th>班主任</th>
			<!-- <th>开始时间</th>
			<th>结束时间</th> -->
			<th style="min-width:270px;">请假时间</th>
			<th>状态</th>
			<th>详细信息</th>
			<!-- <th>操作</th> -->
		</tr>
	</table>
</div>
	
<div id="shell" class="zshow">
	
</div>
<div id="shell_img" class="zshow">
        <img src="/cxg/Public/iconfont/loading.gif" width="35" height="35">
        <p>加载中...</p>
</div>
<div id="show_box" style="display:none;">
	<input type="hidden" id="lid">
	<p style="margin-top:10px;">请假人：<span id="pp"></span></p>
	<p style="margin-top:2px">班&nbsp;&nbsp;&nbsp;级：<span id="cc"></span></p>
	<p style="margin-top:2px;">班主任：<span id="ll"></span></p>
	<p style="margin-top:2px;"><span style="display:inline-block;">&nbsp;<br>请假时间：<br>&nbsp;</span><span id="ss" style="display:inline-block;"></span></p>
	<textarea name="" id="reason" cols="30" rows="8" placeHolder="主任意见"></textarea>
	<br>
	<p style="margin-bottom:5px;margin-top:5px;">
		<button class="confirm-btn">同意</button>&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="cancel-btn">拒绝</button>
	</p>
</div>
<div id="detail_box" style="position:absolute;left:0;top:0;right:0;bottom:0;text-align:center;display:none;">
	<div style="width:450px;background:#acf6ff;display:inline-block;margin-top:100px;border:1px solid #aaa;border-radius:10px;">
		<p class="p">查看详情</p>
		<p class="lp" style="border-top:1px solid #ccc;"><span class="left">姓名：&nbsp;</span>&nbsp;<span class="right" id="name"></span></p>
		<p class="lp"><span class="left">班级：&nbsp;</span>&nbsp;<span class="right" id="class"></span></p>
		<p class="lp"><span class="left">原因：&nbsp;</span>&nbsp;<span class="right" id="reasons"></span></p>
		<p class="lp"><span class="left">班主任：&nbsp;</span>&nbsp;<span class="right" id="leader"></span></p>
		<!-- <p class="lp"><span class="left">开始时间：&nbsp;</span>&nbsp;<span class="right" id="begin_date"></span></p>
		<p class="lp"><span class="left">结束时间：&nbsp;</span>&nbsp;<span class="right" id="end_date"></span></p> -->
		<p class="lp"><span class="left">&nbsp;<br>请假时间：&nbsp;<br>&nbsp;</span>&nbsp;<span class="right" id="leave_date"></span></p>
		<p class="lp"><span class="left">请假意见：&nbsp;</span>&nbsp;<span class="right" id="director_note"></span></p>
		<!-- <p class="lp"><span class="left">主任意见：&nbsp;</span>&nbsp;<span class="right" id="leader_note"></span></p> -->
		<p class="lp"><span class="left">创建人：&nbsp;</span>&nbsp;<span class="right" id="createby"></span></p>
		<!-- <p class="lp"><span class="left">批准人：&nbsp;</span>&nbsp;<span class="right" id="auditby"></span></p> -->
		<p class="lp"><span class="left">状态：&nbsp;</span>&nbsp;<span class="right" id="statuss"></span></p>
		<p class="p" style="margin-bottom:10px;"><button id="cancel-btn" class="cancel-btn">返回</button></p>
	</div>
</div>
<input type="hidden" id="hid">
<input type="hidden" id="socket">
<script type="text/javascript" src="/cxg/Public/js/admindate.js"></script>
<script type="text/javascript">
	window.getLeaveList = function(data={})
	{
		var url = "index.php?m=Admin&c=Leave&a=getLeaveList";
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
			field[1] = 'student_text';
			field[2] = 'class_text';
			field[3] = 'reason';
			field[4] = 'leader';
			// field[5] = 'begin_date';
			// field[6] = 'end_date';
			field[5] = 'leave_date';
			field[6] = 'status_text';
			field[7] = 'detail_text'
			// field[8] = 'act_text';
			listPage(list,1,30,field);
		}
		else
		{
			tips(res.content,2);
			$(".zshow").hide();
		}
	}
	var socket = new WebSocket('ws://192.168.1.234:8080');
	// 监听Socket的关闭
	socket.onclose = function(event) {
		console.log('Client notified socket has closed',event);
		$("#socket").val(0);
	}; 
	socket.onerror = function(event) {
		console.log('Client notified socket has error',event);
		$("#socket").val(0);
	}; 
	socket.onmessage = function(event) {
		console.info("收到新消息！");
	};
	// 打开Socket 
	socket.onopen = function(event) {
		console.log("Connected", event);
		$("#socket").val(1);
	};

	$(".receive").live("click",function()
	{
		var id = $(this).parents("tr").find("td:eq(0)").html();
		var _this = $(this).parents("td");
		var url = "index.php?m=Admin&c=Leave&a=receive";
		var data = {id:id,typ:'json'};
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			tips(res.content,1);
			_this.html('待审核');
			_this.parents("tr").find('td:eq(8)').html("<a href='javascript:void(0)' class='check'>审核</a>");
		}
		else
		{
			tips(res.content,2);
		}
	})

	$("#receive_all").live("click",function()
	{
		var url = "index.php?m=Admin&c=Leave&a=receiveAll";
		var data = {typ:'json'};
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

	$(".check").live("click",function()
	{
		var id = $(this).parents("tr").find("td:eq(0)").html();
		$("#lid").val(id);
		var name = $(this).parents("tr").find("td:eq(1)").html();
		var clas = $(this).parents("tr").find("td:eq(2)").html();
		var lead = $(this).parents("tr").find("td:eq(4)").html();
		var ss = $(this).parents("tr").find("td:eq(5)").html();
		var pos = ss.indexOf("至");
		if(pos>=0)
		{
			var s1 = ss.substr(0,pos);
			var s2 = ss.substr(pos+1);
			ss = s1+"<br>至<br>"+s2;
		}
		else
		{
			console.info("没有");
		}
		// var ee = $(this).parents("tr").find("td:eq(6)").html();
		_tr = $(this);
		$("#pp").html(name);
		$("#cc").html(clas);
		$("#ll").html(lead);
		$("#ss").html(ss);
		// $("#ee").html(ee);
		$("#show_box").show();
		$("#shell").show();
	})

	$(".confirm-btn").live("click",function()
	{
		var sockets = $("#socket").val();
		if(sockets != 1)
		{
			tips("网络服务未启动，请刷新页面重新加载！",2);
			return;
		}
		var id = $("#lid").val();
		var newData = {content:id,action:'person_id',location:"entrance"};
		var reason = $("#reason").val();
		if($.trim(reason) == "")
		{
			tips('请填写您的意见！',2);
			return;
		}
		var url = "index.php?m=Admin&c=Leave&a=checkLeave1";
		var data = {id:id,reason:reason,status:5,typ:'json'};
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
					var list = res.content;
					var imgs = list.img;
					if(imgs.length == 1)
					{
						console.info(33);
						var cc = {name:res.content.name,classes:res.content.classes,bdate:res.content.dates,img:imgs[0]};
						var aa = {action:'person_add',location:'entrance',fin:1,content:cc};
						console.info(aa);
						socket.send(JSON.stringify(aa));
					}
					else
					{
						var j = imgs.length-1;
						for(var i in imgs)
						{
							if(i==j)
							{
								console.info(11);
								var cc = {name:res.content.name,classes:res.content.classes,bdate:res.content.dates,img:imgs[i]};
								var aa = {action:'person_add',location:'entrance',fin:1,content:cc};
								
							}
							else
							{
								console.info(22);
								var cc = {name:res.content.name,classes:res.content.classes,bdate:res.content.dates,img:imgs[i]};
								var aa = {action:'person_add',location:'entrance',fin:0,content:cc};
							}
							console.info(aa);
							socket.send(JSON.stringify(aa));
						}
					}
					// var cc = {name:res.content.name,img:res.content.img};
					// var aa = {action:'person_add',location:'entrance',content:cc};
					// socket.send(JSON.stringify(aa));
					// console.info(aa);
					_tr.parents("tr").remove();
					$("#show_box").hide();
					$("#shell").hide();
					$("#shell_img").hide();
				}
				else
				{
					tips(res.content,2);
				}
			},
			error:function(data)
			{
				alert('失败!');
				console.info(data);
				return;
				window.location.reload();
			}
		});
		
			
	})

	$(".cancel-btn").live("click",function()
	{
		var id = $("#lid").val();
		var reason = $("#reason").val();
		if($.trim(reason) == "")
		{
			tips('请填写您的意见！',2);
			return;
		}
		var url = "index.php?m=Admin&c=Leave&a=checkLeave";
		var data = {id:id,reason:reason,status:7,typ:'json'};
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

	$(".detail").live("click",function()
	{
		var id = $(this).parents("tr").find('td:eq(0)').html();
		var url = "index.php?m=Home&c=Leave&a=getLeaveById";
		var data = {id:id,typ:'json'};
		var res = ajax(url,data);
		var _p = $(this).parents("tr");
		if(res.status == 'success')
		{
			var info = res.content;
			$("#shell").show();
			$("#detail_box").show();
			var name = _p.find('td:eq(1)').html();
			var clas = _p.find('td:eq(2)').html();
			$("#name").html(name);
			$("#class").html(clas);
			$("#reasons").html(info.reason);
			$("#leader").html(info.leader);
			// $("#begin_date").html(info.begin_date);
			// $("#end_date").html(info.end_date);
			$("#leave_date").html(info.leave_date);
			$("#director_note").html(info.director_note);
			// $("#leader_note").html(info.leader_note);
			$("#createby").html(info.createby);
			// $("#auditby").html(info.auditby);
			$("#statuss").html(info.status_text);
			$(".right").each(function()
			{
				var _this = $(this);
				if($.trim(_this.html()) == '')
				{
					_this.html('暂无数据！');
				}
			})
		}
		else
		{
			tips(res.content,2);
		}
	})

	$("#detail_box").click(function()
	{
		$("#shell").hide();
		$("#detail_box").hide();
	})
	$("#cancel-btn").click(function()
	{
		$("#shell").hide();
		$("#detail_box").hide();
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