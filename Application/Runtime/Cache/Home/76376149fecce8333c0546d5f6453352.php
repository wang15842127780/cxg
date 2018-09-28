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
	table{
		border-collapse:collapse;
		margin-left:30px;
		margin-top:10px;
	}
	td{
		/*min-width:140px;
		height:45px;
		font-size:18px;
		border:1px solid black;
		line-height:45px;*/
	}
	.del-btn{
		/*width:30px;
		height:100%;
		float:right;*/
		/*background:black;*/
		/*color:white;*/
		display:none;
		/*cursor:pointer;*/
		/*border-left:1px solid black;*/
	}
	.edit-btn{
		/*width:30px;
		height:100%;
		float:right;*/
		background:#fff !important;
		/*color:white;*/
		/*display:none;*/
		/*cursor:pointer;
		border-left:1px solid black;*/
	}
</style>
<br>
<h1 class="tt_h1">查看出勤信息</h1>
<br>
<form action="index.php?m=Home&c=Night&a=index&id=3.46" method="post" id="form" style="display:none;">
	<input type="text" name="croom" id="croom">
	<input type="text" name="ctype" value="2">
	<input type="text" name="ctime" id="ctime">
</form>
<table id="record">
	<?php if($class["l1"] != ''): ?><tr id="l1">
			<td class="tb_tr_tt">一年级</td>
			<?php if(is_array($class["l1"])): foreach($class["l1"] as $key=>$list): ?><td title="<?php echo ($list["id"]); ?>" class='croom'>
					<?php echo ($list["name"]); ?>
					<span <?php if($list["count"] == ''): ?>class="del-btn"<?php else: ?>class="edit-btn"<?php endif; ?>>
						<?php if($list["count"] == ''): ?>0<?php else: echo ($list["count"]); endif; ?>
					</span>
				</td><?php endforeach; endif; ?>
		</tr><?php endif; ?>
	<?php if($class["l2"] != ''): ?><tr id="l2">
			<td class="tb_tr_tt">二年级</td>
			<?php if(is_array($class["l2"])): foreach($class["l2"] as $key=>$list): ?><td title="<?php echo ($list["id"]); ?>" class='croom'>
					<?php echo ($list["name"]); ?>
					<span <?php if($list["count"] == ''): ?>class="del-btn"<?php else: ?>class="edit-btn"<?php endif; ?>>
						<?php if($list["count"] == ''): ?>0<?php else: echo ($list["count"]); endif; ?>
					</span>
				</td><?php endforeach; endif; ?>
		</tr><?php endif; ?>
	<?php if($class["l3"] != ''): ?><tr id="l3">
			<td class="tb_tr_tt">三年级</td>
			<?php if(is_array($class["l3"])): foreach($class["l3"] as $key=>$list): ?><td title="<?php echo ($list["id"]); ?>" class='croom'>
					<?php echo ($list["name"]); ?>
					<span <?php if($list["count"] == ''): ?>class="del-btn"<?php else: ?>class="edit-btn"<?php endif; ?>>
						<?php if($list["count"] == ''): ?>0<?php else: echo ($list["count"]); endif; ?>
					</span>
				</td><?php endforeach; endif; ?>
		</tr><?php endif; ?>
	<?php if($class["l4"] != ''): ?><tr id="l4">
			<td class="tb_tr_tt">四年级</td>
			<?php if(is_array($class["l4"])): foreach($class["l4"] as $key=>$list): ?><td title="<?php echo ($list["id"]); ?>" class='croom'>
					<?php echo ($list["name"]); ?>
					<span <?php if($list["count"] == ''): ?>class="del-btn"<?php else: ?>class="edit-btn"<?php endif; ?>>
						<?php if($list["count"] == ''): ?>0<?php else: echo ($list["count"]); endif; ?>
					</span>
				</td><?php endforeach; endif; ?>
		</tr><?php endif; ?>
	<?php if($class["other"] != ''): ?><tr id="l1">
			<td class="tb_tr_tt">其它</td>
			<?php if(is_array($class["other"])): foreach($class["other"] as $key=>$list): ?><td title="<?php echo ($list["id"]); ?>" class='croom'>
					<?php echo ($list["name"]); ?>
					<span <?php if($list["count"] == ''): ?>class="del-btn"<?php else: ?>class="edit-btn"<?php endif; ?>>
						<?php if($list["count"] == ''): ?>0<?php else: echo ($list["count"]); endif; ?>
					</span>
				</td><?php endforeach; endif; ?>
		</tr><?php endif; ?>
</table>
<table id="detail" style="display:none;">
	<tr class="tb_tr_th">
		<th>日期</th>
		<th>星期</th>
		<th>课时</th>
		<th>总计</th>
		<th>出席</th>
		<th>缺席</th>
		<th>操作</th>
	</tr>
</table>
<script type="text/javascript">
	$(".edit-btn").click(function()
	{
		var croom = $(this).parent().attr("title");
		// // alert(croom);
		// $("#croom").val(croom);
		// $("#form").submit();
		var data = {croom:croom,typ:'json'};
		var url = "index.php?m=Home&c=Night&a=getNightRecord";
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			var list = res.content;
			$(".detail").remove();
			var str = String();
			for(var i in list)
			{
				str += "<tr class='detail tb_tr_td'>"
				+ "<td>" + list[i].date + "</td>"
				+ "<td>" + list[i].week_text + "</td>"
				+ "<td>" + list[i].time_text + "</td>"
				+ "<td>" + list[i].total + "</td>"
				+ "<td>" + list[i].attend + "</td>"
				+ "<td>" + list[i].absent + "</td>"
				+ "<td><a href='javascript:void(0);' class='vdetail' sign='"+list[i].time+"'>查看详情</a></td></tr>";
			}
			$("#record").hide();
			$("#detail").show();
			$("#detail").append(str);
			$(".vdetail").click(function()
			{
				var ctime = $(this).attr('sign');
				$("#croom").val(croom);
				$("#ctime").val(ctime);
				$("#form").submit();
			})
		}
		else
		{
			alert(res.content);
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