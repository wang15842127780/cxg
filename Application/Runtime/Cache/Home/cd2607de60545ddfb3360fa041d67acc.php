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
			
<link rel="stylesheet" href="/cxg/Public/css/jquery.datetimepicker.css">

<style type="text/css">
	.p{
		font-size:17px;
		margin-top:20px;
		color:#3dff00;
	}
	.close{
		float:right;
		width:19px;
	}
	.phides{
		display:none;
	}
	#type0,#type1{
		position:absolute;
		right: 30px;
		padding: 3px;
		border:1px solid #ccc;
		border-radius:3px;
		top: 150px;
		background: orange;
		color: #fff;
		cursor:pointer;
	}
	.type1 input{
		width:100px;
	}
	.type1{
		display: none;
	}
</style>
<span id="add_manage">
<br>
<h1 class="tt_h1">新增请假信息</h1>
<button id="type1" style="display:none;">特殊请假</button>
<button id="type0" style="display:none;">普通请假</button>
<span id="hhtype" style='display:none;'>0</span>
	<p class="p year">
		年组：<select name="year" id="year" style="width:100px;">
			<option value="0">选择年级</option>
			<?php if(is_array($yearList)): foreach($yearList as $key=>$lists): ?><option value="<?php echo ($lists["id"]); ?>"><?php echo ($lists["name"]); ?></option><?php endforeach; endif; ?>
		</select>
	</p>
	<p class="p class phides">
		班级：<select name="class" id="class" style="width:100px;">
		</select>
	</p>
	<p class="p student phides">
		姓名：<select name="student" id="student" style="width:100px;">
		</select>
	</p>
<p class="p phides type0">开始时间：<input class="sang_Calender" type="text" name="stime" value="" placeholder="请选择" readonly="" style="width:130px;"></p>
<p class="p phides type0">结束时间：<input class="sang_Calender" type="text" name="etime" value="" placeholder="请选择" readonly="" style="width:130px;"></p>
<p class="p type1">选择日期：<input type="text" id="datetimepicker21" placeHolder="开始日期"> 至 <input type="text" id="datetimepicker22" placeHolder="结束日期"></p>
<p class="p type1">选择时间：<input type="text" id="datetimepicker11" placeHolder="开始时间"> 至 <input type="text" id="datetimepicker12" placeHolder="结束时间"></p>
<p class="p phides type0">原因：<select name="reasons" id="reasons">
	<option value="事假">事假</option>
	<option value="病假">病假</option>
	<option value="其它">其它</option>
</select>
</p>
<p class="p phides" style="vertical-align:top;"><textarea name="" id="reason" cols="30" rows="10" placeHolder="班主任意见"></textarea> </p>

<br>
<p class="phides">
	<button class="confirm-btn" style="width:81px;padding:0 5px;">创建并提交</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<button class="cancel-btn">取消</button>
</p>
<input type="hidden" id="socket">
<div id="shell" class="zshow" style="display: none;left:0;right:0;top:0;bottom:0;background:#ccc;opacity:0.7;position:absolute;">

</div>
<div id="shell_img" class="zshow" style="display: none;position:absolute;width:90%;top:500px;">
        <img src="/cxg/Public/iconfont/loading.gif" width="35" height="35">
        <p>审核中...</p>
</div>
<script type="text/javascript" src="/cxg/Public/js/datetime.js"></script>
<script type="text/javascript" src="/cxg/Public/js/livequery.js"></script>
<script type="text/javascript">
	window.jumpPage = function()
	{
		setTimeout("window.location.href='index.php?m=Home&c=Leave&a=index&id=64.67'",1000);
	}
	window.getStudentByClass = function(data={})
	{
		var url = "index.php?m=Home&c=Leave&a=getStudentByClass";
		data.typ = 'json';
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			$(".phides").show();
			$("#type1").show();
			$("#type0").hide();
			$(".type1").hide();
			$("#hhtype").html(0);
			var slist = res.content;
			var sstr = "";
			for(var i in slist)
			{
				sstr += "<option value='"+slist[i].id+"'>"+slist[i].name+"</option>";
			}
			$("#student").html(sstr);
		}
		else
		{
			$(".phides").hide();
			$("#type0").hide();
			$("#type1").hide();
			$(".type1").hide();
			$("#hhtype").html(0);
			tips(res.content,2);
		}
	}

	window.getClassByYear = function(data)
	{
		var url = "index.php?m=Home&c=Leave&a=getClassByYear";
		data.typ = 'json';
		var res1 = ajax(url,data);
		if(res1.status == 'success')
		{
			$(".class").show();
			var clist = res1.content;
			var cstr = "<option value='0'>选择班级</option>";
			for(var j in clist)
			{
				cstr += "<option value='"+clist[j].id+"'>"+clist[j].name+"</option>";
			}
			$("#class").html(cstr);
		}
		else
		{
			tips(res1.content,2);
			$(".phides").hide();
			$("#type0").hide();
			$("#type1").hide();
			$(".type1").hide();
			$("#hhtype").html(0);
		}
	}
	var socket = new WebSocket('ws://192.168.1.234:8080');
	// 监听Socket的关闭
	socket.onclose = function(event) {
		console.log('Client notified socket has closed',event);
		$("#socket").val(0);
	}; 
	socket.onerror = function(event) {
		console.log('Client notified socket has error',event);
		$("#socket").val(0);
	}; 
	socket.onmessage = function(event) {
		console.info("收到新消息！");
	};
	// 打开Socket 
	socket.onopen = function(event) {
		console.log("Connected", event);
		$("#socket").val(1);
	};
	$(".confirm-btn").click(function()
	{
		// var sockets = $("#socket").val();
		// if(sockets != 1)
		// {
		// 	tips("网络服务未启动，请刷新页面重新加载！",2);
		// 	return;
		// }
		$(".zshow").show();
		var student = $("#student").val();
		var type = $("#hhtype").html();
		if($.trim(student) == '')
		{
			tips('请假人员不能为空！');
			return;
		}
		console.info(type);
		if(type==1)
		{
			var begins_date = $("#datetimepicker21").val();
			var ends_date = $("#datetimepicker22").val();
			var begins_time = $("#datetimepicker11").val();
			var ends_time = $("#datetimepicker12").val();
			if($.trim(begins_date)=="")
			{
				tips("开始日期不能为空！",2);
				return;
			}
			if($.trim(ends_date)=="")
			{
				tips("结束日期不能为空！",2);
				return;
			}
			if($.trim("begins_time")=="")
			{
				tips("开始时间不能为空！",2);
				return;
			}
			if($.trim(ends_time)=="")
			{
				tips("结束时间不能为空！",2);
				return;
			}
			var reason = $("#reason").val();
			if($.trim(reason)=="")
			{
				tips("班主任意见不能为空！",2);
				return;
			}
			var url = "index.php?m=Home&c=Leave&a=addStu";
			var data = {student:student,begins_date:begins_date,ends_date:ends_date,begins_time:begins_time,ends_time:ends_time,reason:reason,status:5,type:type,typ:'json'};
			var res = ajax(url,data);
			if(res.status == 'success')
			{
				tips(res.content,1);
				jumpPage();	
			}
			else
			{
				tips(res.content,2);
			}
		}
		else
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
			var reasons = $("#reasons").val();
			var url = "index.php?m=Home&c=Leave&a=addStu";
			var data = {student:student,stime:stime,etime:etime,reason:reason,reasons:reasons,status:5,typ:'json',type:0};
			var res = ajax(url,data);
			if(res.status == 'success')
			{
				tips(res.content,1);
				jumpPage();
			}
			else
			{
				tips(res.content,2);
				$(".zshow").hide();
			}
		}
	})

	$(".confirm-btn1").click(function()
	{
		var student = $("#student").val();
		if($.trim(student) == '')
		{
			tips('请假人员不能为空！');
			return;
		}
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
		var reasons = $("#reasons").val();
		var url = "index.php?m=Home&c=Leave&a=addStu";
		var data = {student:student,stime:stime,etime:etime,reason:reason,reasons:reasons,status:3,typ:'json'};
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			tips(res.content,1);
			setTimeout("window.location.href='index.php?m=Home&c=Leave&a=index&id=64.67'",500);
		}
		else
		{
			tips(res.content,2);
		}
	})

	$(".cancel-btn").click(function()
	{
		window.location.href = 'index.php?m=Home&c=Leave&a=index&id=64.67';
	})

	$(".close").click(function()
	{
		$(this).parent().parent().remove();
	})

	$("#class").live("change",function()
	{
		var id = $(this).val();
		if(id == 0)
		{
			$(".phides").hide();
			$("#type0").hide();
			$("#type1").hide();
			$(".type1").hide();
			$("#hhtype").html(0);
		}
		else
		{
			var data = {class:id};
			getStudentByClass(data);
		}
	})

	$("#year").live("change",function()
	{
		var id = $(this).val();
		if(id == 0)
		{
			$(".phides").hide();
		}
		else
		{
			$(".phides").hide();
			$("#type0").hide();
			$("#type1").hide();
			$(".type1").hide();
			$("#hhtype").html(0);
			var data = {year:id};
			getClassByYear(data);
		}
	})

</script>
<script type="text/javascript" src="/cxg/Public/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/cxg/Public/js/jquery.datetimepicker.full.js"></script>
<script type="text/javascript">
	$("#type1").click(function(){
		$("#type1").hide();
		$("#type0").show();
		$("#hhtype").html(1);
		$(".type1").show();
		$(".type0").hide();
	})
	$("#type0").click(function()
	{
		$("#type0").hide();
		$("#type1").show();
		$("#hhtype").html(0);
		$(".type0").show();
		$(".type1").hide();
	})

	//日期和时间插件
	$("#datetimepicker12").datetimepicker({
		datepicker:false,
		format:'H:i',
		step:10
	})
	$("#datetimepicker11").datetimepicker({
		datepicker:false,
		format:'H:i',
		step:10
	})
	$("#datetimepicker21").datetimepicker({
		timepicker:false,
		format:'Y-m-d',
		formatDate:'Y-m-d'
	})
	$("#datetimepicker22").datetimepicker({
		timepicker:false,
		format:'Y-m-d',
		formatDate:'Y-m-d'
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