<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>校园管理系统</title>
	<script type="text/javascript" src="/cxg/Public/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="/cxg/Public/js/livequery.js"></script>
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
		display: inline-block;
		text-align: center;
	}
	.lp{
		text-align:left;
		font-size:16px;
		border:1px solid #ccc;
		border-top:0;
		padding: 8px 0;
	}
</style>
<br>
<h1 class="tt_h1">学生请假记录</h1>
<div id="cond">
	<form onsubmit="return false;">
		姓名：<input type="text" name="uname" id="uname" style="width:60px;">
		&nbsp;
		<?php if($userType == 1): ?><span style="">
				年组：<select name="year" id="year">
					<option value="0">全部</option>
					<?php if(is_array($yearList)): foreach($yearList as $key=>$lists): ?><option value="<?php echo ($lists["id"]); ?>"><?php echo ($lists["name"]); ?></option><?php endforeach; endif; ?>
				</select>
			</span><?php endif; ?>
		开始时间：<input class="sang_Calender" type="text" name="stime" value="<?php echo ($_POST['stime']); ?>" placeholder="请选择" id="stime" readonly style="width:130px;">&nbsp;
		结束时间：<input class="sang_Calender" type="text" name="etime" value="<?php echo ($_POST['etime']); ?>" placeholder="请选择" id="etime" readonly style="width:130px;">&nbsp;
		<input type="submit" id="submit" value="搜索" style="padding:1px;margin-left:10px;padding-top:0;padding-bottom:0;">
	</form>
</div>
<button id="add-btn" style="background:orange;width:75px;height:25px;border-radius:5px;display:block;margin-top:5px;margin-left:50px;">+请假申请</button>
<br>
<div style="height:480px;overflow:auto;">
	<table id="table" style="display:none;">
		<tr class="tb_tr_th">
			<th>ID</th>
			<th>姓名</th>
			<th>班级</th>
			<th>原因</th>
			<th>班主任</th>
			<th style="min-width:280px;">请假时间</th>
			<th>创建人</th>
			<th>状态</th>
			<th>详细信息</th>
		</tr>
	</table>
</div>
<div id="shell" style="position:absolute;left:0;top:0;right:0;bottom:0;background:#fff;opacity:0.7;display:none;">
	
</div>
<div id="detail_box" style="position:absolute;left:0;top:0;right:0;bottom:0;text-align:center;display:none;">
	<div style="width:450px;background:#acf6ff;display:inline-block;margin-top:100px;border:1px solid #aaa;border-radius:10px;">
		<p class="p">查看详情</p>
		<p class="lp" style="border-top:1px solid #ccc;"><span class="left">姓名：&nbsp;</span>&nbsp;<span class="right" id="name"></span></p>
		<p class="lp"><span class="left">班级：&nbsp;</span>&nbsp;<span class="right" id="class"></span></p>
		<p class="lp"><span class="left">原因：&nbsp;</span>&nbsp;<span class="right" id="reason"></span></p>
		<p class="lp"><span class="left">班主任：&nbsp;</span>&nbsp;<span class="right" id="leader"></span></p>
		<!-- <p class="lp"><span class="left">开始时间：&nbsp;</span>&nbsp;<span class="right" id="begin_date"></span></p>
		<p class="lp"><span class="left">结束时间：&nbsp;</span>&nbsp;<span class="right" id="end_date"></span></p> -->
		<p class="lp"><span class="left">&nbsp;<br>请假时间：&nbsp;<br>&nbsp;</span>&nbsp;<span class="right" id="leave_date"></span></p>
		<p class="lp"><span class="left">请假意见：&nbsp;</span>&nbsp;<span class="right" id="director_note"></span></p>
		<p class="lp"><span class="left">创建人：&nbsp;</span>&nbsp;<span class="right" id="createby"></span></p>
		<p class="lp"><span class="left">状态：&nbsp;</span>&nbsp;<span class="right" id="statuss"></span></p>
		<p class="p" style="margin-bottom:10px;"><button class="cancel-btn">返回</button></p>
	</div>
</div>
<script type="text/javascript" src="/cxg/Public/js/datetime.js"></script>
<script type="text/javascript">
	var userType = <?php echo ($userType); ?>;
	if(userType == 3)
	{
		alert('您没有这项目权限');
		history.go(-1);
	}
	window.getList = function(data={})
	{
		var url = 'index.php?m=Home&c=Leave&a=stuRecord';
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
			field[3] = 'reason';
			field[4] = 'leader';
			field[5] = 'leave_date';
			field[6] = 'createby';
			field[7] = 'status_text';
			field[8] = 'detail_text';
			listPage(list,1,30,field);
		}
		else
		{
			$("#table").hide();
			tips(res.content,2);
		}
	}
	$("#add-btn").click(function()
	{
		window.location.href = 'index.php?m=Home&c=Leave&a=index&id=64.69';
	})

	$("#submit").click(function()
	{
		var uname = $("#uname").val();
		var year = $("#year").val();
		var stime = $("#stime").val();
		var etime = $("#etime").val();
		var status = $("#status").val();
		var cond = {uname:uname,stime:stime,etime:etime,status:status,year:year};
		getList(cond);
	})

	$(".commit").live("click",function()
	{
		var _this = $(this).parents("td");
		var id = $(this).parents("tr").find("td:eq(0)").html();
		var td = $(this).parents("tr").find("td");
		var len = td.length;
		var pos = parseInt(len)-1;
		var url = 'index.php?m=Home&c=Leave&a=commitLeave';
		var data = {id:id,typ:'json'};
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			tips(res.content,1);
			_this.html('已提交');
			_this.parents("tr").find("td:eq(9)").html('无');
		}
		else
		{
			tips(res.content,2);
		}
	})

	$(".edit-btn").live("click",function()
	{
		var id = $(this).parents("tr").find("td:eq(0)").html();
		window.location.href = "index.php?m=Home&c=Leave&a=index&lid="+id+"&id=64.72";
	})

	$(".del-btn").live("click",function()
	{
		var id = $(this).parents("tr").find("td:eq(0)").html();
		var _this = $(this);
		var url = "index.php?m=Home&c=Leave&a=delStu";
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
			$("#reason").html(info.reason);
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
	$(".cancel-btn").click(function()
	{
		$("#shell").hide();
		$("#detail_box").hide();
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
	if(Number(bb) == 68)
	{
		bb = 66;
	}
	if(Number(bb) == 69)
	{
		bb = 67;
	}
	if(Number(bb) == 72)
	{
		bb = 67;
	}
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