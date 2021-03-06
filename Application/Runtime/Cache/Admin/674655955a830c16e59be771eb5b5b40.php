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
<h1 class="tt_h1">位置：宿舍管理>扣分项目管理</h1>
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
	.edit-btn{
		display:none;
	}
	.add_left{
		display: inline-block;
	    width: 25%;
	    text-align: right;
	}
	.add_right{
		display: inline-block;
		width: auto;
	}
</style>
<button class="add-btn" style="position:absolute;right:50px;"><i class="add-btn-img"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;添加扣分项目</button>
<br>
<div style="position:absolute;left:0;top:111px;right:0;bottom:0;overflow:auto;">
	<table id="table" style="display:none;margin-left:20px;margin-top:0;margin-bottom:10px;">
		<tr class="tb_tr_th">
			<th>ID</th>
			<th>扣分项目</th>
			<th>分值</th>
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
<div id="add_form" style="position: absolute; left: 0px; top: 0px; right: 0px; z-index: 9999; text-align: center; display:none;font-size:17px;">
	<form id="form" onsubmit="return false;" style="display:inline-block;width:400px;background:#fff;margin-top:150px;">
	<br>
		<p>添 加 扣 分 项 目</p>
		<br>
		<p class="add_left">名&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称：</p>
		<p class="add_right"><input type="text" name="name" id="name"></p>
		<br>
		<br>
		<p class="add_left">分&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;数：</p>
		<p class="add_right"><input type="text" name="num" id="num" placeHolder='填入正整数即可'></p>
		
		<br><br>
		<p>
			<button class="confirm-btn">确定</button>&nbsp;&nbsp;&nbsp;&nbsp;
			<button class="cancel-btn">取消</button><br><br>
		</p>
		
	</form>
</div>
<script type="text/javascript" src="/cxg/Public/js/admindate.js"></script>
<script type="text/javascript">
	window.getHealthItem = function()
	{
		var url = "index.php?m=Admin&c=Health&a=getHealthItem";
		var data = {typ:'json'};
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			$("#table").show();
			$(".zshow").hide();
			var list = res.content;
			var field = Array();
			field[0] = 'id';
			field[1] = 'item';
			field[2] = 'score';
			listPage(list,1,20,field,true);
		}
		else
		{
			tips(res.content,2);
			$(".zshow").hide();
		}
	}
	$(".add-btn").click(function()
	{
		$("#shell").show();
		$("#add_form").show();
	})
	$(".cancel-btn").click(function()
	{
		$("#name").val("");
		$("#num").val("");
		$(".zshow").hide();
		$("#add_form").hide();
	})
	$(".confirm-btn").click(function()
	{
		var name = $.trim($("#name").val());
		var num = $.trim($("#num").val());
		if(name == '')
		{
			tips("项目名称不能为空！");
			return;
		}
		if(num == "")
		{
			tips("分值不能为空！");
			return;
		}
		if(parseInt(num) == 0)
		{
			tips("分数格式不合理！");
			return;
		}
		// alert(111);
		var url = "index.php?m=Admin&c=Health&a=addHealthItem";
		var data = {item:name,score:num,typ:'json'};
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
	$(".del-btn").live("click",function()
	{
		var id = $(this).attr("sign");
		var _this = $(this);
		var url = "index.php?m=Admin&c=Health&a=delHealthItem";
		var data = {id:id,typ:'json'};
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
	})

	setTimeout("getHealthItem();",500);
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
	if(parseInt(nn) == 74)
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