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
	p select{
		width:70px;
		padding-left:5px;
	}
</style>
<br>
<h1 class="tt_h1">位置：课表管理>编辑课表信息</h1>
<div id="cond">
	<form method="post" id="form">
		班级：<select name="sclass" id="sclass"  style='width:75px;padding-left:5px;'>
			<?php if(is_array($clist)): foreach($clist as $k=>$clist): ?><option value="<?php echo ($clist["id"]); ?>" <?php if($clist["id"] == $class_id): ?>selected<?php endif; ?> ><?php echo ($clist["name"]); ?></option><?php endforeach; endif; ?>
		</select>
		<input type="submit" id="submit" value="搜索" style="padding:1px;margin-left:10px;padding-top:0;padding-bottom:0;">
	</form>
</div>
<input type="hidden" id="cid" value='<?php echo ($class_id); ?>'>
<p style="text-align:left;padding-left:50px;margin-top:5px;color:rgba(255, 0, 0, 0.87);">双击可修改课表</p>
<br>
<table id="table" <?php if($class_name == ''): ?>style="display:none;"<?php endif; ?> >
	<tr class="tb_tr_th">
		<th><?php echo ($class_name); ?>教室</th>
		<th>星期一</th>
		<th>星期二</th>
		<th>星期三</th>
		<th>星期四</th>
		<th>星期五</th>
		<th>星期六</th>
		<th>星期日</th>
	</tr>
	<?php $__FOR_START_1924599355__=1;$__FOR_END_1924599355__=9;for($i=$__FOR_START_1924599355__;$i < $__FOR_END_1924599355__;$i+=1){ ?><tr class="tb_tr_td">
			<td>第<?php echo ($i); ?>节</td>
			<?php $__FOR_START_118647857__=1;$__FOR_END_118647857__=8;for($j=$__FOR_START_118647857__;$j < $__FOR_END_118647857__;$j+=1){ ?><td class="kebiao" week='<?php echo ($j); ?>' time='<?php echo ($i); ?>'>
				<?php if(is_array($klist)): foreach($klist as $k=>$lists): if($lists["week"] == $j && $lists["time"] == $i): echo ($lists["subject_text"]); ?>/<?php echo ($lists["teacher_text"]); endif; endforeach; endif; ?>
			</td><?php } ?>
		</tr><?php } ?>

</table>
<div class='edit1' style='position:absolute;left:0;top:0;right:0;bottom:-500px;z-index:999;background:#ccc;opacity:0.5;display:none;'></div>
<div class='edit1' style="position:absolute;z-index:9999;width:100%;height:300px;text-align:center;left:0;top:0;display:none;">
	<div style="width:300px;height:250px;display:inline-block;background:#fff;margin-top:220px;border-radius:5px;">
		<p class="title" style="text-align:left;padding:3px;border-radius:5px;border-bottom:1px solid #ccc;background:#eee;"></p>
		<p style="margin-top:30px;text-align:left;padding-left:30px;">课程：<select name="subject" id="subject"></select></p>
		<p style="margin-top:20px;text-align:left;padding-left:30px;">教师：<select name="teacher" id="teacher"></select></p>
		<p style="margin-top:100px;text-align:right;padding-right:10px;">
			<button id='yes' style="background:#ff8d00;width:50px;height:25px;border-radius:8px;"></button>
			<button id="no" style="width:50px;height:25px;border-radius:8px;">取消</button>
		</p>
	</div>
</div>
<script type="text/javascript">
	window.getSubject = function()
	{
		var url = 'index.php?m=Admin&c=Setting&a=getSubjectList';
		var data = {typ:'json'};
		var res = ajax(url,data);
		return res;
	}
	window.getTeacher = function()
	{
		var url = 'index.php?m=Admin&c=Setting&a=getTeacher';
		var data = {typ:'json'};
		var res = ajax(url,data);
		return res;
	}
	window.update = function(data)
	{
		var url = 'index.php?m=Admin&c=Setting&a=updateSyllabus';
		var data = data;
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			$(".edit1").hide();
			tips(res.content,1);
			setTimeout('$("#submit").click();',1500);
		}
		else
		{
			tips(res.content,2);
		}
	}
	$(".kebiao").dblclick(function()
	{
		var week = $(this).attr('week');
		var time = $(this).attr('time');
		var room = $("#cid").val();
		var data = {week:week,time:time,room:room};
		var _this = $(this);
		var con = $(this).html();
		if($.trim(con) == "")
		{
			var sub_res = getSubject();
			if(sub_res.status == 'success')
			{
				var sub_list = sub_res.content;
				var sub_str = String();
				$("#subject").html("");
				for(var i in sub_list)
				{
					sub_str += "<option value='"+sub_list[i].id+"''>"+sub_list[i].name+"</option>";
				}
				$("#subject").append(sub_str);
				$(".title").html("新增课表");
				$("#yes").html("新增");
			}
			else
			{
				tips(sub_res.content,2);
				return;
			}

			var teacher_res = getTeacher();
			if(teacher_res.status == 'success')
			{
				var teacher_list = teacher_res.content;
				var teacher_str = String();
				$("#teacher").html("");
				for(var i in teacher_list)
				{
					teacher_str += "<option value='"+teacher_list[i].id+"''>"+teacher_list[i].name+"</option>";
				}
				$("#teacher").append(teacher_str);
			}
			else
			{
				tips(teacher_res.content,2);
				return;
			}
			$(".edit1").show();
		}
		else
		{
			var sub = $.trim(con.split("/")[0]);
			var tea = $.trim(con.split("/")[1]);

			var sub_res = getSubject();
			if(sub_res.status == 'success')
			{
				var sub_list = sub_res.content;
				var sub_str = String();
				$("#subject").html("");
				for(var i in sub_list)
				{
					if(sub_list[i].name == sub)
					{
						sub_str += "<option value='"+sub_list[i].id+"'' selected>"+sub_list[i].name+"</option>";
					}
					else
					{
						sub_str += "<option value='"+sub_list[i].id+"''>"+sub_list[i].name+"</option>";
					}
				}
				$("#subject").append(sub_str);
				$(".title").html("编辑课表");
				$("#yes").html("修改");
			}
			else
			{
				tips(sub_res.content,2);
				return;
			}

			var teacher_res = getTeacher();
			if(teacher_res.status == 'success')
			{
				var teacher_list = teacher_res.content;
				var teacher_str = String();
				$("#teacher").html("");
				for(var i in teacher_list)
				{
					if(teacher_list[i].name == tea)
					{
						teacher_str += "<option value='"+teacher_list[i].id+"' selected>"+teacher_list[i].name+"</option>";
					}
					else
					{
						teacher_str += "<option value='"+teacher_list[i].id+"'>"+teacher_list[i].name+"</option>";
					}
					
				}
				$("#teacher").append(teacher_str);
			}
			else
			{
				tips(teacher_res.content,2);
				return;
			}
			$(".edit1").show();
		}
		window.aaa = function()
		{
			data.subject = $("#subject").val();
			data.teacher = $("#teacher").val();
			data.typ = 'json';
			update(data);
		}
	})
	$("#no").click(function()
	{
		$(".edit1").hide();
	})
	$("#yes").click(function()
	{
		aaa();
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