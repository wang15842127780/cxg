<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>校园管理系统</title>
	<script type="text/javascript" src="/cxg/Public/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="/cxg/Public/js/fun.js"></script>
	<link rel="stylesheet" href="/cxg/Public/css/index.css" type="text/css">
	<style type="text/css">
		.hide{
			display:none;
		}
		.color{
			background:#434343 !important;
		}
	</style>
</head>
<body>
	<div id="body">
		<!-- 顶部图片 -->
		<!-- <img src="./images/top3.jpg" style="height:75px;width:1280px;" /> -->
		<div id="top" style="background-image:url(/cxg/Public/images/dbyc.jpg);background-size:100% 75px;">
<span style='display:inline-block;margin-right:15%;'>用户名：<?php echo (cookie('user')); ?>&nbsp;<a href='/cxg/index.php?m=Home&c=Index&a=editPass'>[修改密码]</a>&nbsp;<a href="javascript:void(0);" id="logout">[退出]</a></span>
		</div>
		<input type="hidden" id="htype" value="<?php echo ($typ); ?>">
		<!-- 主菜单 -->
		<div id="main_menu">
			<ul>
				<li>主菜单</li>
				<?php if(is_array($main_menu)): foreach($main_menu as $key=>$list): ?><li><a href="javascript:void(0);" title="<?php echo ($list["id"]); ?>" class="maina"><?php echo ($list["menu_name"]); ?></a></li><?php endforeach; endif; ?>
			</ul>
		</div>
		<!-- 主页内容  -->
		<div id="home" style='overflow:auto;'>
			
<style type="text/css">
	#home{
		overflow:hidden !important;
	}
</style>
<br>
<h1 class="tt_h1">学生请假记录</h1>
<div id="cond">
	<form onsubmit="return false;">
		姓名：<input type="text" name="uname" id="uname" style="width:60px;">
		&nbsp;
		状态：<select name="status" id="status">
			<option value="10">全部</option>
			<option value="1">待提交</option>
			<option value="3">已提交</option>
			<option value="4">待批准</option>
			<option value="5" selected>已批准</option>
			<option value="7">已拒绝</option>
		</select>&nbsp;
		开始时间：<input class="sang_Calender" type="text" name="stime" value="<?php echo ($_POST['stime']); ?>" placeholder="请选择" id="stime" readonly style="width:130px;">&nbsp;
		结束时间：<input class="sang_Calender" type="text" name="etime" value="<?php echo ($_POST['etime']); ?>" placeholder="请选择" id="etime" readonly style="width:130px;">&nbsp;
		<input type="submit" id="submit" value="搜索" style="padding:1px;margin-left:10px;padding-top:0;padding-bottom:0;">
	</form>
</div>
<div style="height:480px;overflow:auto;">
	<table id="table" style="display:none;">
		<tr class="tb_tr_th">
			<th>ID</th>
			<th>姓名</th>
			<th>班级</th>
			<th>班主任</th>
			<th>开始时间</th>
			<th>结束时间</th>
			<th>状态</th>
		</tr>
	</table>
</div>
<script type="text/javascript" src="/cxg/Public/js/datetime.js"></script>
<script type="text/javascript">
	window.getList = function(data={})
	{
		var url = 'index.php?m=Home&c=Hostel&a=leaveRecord';
		data.typ = 'json';
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			$("#table").show();
			var list = res.content;
			var field = Array();
			field[0] = 'id';
			field[1] = 'student_text';
			field[2] = 'class_text';
			field[3] = 'leader';
			field[4] = 'begin_date';
			field[5] = 'end_date';
			field[6] = 'status_text';
			listPage(list,1,30,field);
		}
		else
		{
			$("#table").hide();
			tips(res.content,2);
		}
	}

	$("#submit").click(function()
	{
		var uname = $("#uname").val();
		var stime = $("#stime").val();
		var etime = $("#etime").val();
		var status = $("#status").val();
		var cond = {uname:uname,stime:stime,etime:etime,status:status};
		getList(cond);
	})
	setTimeout("getList();",500);
</script>


		</div>

		<!-- 子菜单 -->
		<div id="sub_menu">
			<?php if(is_array($menu)): foreach($menu as $key=>$lists): ?><ul class="menu<?php echo ($lists["id"]); ?> sub" style="display:none;">
					<?php if(is_array($lists["sub_menu"])): foreach($lists["sub_menu"] as $key=>$sub): ?><li>
							<a href="javascript:void(0);" class="mina mina<?php echo ($lists["id"]); ?>"><?php echo ($sub["menu_name"]); ?>&nbsp;<l class="i">></l></a>
							<?php if(is_array($sub["sub_menu"])): foreach($sub["sub_menu"] as $key=>$min): ?><p class='min_menu hide' style="font-size:15px;height:30px;line-height:30px;"><a href="javascript:void(0);" title="<?php echo ($min["id"]); ?>" sign="<?php echo ($lists["id"]); ?>.<?php echo ($min["id"]); ?>" class="fun fun<?php echo ($min["id"]); ?>" ><?php echo ($min["menu_name"]); ?></a></p><?php endforeach; endif; ?>
						</li><?php endforeach; endif; ?>
				</ul><?php endforeach; endif; ?>
		</div>
		
		<!-- 底部图片 -->
		<img src="/cxg/Public/images/footer1.jpg" style="height:35px;width:100%;margin-top:-4px;">
	</div>
	
</body>
</html>
<script type="text/javascript">
	$("#logout").click(function()
	{
		window.location.href = "/cxg/index.php?m=Home&c=Log&a=logout";
	})
	$(".maina").click(function()
	{
		var id = $(this).attr("title");
		$(".sub").hide();
		$(".menu"+id).show();
	})
	$(".mina").click(function()
	{
		$(".i").html(">");
		$(".min_menu").addClass("hide");
		$(".min_menu").parent().removeClass("color");
		$(this).find(".i").html("v");
		$(this).siblings("p").removeClass("hide");
		$(this).siblings("p").parent().addClass("color");
	})
	
	function getCookie(cookieName)
	{
		var strCookie = document.cookie;
		var arrCookie = strCookie.split("; ");
		for(var i=0;i<arrCookie.length;i++)
		{
			var arr = arrCookie[i].split("=");
			if(cookieName == arr[0])
			{
				return arr[1];
			}
		}
		return "";
	}
	var utype = getCookie('type');
	if(utype != 1)
	{
		$(".fun21").parents("li").siblings().remove();
		$(".fun22").parent().remove();
	}

	var type = $("#htype").val();
	console.info(type);
	var aa = type.split(".")[0];
	var bb = type.split(".")[1];
	// alert(aa);
	// alert(bb);
	$(".menu"+aa).show();
	$(".fun"+bb).parent().removeClass('hide');
	$(".fun"+bb).parents("li").addClass('color');
	$(".fun"+bb).parent().siblings("p").removeClass('hide');
	$(".fun"+bb).parent().siblings("a").find(".i").html("v");

	var test = window.location.href;
	var pos = test.indexOf("id=");
	var le = test.substr(0,pos);
	// alert(le);
	$('.fun').click(function()
	{
		var ii = $(this).attr('title');
		var iii = $(this).attr('sign');
		window.location.href = 'index.php?m=Home&c=Index&a=index&'+"act="+iii;
	})

</script>