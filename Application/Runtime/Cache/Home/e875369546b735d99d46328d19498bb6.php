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
	table{
		border-collapse:collapse;
		margin-left:30px;
		margin-top:20px;
	}
	td{
		min-width:140px;
		height:45px;
		font-size:18px;
		border:1px solid black;
		line-height:45px;
		text-align:center;
	}
	th{
		border:1px solid black;
		height:46px;
	}
	#cond{
		padding-left:50px;
		background:#ccc;
		width:100%;
		text-align:left;
		height:35px;
		line-height:35px;
	}
	th{
		min-width:140px;
	}
	.p{
		font-size:17px;
		margin-top:20px;
		color:#3dff00;
	}
	.close{
		float:right;
		width:19px;
	}
</style>
<span id="add_manage">
<br>
<h1 class="tt_h1">新增请假信息</h1>
<p class="p">开始时间：<input class="sang_Calender" type="text" name="stime" value="" placeholder="请选择" readonly="" style="width:130px;"></p>
<p class="p">结束时间：<input class="sang_Calender" type="text" name="etime" value="" placeholder="请选择" readonly="" style="width:130px;"></p>
<p class="p" style="vertical-align:top;"><textarea name="" id="reason" cols="30" rows="10" placeHolder="请输入请假原因"></textarea> </p>
<br>
<p>
	<button class="confirm-btn">提交</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<button class="cancel-btn">取消</button>
</p>
<!-- <?php if($_COOKIE['leader']== 1): ?><div style="position:fixed;border:1px solid #ccc;right:0;top:200px;width:210px;height:140px;color:#0070ff;">
		<p style="text-align:left;padding-left:5px;">提示：<button class="close">X</button></p><br>
		1.请假5天以内由主任审批。<br><br>
		2.请假5天以上由校长审批。
	</div>
<?php else: ?>
	<div style="position:fixed;border:1px solid #ccc;right:0;top:200px;width:210px;height:170px;color:#0070ff;">
		<p style="text-align:left;padding-left:5px;">提示：<button class="close">X</button></p><br>
		1.请假1天以内由组长审批。<br><br>
		2.请假5天以为由主任审批。<br><br>
		3.请假5天以上同校长审批。
	</div><?php endif; ?> -->

<script type="text/javascript" src="/cxg/Public/js/datetime.js"></script>
<script type="text/javascript">
	$(".confirm-btn").click(function()
	{
		var stime = $("input[name='stime']").val();
		if($.trim(stime) == '')
		{
			tips('开始时间不能为空！',2);
			return;
		}
		var etime = $("input[name='etime']").val();
		if($.trim(etime) == '')
		{
			tips('结束时间不能为空！',2);
			return;
		}
		var reason = $("#reason").val();
		if($.trim(reason) == '')
		{
			tips('请假原因不能为空！',2);
			return;
		}
		if(stime > etime)
		{
			tips("开始时间不能大于结束时间！");
			return;
		}
		var url = "index.php?m=Home&c=Leave&a=addMyselfLeave";
		var data = {stime:stime,etime:etime,reason:reason,typ:'json'};
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			tips(res.content,1);
			setTimeout("window.location.href='index.php?m=Home&c=Leave&a=index&id=64.66'",500);
		}
		else
		{
			tips(res.content,2);
		}
	})


	$(".cancel-btn").click(function()
	{
		window.location.href = 'index.php?m=Home&c=Leave&a=index&id=64.66';
	})

	$(".close").click(function()
	{
		$(this).parent().parent().remove();
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