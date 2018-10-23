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
	#left,#right,#center{
		width:160px;
		height:400px;
		display:inline-block;
		overflow-y:auto;
	}
	.stu_info{
		height:24px;
	}
	.stu_info_l{
		display:inline-block;
		width:80px;
		line-height:20px;
		border:1px solid #ccc;
		background: #fff;
		border-radius:5px;
		vertical-align: middle;
		margin:1px;
	}
	.stu_info_r{
		display:inline-block;
		width:80px;
		line-height:20px;
		border:1px solid #ccc;
		background: #fff;
		border-radius:5px;
		vertical-align: middle;
		margin:1px;
	}
</style>
<br>
<h1 class="tt_h1" id="title">位置：课表管理>编辑上课人员</h1>
<div id="cond">
	<form method="post" id="form">
		星期：<select name="week" id="week"  style='width:75px;padding-left:5px;'>
			<option value="1" <?php if($_POST['week']== 1): ?>selected<?php endif; ?> >星期一</option>
			<option value="2" <?php if($_POST['week']== 2): ?>selected<?php endif; ?> >星期二</option>
			<option value="3" <?php if($_POST['week']== 3): ?>selected<?php endif; ?> >星期三</option>
			<option value="4" <?php if($_POST['week']== 4): ?>selected<?php endif; ?> >星期四</option>
			<option value="5" <?php if($_POST['week']== 5): ?>selected<?php endif; ?> >星期五</option>
			<option value="6" <?php if($_POST['week']== 6): ?>selected<?php endif; ?> >星期六</option>
			<option value="7" <?php if($_POST['week']== 7): ?>selected<?php endif; ?> >星期日</option>
		</select>
		<input type="submit" id="submit" value="搜索" style="padding:1px;margin-left:10px;padding-top:0;padding-bottom:0;">
	</form>
</div>
<br>
<table id="table">
	<tr class="tb_tr_th">
		<th>教室</th>
		<?php if(is_array($clist)): foreach($clist as $key=>$list): ?><th>
				<?php echo ($list["name"]); ?>
			</th><?php endforeach; endif; ?>
	</tr>
	<?php $__FOR_START_1625097942__=1;$__FOR_END_1625097942__=9;for($i=$__FOR_START_1625097942__;$i < $__FOR_END_1625097942__;$i+=1){ ?><tr class="tb_tr_td">
			<td>第<?php echo ($i); ?>节</td>
			<?php if(is_array($clist)): foreach($clist as $k=>$lists): ?><td class="syllabus" sign="<?php echo ($lists["$i"]["sid"]); ?>">
					<?php echo ($lists["$i"]["count"]); ?>
				</td><?php endforeach; endif; ?>
		</tr><?php } ?>
</table>
<div style="height:410px;display:none;text-align:center;" id="detail">
	<p id="tinfo" style="height:50px;"></p>
	<div id="left" style="border:1px solid black;">
		
	</div>
	<div id="center" style="line-height:380px;"><<————>></div>
	<div id="right" style="border:1px solid black;">
		
	</div>
	<p>
		<button id="gogo">完成</button>
		<button id="return">返回</button>
	</p>
</div>
<script type="text/javascript">
	window.getStuList = function(id)
	{
		var url = "index.php?m=Admin&c=Setting&a=getStuByClass";
		var data = {typ:'json',id:id};
		var res = ajax(url,data);
		return res;
	}
	window.liclick = function(id)
	{
		$(".stu_info_l").live("click",function()
		{
			var _this = $(this);
			var sid = $(this).attr("sign");
			var url1 = "index.php?m=Admin&c=Setting&a=delLessonStu";
			var data1 = {sid:sid,id:id,typ:'json'};
			var res1 = ajax(url1,data1);
			if(res1.status == 'success')
			{
				var html = _this.html();
				_this.remove();
				$("#right").find("ul").append("<li class='stu_info_r' sign="+sid+">"+html+"</li>");
			}
			else
			{
				tips(res1.content,2);
			}
		})
		$(".stu_info_r").live("click",function()
		{
			var _this = $(this);
			var sid = $(this).attr('sign');
			var url2 = "index.php?m=Admin&c=Setting&a=addLessonStu";
			var data2 = {sid:sid,id:id,typ:'json'};
			var res2 = ajax(url2,data2);
			if(res2.status == 'success')
			{
				var ban = _this.attr("ban");
				var ban_list = $("."+ban);
				var cou = ban_list.length;
				if(cou == 1)
				{
					_this.prev().remove();
				}
				var html = _this.html();
				_this.remove();
				$("#left").find("ul").append("<li class='stu_info_l' sign="+sid+">"+html+"</li>");

			}
		})
	}
	$("#return").click(function()
	{
		$("#table").show();
		$("#detail").hide();
		$("#title").html('位置：课表管理>编辑上课人员');
	})
	$("#gogo").click(function()
	{
		window.location.reload();
	})
	$(".syllabus").click(function()
	{
		var id = $(this).attr('sign');
		if($.trim(id) == "")
		{
			tips('请先安排课程，再安排学生！',2);
			return;
		}
		$(".stu_info_r").parent().remove();
		$(".stu_info_l").parent().remove();
		$("#table").hide();
		$("#title").html("人员管理");
		$("#detail").show();
		var res = getStuList(id);
		if(res.status == 'success')
		{
			$("#tinfo").html(res.content.ttitle);
			var str = String();
			var str1 = String();
			var sign = String();
			str = "<ul>";
			if(res.content.tleft != "")
			{
				var left = res.content.tleft;
				
				for(var i in left)
				{
					str += "<li class='stu_info_l' sign='"+left[i].id+"'>"+left[i].name+"</li>";
				}
				
			}
			str += "</ul>";
			$("#left").append(str);
			str1 = "<ul>";
			if(res.content.tright != "")
			{
				var right = res.content.tright;
				for(var j in right)
				{
					if(sign != right[j].room)
					{
						str1 += "<li style='text-align:left;padding-left:20px;margin-top:5px;font-weight:bold;' class='sroom'>"+right[j].room+"</li>";
						sign = right[j].room;
					}

					str1 += "<li class='stu_info_r "+sign+"' sign='"+right[j].id+"' ban="+sign+">"+right[j].name+"</li>";
				}
			}
			str1 += "<hr style='margin-top:5px;'/></ul>";
			$("#right").append(str1);
			liclick(id);
		}
		else
		{
			tips(res.content,2);
		}

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