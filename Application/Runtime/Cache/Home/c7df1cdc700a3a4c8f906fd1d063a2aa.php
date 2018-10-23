<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>校园管理系统</title>
	<script type="text/javascript" src="/cxg/Public/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="/cxg/Public/js/fun.js"></script>
	<script type="text/javascript" src="/cxg/Public/js/livequery.js"></script>
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
	.tip_box{
		width:100px;
		height:40px;
		float:left;
	}
	#box{
		width:1300px;
		border:1px solid #000;
		border-radius:5px;
		background:#eee;
		margin-left:30px;
		margin-top:20px;
		padding-left:15px;
	}
	.line{
		max-width: 1300px;
		/*background:#fff;*/
		text-align:left;
		margin-top:20px;
		margin-bottom:10px;
		padding:10px;
	}
	.demo_box{
		width:80px;
		height:60px;
		border:1px solid #aaa;
		border-radius:3px;
		display:inline-block;
		margin-left: 20px;
		cursor:pointer;
	}
	.left{
		background:#0f0;
		display:inline-block;
		color:#fff;
		width:40px;
		height:35px;
		line-height: 35px;
		text-align:center;
		font-size:15px;
	}
	.right{
		color:#fff;
		/*display:inline-block;*/
		position: absolute;
		width:40px;
		height:35px;
		text-align:center;
		background:red;
		font-size:30px;
		line-height: 35px;
	}
	h3{
		font-size:18px;
	}
	h4{
		width:79px;
		height:25px;
		border-bottom:1px solid black;
		line-height: 25px;
		text-align: center
	}
</style>
<br>
<h1 class="tt_h1">查看回舍信息</h1>
<div id="cond">
	<form id="form" method='post'>
		楼号：<select name="build" id=""  style='width:70px;padding-left:5px;'>
			<?php if(is_array($hostel)): foreach($hostel as $k=>$hostel): ?><option value="<?php echo ($k); ?>" <?php if($k == $bb): ?>selected<?php endif; ?> ><?php echo ($k); ?></option><?php endforeach; endif; ?>
		</select>
		<input type="submit" value="搜索" style="padding:1px;margin-left:10px;padding-top:0;padding-bottom:0;">
	</form>
</div>
<br>
	<h1><div style="float:left;color:red;margin-left:20px;">提示：</div><div class='tip_box'><span style="background:#0f0;display:inline-block;width:49px;height:30px;color:#fff;font-size:21px;">已回</span><span style="background:#f00;display:inline-block;width:49px;height:30px;color:#fff;font-size:21px;">未回</span></div><?php echo ($bb); ?></h1>
<div id="box" <?php if($bb == ''): ?>style="display:none;"<?php endif; ?> >
	<?php if(is_array($hostel_list)): foreach($hostel_list as $key=>$list): ?><div class="line">
			<h3>第<?php echo ($key); ?>层</h3>
			<?php if(is_array($list)): foreach($list as $key=>$lists): ?><div class="demo_box" sign="<?php echo ($lists["id"]); ?>" signs="<?php echo ($bb); ?>">
					<h4><?php echo ($lists["no"]); ?></h4>
					<span class='left'><?php echo ($lists["in_num"]); ?></span>
					<span class='right'><?php echo ($lists["out_num"]); ?></span>
				</div><?php endforeach; endif; ?>
		</div><?php endforeach; endif; ?>
</div>

<script type="text/javascript">
	$(".demo_box").live("click",function()
	{
		var id = $(this).attr("sign");
		var build = $(this).attr("signs");
		window.location.href = "/cxg/index.php?m=Home&c=Hostel&a=index&id=2.50&shostel="+id+"&sbuild="+build;
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