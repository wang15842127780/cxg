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
	#shell{
	    position: absolute;
	    top: 0;
	    left: 0;
	    right: 0;
	    bottom: 0;
	    z-index: 555px;
	    background: #ccc;
	    opacity: 0.7;
	}
	#shell_img{
		position: absolute;
	    left: 0;
	    right: 0;
	    text-align: center;
	    top: 400px;
	}
	#shell_photo{
	    position: absolute;
	    top: 0;
	    left: 0;
	    right: 0;
	    bottom: 0;
	    z-index: 555px;
	    background: #ccc;
	    opacity: 0.7;
	    display: none;
	}
	#shell_box{
		position: absolute;
	    left: 0;
	    right: 0;
	    text-align: center;
	    top: 150px;
	    display: none;
	}
	#con_div{
		position: absolute;
	    left: 100px;
	    top: 120px;
	    right: 30px;
	    bottom: 20px;
	    background: #eee;
	    border: 1px solid gray;
	    border-radius: 5px;
	    overflow-y: auto;
	    overflow-x: hidden
	}
	.edit-btn{
		display:none;
	}
	.add_left{
		display: inline-block;
		width: 15%;
		text-align: right;
	}
	.add_right{
		display: inline-block;
		margin-top: 13px;
	}
	.add_right input{
		width:120px;
	}
	#teacher{
		width:120px;
		padding-left:10px;
	}
	.file{
		position: absolute;
	    display: inline-block;
	    border: 1px solid #99D3F5;
	    border-radius: 4px;
	    padding: 4px 12px;
	    overflow: hidden;
	    color: #1E88C7;
	    text-decoration: none;
	    text-indent: 0;
	    line-height: 20px;
	}
</style>
<br>
<h1 class="tt_h1">位置：人脸信息>人脸库管理</h1>
<p style="display:inline-block;width:45%;padding-left:30px;">
	姓名：<input type="text" id="sname">&nbsp;&nbsp;
	<button class="search"><i class="search-btn-img"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;查找</button>
</p>
<p style="text-align:right;display:inline-block;width:50%;"><button class="add-btn"><i class="add-btn-img"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;新增人脸信息</button></p>
<div id="con_div">
	<table id="table" style="margin-top:25px;">
		<tr class="tb_tr_th">
			<th>ID</th>
			<th>姓名</th>
			<th>备注</th>
			<th>教师</th>
			<th>图片</th>
			<th>操作</th>
		</tr>
	</table>
</div>

<div id="add_form" style="position: absolute; left: 0px; top: 0px; right: 0px; z-index: 9999; text-align: center;display:none;">
	<form id="form" onsubmit="return false;" style="display:inline-block;width:500px;background:#fff;margin-top:50px;">
	<br>
		<p>添 加 人 脸 信 息</p>
		<br>
		<p class="add_left">是否教师：</p><p class="add_right">
			<select name="teacher" id="teacher">
				
			</select>
		</p><br>
		<p class="add_left">姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名：</p><p class="add_right"><input type="text" name="name" id="name"></p><br>
		<p class="add_left">备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注：</p><p class="add_right"><input type="text" name="note" id="note"></p ><br><br>
		
		<img src="" width="200" height="280" id="image" bbc_type="store_banner" alt="暂无图片">
		<br>
		<a href="javascript:void(0);" class='file'>上传图片
			<input type="file" id="file" name='file' style="position:absolute;font-size:100px;right:0;top:-10px;opacity:0;width:74px;" bbc_type="change_store_banner">
		</a>
		<br><br>
		<button class="confirm-btn">确定</button>&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="cancel-btn">取消</button><br><br>
	</form>
</div>
	
<div id="shell_photo" class="show_photo">

</div>
<div id="shell_box" class="show_photo">
    <img src="" width="300" height="420" id="teacher_photo">
</div>
<div id="shell" class="zshow">

</div>
<div id="shell_img" class="zshow">
    <img src="/cxg/Public/iconfont/loading.gif" width="35" height="35">
    <p>加载中...</p>
</div>

<script type="text/javascript">
	window.getList = function(data = {})
	{
		var url = '?m=Admin&c=Face&a=getFace';
		data.typ = 'json';
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			$("#table").show();
			$(".tb_tr_td").remove();
			var field = Array();
			field[0] = 'id';
			field[1] = 'name';
			field[2] = 'note';
			field[3] = 'teacher';
			field[4] = 'image';
			listPage(res.content,1,15,field,true);
		}
		else
		{
			tips(res.content,2);
			$("#table").hide();
		}
		$(".zshow").hide();
	}
	window.getTeacherList = function()
	{
		var url = '?m=Admin&c=Face&a=getTeacherList';
		var data = {typ:'json'};
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			$("#add_form").show();
			$("#shell").show();
			var list = res.content;
			var str = "<option>否</option>";
			for(var i in list)
			{
				str += "<option disabled='disabled'>"+list[i].class_name+"</option>";
				var list1 = list[i]['list'];
				for(var j in list1)
				{
					str += "<option value='"+list1[j].id+"'>&nbsp;&nbsp;&nbsp;"+list1[j].name+"</option>";
				}
			}
			$("#teacher").html(str);
		}
		else
		{
			tips(res.content,2);
		}
	}
	$('input[bbc_type="change_store_banner"]').change(function(){
		var src = getFullPath($(this)[0]);
		$('img[bbc_type="store_banner"]').attr('src', src);
		change1 = 1;
	});
	function getFullPath(obj)
	{
	    if(obj)
	    {
	        //ie
	        if (window.navigator.userAgent.indexOf("MSIE")>=1)
	        {
	            obj.select();
	            if(window.navigator.userAgent.indexOf("MSIE") == 25){
	                obj.blur();
	            }
	            return document.selection.createRange().text;
	        }
	        //firefox
	        else if(window.navigator.userAgent.indexOf("Firefox")>=1)
	        {
	            if(obj.files)
	            {
	                //return obj.files.item(0).getAsDataURL();
	                return window.URL.createObjectURL(obj.files.item(0));
	            }
	            return obj.value;
	        }else if(window.navigator.userAgent.indexOf("Chrome")>=1){
	            if(obj.files)
	            {
	                return window.URL.createObjectURL(obj.files[0]);
	            }

	        }
	        return obj.value;
	    }
	}
	function doUpload(formid) {  
	     var formData = new FormData($( "#"+formid )[0]);
	     $.ajax({  
	          url: "/cxg/Public/function/upload.php",  
	          type: 'POST',  
	          data: formData,
	          async: false,  
	          cache: false,  
	          contentType: false,  
	          processData: false,  
	          dataType:'json',
	          success: function (returndata) {  
	              // alert(returndata);  
	              re = returndata;
	          },  
	          error: function (returndata) {  
	              // alert(returndata); 
	              re = returndata;
	          }  
	     });
	     return re;
	}
	$(".add-btn").click(function()
	{
		// $("#add_form").show();
		getTeacherList();
	})
	$(".confirm-btn").click(function()
	{
		var name = $("#name").val();
		var teacher = $("#teacher").val();
		var note = $("#note").val();
		var photo = $("#image").attr("src");
		if($.trim(name) == "")
		{
			tips("姓名不能为空！",2);
			return;
		}
		if($.trim(photo) == "")
		{
			tips("人员照片不能为空！",2);
			return;
		}
		var res = doUpload('form');
		if(res.status == 'success')
		{
			var photo1 = res.file_name;
			var url = '?m=Admin&c=Face&a=addFace';
			var data = {name:name,note:note,teacher:teacher,photo:photo1,typ:'json'};
			// console.info(data);
			var ret = ajax(url,data);
			if(ret.status == 'success')
			{
				tips(ret.content,1);
				setTimeout("window.location.reload();",500);
			}
			else
			{
				tips(ret.content,2);
			}
		}
		else
		{
			tips(res.content,2);
		}
			
	});
	$(".cancel-btn").click(function()
	{
		$(".zshow").hide();
		$("#add_form").hide();
	})
	$("#teacher").live("change",function()
	{
		var val = $("#teacher").val();
		if($.trim(val) == "否")
		{
			$("#name").val("");
		}
		else
		{
			var text = $("#teacher option:selected").text();
			$("#name").val($.trim(text));
		}
	})
	$(".search").click(function()
	{
		var sname = $("#sname").val();
		var data = {sname:sname};
		getList(data);
	})
	$(".photo").live("click",function()
	{
		var id = $(this).attr("sign");
		var url = '?m=Admin&c=Face&a=getFaceById';
		var data = {id:id,typ:'json'};
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			$(".show_photo").show();
			$("#teacher_photo").attr("src",res.content);
		}
		else
		{
			tips(res.content,2);
		}
	})
	$(".show_photo").live("click",function()
	{
		$(".show_photo").hide();
	})
	$(".del-btn").live("click",function()
	{
		var msg = "您真的确定要删除吗？\n\n请确认！";
		if(confirm(msg)==true)
		{
			var _this = $(this);
			var id = $(this).attr("sign");
			var url = "index.php?m=Admin&c=Face&a=delFace";
			var data = {id:id,typ:'json'};
			var res = ajax(url,data);
			if(res.status == 'success')
			{
				tips(res.content,1);
				_this.parents('tr').remove();
			}
			else
			{
				tips(res.content,2);
			}
		}
	})
	setTimeout("getList();",500);
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
	if(parseInt(nn) == 78)
	{
		nn = 58;
	}
	$(".fun").hide();
	$("#m"+nn).show();
	$("#m"+nn).siblings().show();

</script>