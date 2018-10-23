<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
			
<br>
<style type="text/css">
	.total{
		font-size:15px;
		padding-right:3px;
		border:1px solid #eee;
		background:#efefef;
		border-radius:3px;
		cursor:pointer;
	}
	#all{
		font-size:15px;
		padding-right:3px;
		border:1px solid #eee;
		background:#efefef;
		border-radius:3px;
		cursor:pointer;
	}
</style>
<h1 class="tt_h1">消费记录</h1>
<div id="cond">
	<form action="index.php?m=Home&c=Mess&a=index&id=5.55" method="post">
		姓名：<input type="text" name="sname" id="sname" value="<?php echo ($_POST['sname']); ?>" style="width:60px;">
		&nbsp;
		开始时间：<input class="sang_Calender" type="text" name="stime" value="<?php echo ($_POST['stime']); ?>" placeholder="请选择"  readonly style="width:130px;">&nbsp;
		结束时间：<input class="sang_Calender" type="text" name="etime" value="<?php echo ($_POST['etime']); ?>" placeholder="请选择"  readonly style="width:130px;">&nbsp;
		<!-- 类型：<select name="ctype" id="ctype">
			<option value="0" <?php if($_POST['ctype']== 0): ?>selected<?php endif; ?> >全部</option>
			<option value="1" <?php if($_POST['ctype']== 1): ?>selected<?php endif; ?> >正常</option>
			<option value="2" <?php if($_POST['ctype']== 2): ?>selected<?php endif; ?> >异常</option>
		</select> -->
		<input type="submit" id="submit" value="搜索" style="padding:1px;margin-left:10px;padding-top:0;padding-bottom:0;">
		<span style="float:right;margin-right:60px;">
			统计：
			<span class="total" id="today">今日统计</span>
			<span class="total" id="seven">近七天</span>
			<span class="total" id="month">本月统计</span>
			<span id="all">总览</span>
		</span>
	</form>
</div>
<br id="bb">
<?php if($log == ''): ?><p class="ss" style="color:red;font-size:20px;">暂无统计数据</p>
<?php else: ?>
<table id="table" class="ss">
	<tr class="tb_tr_th">
		<th>ID</th>
		<th>姓名</th>
		<th>操作</th>
		<th>设备名</th>
		<th>时间</th>
	</tr> 
	<?php if(is_array($log)): foreach($log as $key=>$lists): ?><tr class="tb_tr_td">
			<td><?php echo ($lists["id"]); ?></td>
			<td><?php echo ($lists["stu_name"]); ?></td>
			<td><?php echo ($lists["operate"]); ?></td>
			<td><?php echo ($lists["device_name"]); ?></td>
			<td><?php echo ($lists["datetime"]); ?></td>
		</tr><?php endforeach; endif; ?>
	<tr>
		<td colspan="5"><?php echo ($page_info); ?></td>
	</tr>
</table><?php endif; ?>
<p style="font-size:30px;margin-top:50px;display:none;" class="aa"><span id="sleft"></span><span id="sright" style="color:red;"></span></p>
<script type="text/javascript" src="/cxg/Public/js/datetime.js"></script>
<script type="text/javascript">
	$("#submit").click(function()
	{
		$(".ss").show();
		$(".aa").hide();
		$(".dd").hide();
	})
	$(".total").click(function()
	{
		var id = $(this).attr("id");
		var url = "index.php?m=Home&c=Mess&a=getTotal";
		var data = {did:id,typ:'json'};
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			$("#sleft").html(res.sleft);
			$("#sright").html(res.sright);
			$(".ss").hide();
			$(".aa").show();
			$(".dd").hide();
		}
		else
		{
			tips(res.content,2);
		}
	})
	$("#all").click(function()
	{
		$(".ss").hide();
		$(".aa").hide();
		var url = "index.php?m=Home&c=Mess&a=getAll";
		var data = {typ:'json'};
		var res = ajax(url,data);
		console.info(res);
		if(res.status == 'success')
		{
			var str = String();
			var list = res.content;
			str = "<table id='table' class=\"dd\"><tr class=\"tb_tr_th\"><th>月份</th><th>充值总额</th><th>销售总额</th></tr>";
			for(var i in list)
			{
				str += "<tr class='tb_tr_td'><td>"+i+"</td><td>￥"+list[i].recharge+"</td><td>￥"+list[i].consume+"</td></tr>";
			}
			str += "</table>";
			// $(".ss").show();
			$(".dd").remove();
			$("#bb").after(str);
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