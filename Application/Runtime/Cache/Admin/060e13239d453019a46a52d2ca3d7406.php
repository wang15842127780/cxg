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
	input{
		margin-top:10px;
		width:100px;
	}
	.add_left{
		display: inline-block;
		width: 25%;
		text-align: right;
	}
	.add_right{
		display: inline-block;
	}
</style>
<br>
<h1 class="tt_h1">位置：班级管理>查看班级</h1>
<p style="display:inline-block;width:45%;padding-left:30px;">
	年组名：<select name="syear" id="syear">
		<?php if(is_array($yearList)): foreach($yearList as $key=>$list): ?><option value="<?php echo ($list["id"]); ?>"><?php echo ($list["name"]); ?></option><?php endforeach; endif; ?>
	</select> &nbsp;&nbsp;
	班级名：<input type="text" id="sname">&nbsp;&nbsp;
	<button class="search"><i class="search-btn-img"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;查找</button>
</p>
<p style="text-align:right;display:inline-block;width:50%;"><button class="add-btn"><i class="add-btn-img"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;添加班级信息</button></p>
<br>
<div id="con_div">
	<table id="table" class="new_table">
		<tr style="display:none;">
			<th>ID</th>
			<th>年组名</th>
			<th>班级名</th>
			<th>班主任</th>
			<th>班级人数</th>
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
<div id="add_form" style="position: absolute; left: 0px; top: 0px; right: 0px; z-index: 9999; text-align: center;display:none;">
	<form id="form" onsubmit="return false;" style="display:inline-block;width:400px;background:#fff;margin-top:150px;">
	<br>
		<p>添 加 班 级</p>
		<br>
		<input type="hidden" id="hid">
		<p class="add_left">年&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;组：</p>
		<p class="add_right"><select name="year" id="year" style="margin-top:10px;width:104px;">
			
		</select></p>
		<br>
		<p class="add_left">班&nbsp;主&nbsp;任：</p>
		<p class="add_right">
			<select name="leader" id="leader" style="margin-top:10px;width:104px;">
			
		</select>
		</p>
		<br>
		<p class="add_left">班&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名：</p>
		<p class="add_right"><input type="text" name="name" id="name"></p>
		<br>
		<p class="add_left">人&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;数：</p>
		<p class="add_right"><input type="text" name="num" id="num"></p>
		
		<br><br>
		<p>
			<button class="confirm-btn">确定</button>&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="cancel-btn">取消</button><br><br>
		</p>
		
	</form>
</div>

<script type="text/javascript">
	window.getList = function(data={})
	{
		var url = "index.php?m=Admin&c=Setting&a=getClassList";
		data.typ = 'json';
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			$("#table").find('tr').show();
			$(".zshow").hide();
			var field = Array();
			field[0] = 'id';
			field[1] = 'year_text';
			field[2] = 'name';
			field[3] = 'leader_text';
			field[4] = 'num';
			var lists = res.content;
			if(res.leader == 1)
			{
				listPage(lists,1,15,field,true);
			}
			else
			{
				field[5] = "act_text";
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

	$(".search").click(function()
	{
		var sname = $("#sname").val();
		var syear = $("#syear").val();
		var cond = {sname:sname,syear:syear};
		getList(cond);
	})

	$(".add-btn").click(function()
	{
		$("#shell").show();
		$("#add_form").show();
		var ylist = <?php echo ($yearLists); ?>;
		console.info(ylist);
		var str = "";
		for(var i in ylist)
		{
			str += "<option value='"+ylist[i].id+"'>"+ylist[i].name+"</option>";
		}
		$("#year").html(str);
		var url = "index.php?m=Admin&c=Setting&a=getTeacherByYear";
		var data = {typ:'json'};
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			var llist = res.content;
			var strl = "";
			for(var j in llist)
			{
				strl += "<option value='"+llist[j].id+"'>"+llist[j].name+"</option>";
			}
			$("#leader").html(strl);
		}
		else
		{
			tips(res.content,2);
		}
			
	})

	$("#year").live("change",function()
	{
		var val = $(this).val();
		var url = "index.php?m=Admin&c=Setting&a=getTeacherByYear";
		var data = {id:val,typ:'json'};
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			var list = res.content;
			var str = "";
			for(var i in list)
			{
				str += "<option value='"+list[i].id+"'>"+list[i].name+"</option>";
			}
			$("#leader").html(str);
		}
		else
		{
			tips(res.content,2);
			$("#leader").html("");
		}
	})

	$(".confirm-btn").click(function()
	{
		var id = $("#hid").val();
		var year = $("#year").val();
		if($.trim(year) == '')
		{
			tips('请先设置年组信息！',2);
			return;
		}
		var leader = $("#leader").val();
		if($.trim(leader) == "")
		{
			tips("请先设置教师信息！",2);
			return;
		}
		var name = $("#name").val();
		if($.trim(name) == "")
		{
			tips('班级名不能为空！',2);
			return;
		}
		var num = $("#num").val();
		if($.trim(num) == '')
		{
			tips('班级人数不能为空！',2);
			return;
		}
		if($.trim(id) == "")
		{
			var url = "index.php?m=Admin&c=Setting&a=addClass";
			var data = {year:year,name:name,num:num,leader:leader,typ:'json'};
		}
		else
		{
			var url = "index.php?m=Admin&c=Setting&a=editClass";
			var data = {id:id,year:year,name:name,num:num,leader:leader,typ:'json'};
		}
			
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

	$(".cancel-btn").click(function()
	{
		$("#shell").hide();
		$("#add_form").hide();
		$("#hid").val('');
		$("#name").val("");
		$("#num").val("");
	})

	$(".edit-btn").live("click",function()
	{
		var id = $(this).attr('sign');
		var url = "index.php?m=Admin&c=Setting&a=getClassById";
		var data = {id:id,typ:'json'};
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			$("#hid").val(id);
			$("#shell").show();
			$("#add_form").show();
			var info = res.content;
			$("#name").val(info.name);
			$("#num").val(info.num);
			var ylist = <?php echo ($yearLists); ?>;
			var str = "";
			for(var i in ylist)
			{
				if(ylist[i].id == info.year_id)
				{
					str += "<option value='"+ylist[i].id+"' selected>"+ylist[i].name+"</option>";
				}
				else
				{
					str += "<option value='"+ylist[i].id+"'>"+ylist[i].name+"</option>";
				}
			}
			$("#year").html(str);
			var llist = <?php echo ($leaderLists); ?>;
			var strl = "";
			for(var j in llist)
			{
				if(llist[j].id == info.leader_id)
				{
					strl += "<option value='"+llist[j].id+"' selected>"+llist[j].name+"</option>";
				}
				else
				{
					strl += "<option value='"+llist[j].id+"'>"+llist[j].name+"</option>";
				}
			}
			$("#leader").html(strl);
		}
		else
		{
			tips(res.content,2);
		}

	})

	$(".del-btn").live("click",function()
	{
		var msg = "您真的确定要删除吗？\n\n请确认！";
		if(confirm(msg)==true)
		{
			var _this = $(this);
			var id = $(this).attr("sign");
			var url = "index.php?m=Admin&c=Setting&a=delClass";
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