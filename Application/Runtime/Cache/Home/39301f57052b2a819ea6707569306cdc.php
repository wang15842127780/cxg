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
	#show_box{
		position:absolute;
		height:250px;
		width:300px;
		text-align:center;
		background:#fff;
		left:600px;
		top:230px;
		display:none;
	}
</style>
<br>
<?php if($user_type != 1): ?><h1 class="tt_h1">我的请假记录</h1>
<?php else: ?>
	<h1 class="tt_h1">教师请假记录</h1><?php endif; ?>
<br>
<?php if($user_type != 1): ?><button id="add-btn" style="background:orange;width:75px;height:25px;border-radius:5px;display:block;margin-top:-20px;margin-left:50px;">+请假申请</button><?php endif; ?>
<?php if($_COOKIE['leader']== 1): ?><button id="group-btn" style="background:orange;width:75px;height:25px;border-radius:5px;display:block;margin-top:-25px;margin-left:150px;">组员管理</button><?php endif; ?>
<br>
<table id="table" style="display:none;">
	<tr class="tb_tr_th">
		<th>ID</th>
		<th>姓名</th>
		<th>请假理由</th>
		<th>开始时间</th>
		<th>结束时间</th>
		<th>审批人</th>
		<th>审批意见</th>
		<th>状态</th>
	</tr>
	</foreach>
</table>
<div id="shell" style="position:absolute;top:0;left:0;right:0;bottom:-200px;background:#ccc;opacity:0.7;display:none;">
	
</div>
<div id="show_box">
	<p style="margin-top:10px;margin-bottom:20px;">请假人：<span id="pp"></span></p>
	<textarea name="" id="refuse" cols="30" rows="8"></textarea>
	<br>
	<br>
	<p>
		<button class="confirm-btn">同意</button>&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="cancel-btn">拒绝</button>
	</p>
</div>
<input type="hidden" id="hid">
<script type="text/javascript" src="/cxg/Public/js/datetime.js"></script>
<script type="text/javascript">
	window.getRecord = function()
	{
		var url = "index.php?m=Home&c=Leave&a=getMyselfLeaveRecord";
		var data = {typ:'json'};
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			$("#table").show();
			var field = Array();
			field[0] = 'id';
			field[1] = 'teacher_name';
			field[2] = 'reason';
			field[3] = 'begin_date';
			field[4] = 'end_date';
			field[5] = 'auditby';
			field[6] = 'auditby_note';
			field[7] = 'status_text';
			listPage(res.content,1,10,field);
		}
		else
		{
			tips(res.content,2);
		}
	}
	setTimeout("getRecord();",300);
	$("#add-btn").click(function()
	{
		window.location.href = "index.php?m=Home&c=Leave&a=index&id=64.68";
	})

	$("#group-btn").click(function()
	{
		var url = "index.php?m=Home&c=Leave&a=getGroupLeave";
		var data = {typ:'json'};
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			$("#table").show();
			var field = Array();
			field[0] = 'id';
			field[1] = 'name';
			field[2] = 'start_time';
			field[3] = 'end_time';
			field[4] = 'reason';
			field[5] = 'status_text';
			field[6] = 'refuse';
			field[7] = 'agree';
			listPage(res.content,1,10,field);
		}
		else
		{
			tips(res.content,2);
		}
	})

	$(".verify").live("click",function()
	{
		var id = $(this).attr('sign');
		$("#hid").val(id);
		var name = $(this).parents("tr").find("td:eq(1)").html();
		$("#pp").val(name);
		$("#shell").show();
		$("#show_box").show();
	})

	$(".confirm-btn").click(function()
	{
		var url = 'index.php?m=Home&c=Leave&a=agreeLeave';
		var id = $("#hid").val();
		if($.trim(id) == '')
		{
			window.location.reload();
		}
		var data = {id:id,typ:'json'};
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			tips(res.content,1);
			setTimeout('window.location.reload();',500);
		}
		else
		{
			tips(res.content,2);
		}
	})

	$(".cancel-btn").click(function()
	{
		var id = $("#hid").val();
		if($.trim(id) == '')
		{
			window.location.reload();
		}
		var refuse = $("#refuse").val();
		if($.trim(refuse) == '')
		{
			tips('拒绝理由不能为空！');
			return;
		}
		var url = 'index.php?m=Home&c=Leave&a=refuseLeave';
		var data = {id:id,refuse:refuse,typ:'json'};
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