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
	/*table{
		border-collapse:collapse;
		margin-left:30px;
		margin-top:10px;
	}*/
	/*td{
		min-width:140px;
		height:45px;
		font-size:18px;
		border:1px solid black;
		line-height:45px;
	}*/
	/*.del-btn{
		width:30px;
		height:100%;
		float:right;
		cursor:pointer;
		border-left:1px solid #aaa;
		background:#00ff66;
	}*/
	/*#cond{
		padding-left:50px;
		background:#ccc;
		width:100%;
		text-align:left;
		height:35px;
		line-height:35px;
	}*/
</style>
<br>
<h1 class="tt_h1">查看宿舍</h1>
<div id="cond">
	<form id="form" method='post'>
		楼号：<select name="build" id=""  style='width:50px;padding-left:5px;'>
			<?php if(is_array($hostel)): foreach($hostel as $k=>$hostel): ?><option value="<?php echo ($k); ?>" <?php if($k == $bb): ?>selected<?php endif; ?> ><?php echo ($k); ?></option><?php endforeach; endif; ?>
		</select>
		<input type="hidden" name="hostel_id" id="hid">
		<input type="submit" value="搜索" style="padding:1px;margin-left:10px;padding-top:0;padding-bottom:0;">
	</form>
</div>
<br>
<table id="table">
	<?php echo ($state); ?>
	<?php if($hlist["l1"] != ''): ?><tr id="l1">
			<td class="tb_tr_tt">一楼</td>
			<?php if(is_array($hlist["l1"])): foreach($hlist["l1"] as $key=>$list): ?><td title="<?php echo ($list["id"]); ?>" class='croom'>
					<?php echo ($list["name"]); ?>
					<span class='del-btn'>
						<?php if($list["count"] != ''): echo ($list["count"]); else: ?>0<?php endif; ?>
					</span>
				</td><?php endforeach; endif; ?>
		</tr><?php endif; ?>
	<?php if($hlist["l2"] != ''): ?><tr id="l2">
			<td class="tb_tr_tt">二楼</td>
			<?php if(is_array($hlist["l2"])): foreach($hlist["l2"] as $key=>$list): ?><td title="<?php echo ($list["id"]); ?>" class='croom'>
					<?php echo ($list["name"]); ?>
					<span class='del-btn'>
						<?php if($list["count"] != ''): echo ($list["count"]); else: ?>0<?php endif; ?>
					</span>
				</td><?php endforeach; endif; ?>
		</tr><?php endif; ?>
	<?php if($hlist["l3"] != ''): ?><tr id="l3">
			<td class="tb_tr_tt">三楼</td>
			<?php if(is_array($hlist["l3"])): foreach($hlist["l3"] as $key=>$list): ?><td title="<?php echo ($list["id"]); ?>" class='croom'>
					<?php echo ($list["name"]); ?>
					<span class='del-btn'>
						<?php if($list["count"] != ''): echo ($list["count"]); else: ?>0<?php endif; ?>
					</span>
				</td><?php endforeach; endif; ?>
		</tr><?php endif; ?>
	<?php if($hlist["l4"] != ''): ?><tr id="l4">
			<td class="tb_tr_tt">四楼</td>
			<?php if(is_array($hlist["l4"])): foreach($hlist["l4"] as $key=>$list): ?><td title="<?php echo ($list["id"]); ?>" class='croom'>
					<?php echo ($list["name"]); ?>
					<span class='del-btn'>
						<?php if($list["count"] != ''): echo ($list["count"]); else: ?>0<?php endif; ?>
					</span>
				</td><?php endforeach; endif; ?>
		</tr><?php endif; ?>
	<?php if($hlist["l5"] != ''): ?><tr id="l5">
			<td class="tb_tr_tt">五楼</td>
			<?php if(is_array($hlist["l5"])): foreach($hlist["l5"] as $key=>$list): ?><td title="<?php echo ($list["id"]); ?>" class='croom'>
					<?php echo ($list["name"]); ?>
					<span class='del-btn'>
						<?php if($list["count"] != ''): echo ($list["count"]); else: ?>0<?php endif; ?>
					</span>
				</td><?php endforeach; endif; ?>
		</tr><?php endif; ?>
	<?php if($hlist["l6"] != ''): ?><tr id="l6">
			<td class="tb_tr_tt">六楼</td>
			<?php if(is_array($hlist["l6"])): foreach($hlist["l6"] as $key=>$list): ?><td title="<?php echo ($list["id"]); ?>" class='croom'>
					<?php echo ($list["name"]); ?>
					<span class='del-btn'>
						<?php if($list["count"] != ''): echo ($list["count"]); else: ?>0<?php endif; ?>
					</span>
				</td><?php endforeach; endif; ?>
		</tr><?php endif; ?>
	<?php if($hlist["l7"] != ''): ?><tr id="l7">
			<td class="tb_tr_tt">七楼</td>
			<?php if(is_array($hlist["l7"])): foreach($hlist["l7"] as $key=>$list): ?><td title="<?php echo ($list["id"]); ?>" class='croom'>
					<?php echo ($list["name"]); ?>
					<span class='del-btn'>
						<?php if($list["count"] != ''): echo ($list["count"]); else: ?>0<?php endif; ?>
					</span>
				</td><?php endforeach; endif; ?>
		</tr><?php endif; ?>
	<?php if($hlist["l8"] != ''): ?><tr id="l8">
			<td class="tb_tr_tt">八楼</td>
			<?php if(is_array($hlist["l8"])): foreach($hlist["l8"] as $key=>$list): ?><td title="<?php echo ($list["id"]); ?>" class='croom'>
					<?php echo ($list["name"]); ?>
					<span class='del-btn'>
						<?php if($list["count"] != ''): echo ($list["count"]); else: ?>0<?php endif; ?>
					</span>
				</td><?php endforeach; endif; ?>
		</tr><?php endif; ?>
	<?php if($hlist["other"] != ''): ?><tr id="l1">
			<td class="tb_tr_tt">其它</td>
			<?php if(is_array($hlist["other"])): foreach($hlist["other"] as $key=>$list): ?><td title="<?php echo ($list["id"]); ?>" class='croom'>
					<?php echo ($list["name"]); ?>
					<span class='del-btn'>
						<?php if($list["count"] != ''): echo ($list["count"]); else: ?>0<?php endif; ?>
					</span>
				</td><?php endforeach; endif; ?>
		</tr><?php endif; ?>
</table>

<script type="text/javascript">
	$(".del-btn").click(function()
	{
		var hid = $(this).parent().attr("title");
		$("#form").attr("action","index.php?m=Home&c=Hostel&a=index&id=2.50");
		$("#hid").val(hid);
		$("#form").submit();
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