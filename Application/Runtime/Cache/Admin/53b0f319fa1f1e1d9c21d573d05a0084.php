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
	#table{
		margin-left:40px;
	}
	.new_table{
		margin-top:20px;
	}
	.new_table th{
		width:130px;
		height:30px;
		font-size:10pt;
	}
	.tb_tr_td td{
		width:130px;
		height:30px;
		font-size:10pt;
	}
	#power_table{
		border:2px solid #AEAEAE;
		border-collapse:collapse;
		display:none;
	}
	.power_tr{
		height:32px;
		vertical-align:middle;
		text-align:center;
	}
	.select_box{
		border-radius:10px;
		width:80px;
		height:20px;
		margin-top:4px;
		display:inline-block;
		border:1px solid #ccc;
		background:#bbb;
	}
	.select_div{
		width:50px;
		height:20px;
		border-radius:10px;
		background:orange;
		float:left;
		color:#fff;
		cursor:pointer;
	}
	input{
		margin-top:10px;
		width:100px;
	}
	.edit-btn{
		display:none;
	}
	.add_left{
		display: inline-block;
		width:25%;
		text-align: right;
	}
	.add_right{
		display: inline-block;
	}
</style>
<br>
<h1 class="tt_h1">位置：身份管理>成员管理</h1>
<p style="display:inline-block;width:45%;padding-left:30px;">
	真实姓名：<input type="text" id="snick">&nbsp;&nbsp;
	用户名：<input type="text" id="sname">&nbsp;&nbsp;
	<button class="search"><i class="search-btn-img"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;查找</button>
</p>
<p style="text-align:right;display:inline-block;width:50%;"><button class="add-btn"><i class="add-btn-img"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;添加管理人员</button></p>
<br>
<div id="con_div">
	<table id="table" class="new_table">
		<tr style="display:none;">
			<th>ID</th>
			<th>真实姓名</th>
			<th>用户名</th>
			<th>角色名</th>
			<th>重置密码</th>
			<th>权限管理</th>
			<th>操作</th>
		</tr>
	</table>
	<table id="power_table" class="new_table">
		<input type="hidden" id="pid">
		<tr>
			<th style="width:200px;">操作</th>
			<th style="width:200px;">权限</th>
		</tr>
		<tr class="power_tr tb_tr_td">
			<td>班级管理</td>
			<td><div class="select_box"><div class="select_div power1" sign="1">无</div></div></td>
		</tr>
		<tr class="power_tr tb_tr_td">
			<td>宿舍管理</td>
			<td><div class="select_box"><div class="select_div power2" sign="2">无</div></div></td>
		</tr>
		<tr class="power_tr tb_tr_td">
			<td>学生管理</td>
			<td><div class="select_box"><div class="select_div power3" sign="3">无</div></div></td>
		</tr>
		<tr class="power_tr tb_tr_td">
			<td>教师管理</td>
			<td><div class="select_box"><div class="select_div power4" sign="4">无</div></div></td>
		</tr>
		<tr class="power_tr tb_tr_td">
			<td>学科管理</td>
			<td><div class="select_box"><div class="select_div power5" sign="5">无</div></div></td>
		</tr>
		<tr class="power_tr tb_tr_td">
			<td>请假审批</td>
			<td><div class="select_box"><div class="select_div power6" sign="6">无</div></div></td>
		</tr>
		<tr class="power_tr tb_tr_td">
			<td>课表管理</td>
			<td><div class="select_box"><div class="select_div power7" sign="7">无</div></div></td>
		</tr>
		<tr class="power_tr tb_tr_td">
			<td>身份管理</td>
			<td><div class="select_box"><div class="select_div power8" sign="8">无</div></div></td>
		</tr>
		<tr style="height:40px;text-align:center;">
			<td colspan="2">
				<button style="width:50px;height:25px;background:#449d44;border-color:#398439;color:#fff;" class="confirm-btn1">确定</button>
				<button style="width:50px;height:25px;background:#f0ad4e;border-color:#eea236;color:#fff;margin-left:50px;" class="cancel-btn1">取消</button>
			</td>
		</tr>
	</table>
</div>
<div id="shell" class="zshow">

</div>
<div  id="shell_img" class="zshow">
        <img src="/cxg/Public/iconfont/loading.gif" width="35" height="35" />
        <p>加载中...</p>
</div>
<div id="add_form" style="position: absolute; left: 0px; top: 0px; right: 0px; z-index: 9999; text-align: center;display:none;">
	<form id="form" onsubmit="return false;" style="display:inline-block;width:400px;background:#fff;margin-top:150px;">
	<br>
		<p>添 加 管 理 人 员</p>
		<br>
		<input type="hidden" id="hid">
		<p class="add_left">真实姓名：</p><p class="add_right"><input type="text" name="nick" id="nick"></p><br>
		<p class="add_left">用&nbsp;户&nbsp;名：</p><p class="add_right"><input type="text" name="name" id="name"></p><br>
		
		<p><span style="font-size:9pt;color:green;">*注册后可用于前后台登录</span></p><br>
		<p class="add_left">密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码：</p><p class="add_right"><input type="password" name="password" id="password"></p><br>
		<p class="add_left">确认密码：</p><p class="add_right"><input type="password" name="repass" id="repass"></p><br>
		
		<p><span style="font-size:9pt;color:red;display:none;" class="diff_pass">两次输入的密码不一致</span>
		<br class="diff_pass" style="display:none;"></p>
		<p class="add_left">身份名称：</p><p class="add_right"><select name="role" id="role" style="margin-top:10px;width:104px;">
			
		</select></p>
		
		<br><br>
		<p><button class="confirm-btn">确定</button>&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="cancel-btn">取消</button><br><br></p>
		
	</form>
</div>

<script type="text/javascript">
	window.getList = function(data={})
	{
		var url = "index.php?m=Admin&c=Setting&a=getManageList";
		data.typ = 'json';
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			$("#table").find('tr').show();
			$(".zshow").hide();
			var field = Array();
			field[0] = 'id';
			field[1] = 'nick';
			field[2] = 'name';
			field[3] = 'role_text';
			field[4] = 'reset_pass';
			field[5] = 'set_power';
			var lists = res.content;
			if(res.leader == 1)
			{
				listPage(lists,1,15,field,true);
			}
			else
			{
				field[6] = 'act_text';
				$(".add-btn").hide();
				listPage(lists,1,15,field);
			}
		}
		else
		{
			tips(res.content,2);
			$(".zshow").hide();
			$(".new_table").find('tr').hide();
		}
	}
	//查找按钮
	$(".search").click(function()
	{
		var snick = $("#snick").val();
		var sname = $("#sname").val();
		var cond = {snick:snick,sname:sname};
		getList(cond);
		$("#table").show();
		$("#power_table").hide();
	})
	//添加按钮
	$(".add-btn").click(function()
	{
		$("#shell").show();
		$("#add_form").show();
		var rl = <?php echo ($roleList); ?>;
		var str = String();
		for(var i in rl)
		{
			str += "<option value='"+rl[i].id+"'>"+rl[i].role_name+"</option>";
		}
		$("#role").html(str);
	})
	//确定按钮
	$(".confirm-btn").click(function()
	{
		var id = $("#hid").val();
		var nick = $("#nick").val();
		if($.trim(nick) == "")
		{
			tips("真实姓名不能为空！",2);
			return;
		}
		var name = $("#name").val();
		if($.trim(name) == '')
		{
			tips('用户名不能为空！',2);
			return;
		}
		var pass = $("#password").val();
		if($.trim(pass) == "")
		{
			tips('密码不能为空！',2);
			return;
		}
		var repass = $("#repass").val();
		if(pass != repass)
		{
			$(".diff_pass").show();
			return;
		}
		else
		{
			$(".diff_pass").hide();
		}
		var role = $("#role").val();
		if($.trim(role) == '')
		{
			tips('请先设置身份，才能添加！',2);
			return;
		}

		if($.trim(id) == '')
		{
			var url = 'index.php?m=Admin&c=Setting&a=addManage';
			var data = {nick:nick,name:name,pass:pass,role:role,typ:'json'};
		}
		else
		{
			var url = 'index.php?m=Admin&c=Setting&a=editManage';
			var data = {id:id,nick:nick,name:name,pass:pass,role:role,typ:'json'};
		}
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			tips(res.content,1);
			setTimeout("window.location.reload();",500);
		}
		else
		{
			tips(res.content);
		}
	})

	//重置密码
	$(".reset").live("click",function()
	{
		var id = $(this).attr('sign');
		var url = "index.php?m=Admin&c=Setting&a=resetPass";
		var data = {id:id,typ:'json'};
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			tips(res.content,1);
		}
		else
		{
			tips(res.content,2);
		}
	})

	$(".cancel-btn").click(function()
	{
		$("#shell").hide();
		$("#add_form").hide();
		$("#hid").val('');
	})

	//权限管理
	$(".power_set").live("click",function()
	{
		var pid = $(this).attr("sign");
		$("#pid").val(pid);
		var url = "index.php?m=Admin&c=Setting&a=getPowerById";
		var data = {pid:pid,typ:'json'};
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			$(".select_div").css("float","left");
			$(".select_div").html("无");
			var info = res.content;
			$("#table").hide();
			$("#power_table").show();
			for(var i in info)
			{
				var n = info[i];
				$(".power"+n).css("float","right");
				$(".power"+n).html("有");				
			}
		}
		else
		{
			tips(res.content,2);
		}

	});
	$(".select_div").live("click",function()
	{
		var _this = $(this);
		var ff = _this.css("float");
		switch(ff){
			case "left":
			_this.css("float","right");
			_this.html('有');
			break;
			case "right":
			_this.css("float","left");
			_this.html("无");
			break;
			default:break;
		}
	})
	$(".cancel-btn1").live("click",function()
	{
		$("#power_table").hide();
		$("#table").show();
	})
	$(".confirm-btn1").live("click",function()
	{
		var i = 0;
		var arr = Array();
		$(".select_div").each(function()
		{
			var _this = $(this);
			if(_this.html() == '有')
			{
				arr[i] = _this.attr("sign");
				i++;
			}
			
		})
		console.info(arr);
		var str = arr.join(",");
		console.info(str);
		var pid = $("#pid").val();
		var url = "index.php?m=Admin&c=Setting&a=setPower";
		var data = {pid:pid,power:str,typ:'json'};
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			tips(res.content,1);
			$("#table").show();
			$("#power_table").hide();
		}
		else
		{
			tips(res.content,2);
		}
	})

	//删除按钮
	$(".del-btn").live("click",function()
	{
		var msg = "您真的确定要删除吗？\n\n请确认！";
		if(confirm(msg)==true)
		{
			var _this = $(this);
			var id = $(this).attr("sign");
			var url = "index.php?m=Admin&c=Setting&a=delManage";
			var data = {id:id,typ:'json'};
			var res = ajax(url,data);
			if(res.status == 'success')
			{
				tips(res.content,1);
				_this.parents('tr').remove();
			}
			else
			{
				tips(res.content,2);
			}
		}
	})
	setTimeout("getList();",500);
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