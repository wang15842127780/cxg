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
<h1 class="tt_h1">位置：宿舍管理>宿舍卫生管理</h1>
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
	.detail_table,.hostel_detail,.hostel_table{
		border-collapse: collapse;
	}
	.detail_table th,.detail_table td,.hostel_detail th,.hostel_detail td,.hostel_table th,.hostel_table td{
		border:1px solid #ccc;
		width: 200px;
		text-align: center;
		height: 30px;
		font-size: 10pt;
		border-collapse: collapse;
		background: #fff;
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
	.item{
		width:25px;
		height: 25px;
		background-repeat: no-repeat;
		background-position: 2px;
		margin-top: 5px;
		display: inline-block;
		background-image: url("/cxg/Public/iconfont/item.png");
		background-size: 21px 21px;
		background-color:#fff;
		cursor:pointer;
	}
	.item_selected{
		width:25px;
		height: 25px;
		background-repeat: no-repeat;
		background-position: 2px;
		margin-top: 5px;
		display: inline-block;
		background-image: url("/cxg/Public/iconfont/item_selected.png");
		background-size: 21px 21px;
		background-color:#fff;
		cursor:pointer;
	}
	.classify{
		width:25px;
		height: 25px;
		background-repeat: no-repeat;
		background-position: 2px;
		margin-top: 5px;
		display: inline-block;
		background-image: url("/cxg/Public/iconfont/classify.png");
		background-size: 21px 21px;
		background-color:#fff;
		cursor:pointer;
	}
	.classify_selected{
		width:25px;
		height: 25px;
		background-repeat: no-repeat;
		background-position: 2px;
		margin-top: 5px;
		display: inline-block;
		background-image: url("/cxg/Public/iconfont/classify_selected.png");
		background-size: 21px 21px;
		background-color:#fff;
		cursor:pointer;
	}
	/*扣分项目管理按钮*/
	#item{
		position:absolute;
		right:20px;
		background:#0eace0;
		border-radius: 3px;
		height:25px;
		margin-top:3px;
		color:#fff;
		padding:1px;
	}
</style>
<div id="cond" style="background:#eee;">
	<div class="item_selected" title="按学生信息查看"></div>
	<div class="classify" style="margin-left:20px;" title="按寝室信息查看"></div>
	<button id="item">管理扣分项目</button>
</div>
<br>
<div style="position:absolute;left:0;top:111px;right:0;bottom:0;overflow:auto;" class="new_table">
	<table id="table" class="new_table" style="display:none;margin-left:20px;margin-top:0;margin-bottom:10px;">
		<tr class="tb_tr_th">
			<th>ID</th>
			<th>姓名</th>
			<th>班级</th>
			<th>宿舍</th>
			<th>分数</th>
			<th>操作</th>
		</tr>
	</table>
</div>
<div style="position:absolute;left:20px;top:130px;right:0;bottom:0;overflow:auto;display:none;border-radius:8px;" class="detail_table">
	<table id="detail_table" class="detail_table" style="display:none;margin-left:10px;margin-top:15px;margin-bottom:10px;">
		<tr class="tb_tr_th">
			<th>姓名</th>
			<th>班级</th>
			<th>日期</th>
			<th>扣分详情</th>
		</tr>
	</table>
</div>
<div style="position:absolute;left:0;top:111px;right:0;bottom:0;overflow:auto;display:none;" class="hostel_table">
	<table id="hostel_table" class="hostel_table" style="display:none;margin-left:20px;margin-top:20px;margin-bottom:10px;">
		<tr class="tb_tr_th">
			<th>宿舍</th>
			<th>评分</th>
			<th>操作</th>
		</tr>
	</table>
</div>
<div style="position:absolute;left:20px;top:130px;right:0;bottom:0;overflow:auto;display:none;border-radius:8px;" class="hostel_detail">
	<table id="hostel_detail" class="hostel_detail" style="display:none;margin-left:10px;margin-top:15px;margin-bottom:10px;">
		<tr class="tb_tr_th">
			<th>ID</th>
			<th>姓名</th>
			<th>班级</th>
			<th>宿舍</th>
			<th>分数</th>
		</tr>
	</table>
</div>
<div id="shell" class="zshow">
	
</div>
<div id="shell_img" class="zshow">
        <img src="/cxg/Public/iconfont/loading.gif" width="35" height="35">
        <p>加载中...</p>
</div>
<input type="hidden" id="hid">
<script type="text/javascript" src="/cxg/Public/js/admindate.js"></script>
<script type="text/javascript">
	window.getStudentsByPointsDesc = function()
	{
		var url = "index.php?m=Admin&c=Health&a=getStudentsByPointsDesc";
		var data = {typ:'json'};
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
			field[1] = 'name';
			field[2] = 'class_text';
			field[3] = 'hostel_text';
			field[4] = 'points';
			field[5] = 'act_text';
			listPage(list,1,30,field);
		}
		else
		{
			tips(res.content,2);
			$(".zshow").hide();
		}
	}
	$(".detail").live("click",function()
	{
		var sid = $(this).attr("sign");
		var url = "index.php?m=Admin&c=Health&a=getDetailByStudentId";
		var data = {sid:sid,typ:'json'};
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			var list = res.content;
			var str = "";
			for(var i in list)
			{
				str += "<tr class='details'><td>"+list[i].student_name+"</td><td>"+list[i].class_text+"</td><td>"+list[i].points_date+"</td><td>"+list[i].points_details+"</td></tr>";
			}
			str += "<tr class='details' style='height:40px;'><td colspan='4'><button id='return' style='width:60px;height:28px;background:orange;color:#fff;'>返回</button></td></tr>"
			$(".details").remove();
			$("#detail_table").append(str);
			$(".new_table").hide();
			$(".detail_table").show();
		}
		else
		{
			tips(res.content,2);
		}
	})
	//按寝室分数查看
	window.getHostelByGradeAsc = function()
	{
		var url = "index.php?m=Admin&c=Health&a=getHostelByGradeAsc";
		var data = {typ:'json'};
		var res = ajax(url,data);
		// console.info(res);
		if(res.status == 'success')
		{
			$(".hostel_detail_table").remove();
			var str = '';
			var lists = res.content;
			for(var i in lists)
			{
				str += "<tr class='hostel_detail_table'><td>"+lists[i].hostel+"</td><td>"+lists[i].grade+"</td><td>"+lists[i].act_text+"</td></tr>";
			}
			$("#hostel_table").append(str);
		}
		else
		{
			tips(res.content,2);
		}
	}
	$(".hostel_details").live("click",function()
	{
		var id = $(this).attr("sign");
		var url = 'index.php?m=Admin&c=Health&a=getDetailByHostelId';
		var data = {hid:id,typ:'json'};
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			var lists = res.content;
			var str = '';
			for(var i in lists)
			{
				str += "<tr class='hostel_details_table'><td>"+lists[i].id+"</td><td>"+lists[i].name+"</td><td>"+lists[i].class_text+"</td><td>"+lists[i].hostel_text+"</td><td>"+lists[i].points+"</td></tr>";
			}
			str += "<tr class='hostel_details_table' style='height:40px;'><td colspan='5'><button id='return1' style='width:60px;height:28px;background:orange;color:#fff;'>返回</button></td></tr>"
			$(".hostel_details_table").remove();
			$("#hostel_detail").append(str);
			$(".hostel_detail").show();
			$(".hostel_table").hide();
		}
		else
		{
			tips(res.content,2);
		}
	})

	$("#return").live("click",function()
	{
		$(".new_table").show();
		$(".detail_table").hide();
	})
	$("#return1").live("click",function()
	{
		$(".hostel_detail").hide();
		$(".hostel_table").show();
	})

	$(".item").live("click",function()
	{
		$(this).attr("class","item_selected");
		$(".classify_selected").attr("class","classify");
		$(".new_table").show();
		$(".detail_table").hide();
		$(".hostel_detail").hide();
		$(".hostel_table").hide();
		getStudentsByPointsDesc();
	})
	$(".classify").live("click",function()
	{
		$(this).attr("class","classify_selected");
		$(".new_table").hide();
		$(".detail_table").hide();
		$(".hostel_detail").hide();
		$(".hostel_table").show();
		$(".item_selected").attr("class","item");
		getHostelByGradeAsc();
	})
	$("#item").click(function()
	{
		window.location.href = "?m=Admin&c=Health&a=index&id=7.74";
	})

	setTimeout("getStudentsByPointsDesc();",500);
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