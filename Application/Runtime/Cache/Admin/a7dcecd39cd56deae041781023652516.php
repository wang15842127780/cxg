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
	table{
		border-collapse:collapse;
		margin-left:30px;
		margin-top:10px;
	}
	#table{
		margin-left:40px;
	}
	.new_table{
		margin-top:20px;
	}
	.new_table th{
		width:130px;
		height:30px;
		font-size:10pt;
	}
	.tb_tr_td td{
		width:130px;
		height:30px;
		font-size:10pt;
	}
	input{
		margin-top:10px;
		width:100px;
	}
	.file{
		position:absolute;
		display:inline-block;
		border:1px solid #99D3F5;
		border-radius:4px;
		padding:4px 12px;
		overflow:hidden;
		color:#1E88C7;
		text-decoration:none;
		text-indent:0;
		line-height:20px;
	}
	#form1{
		width:650px;
		background:#fff;
		height:200px;
		margin-top:190px;
		padding-top:50px;
		font-size:17px;
		display:inline-block;
	}
	.contain select{
		width:70px;
	}
	.confirm-btn1,.confirm-btn2{
		width:50px;
		height:25px;
		background:#449d44;
		border-color:#398439;
		color:#fff;
	}
	.cancel-btn1,.cancel-btn2{
		width:50px;
		height:25px;
		border-color:#eea236;
		background:#f0ad4e;
		color:#fff;
	}
	.add_left{
		display: inline-block;
		width: 15%;
		text-align: right;
	}
	.add_right{
		display: inline-block;
	}
	.export-btn1{
		background: #0eace0;
	    width: auto;
	    padding: 2px;
	    height: 30px;
	    border-radius: 5px;
	}
</style>
<br>
<h1 class="tt_h1">位置：学生管理>查看学生信息<p style="text-align:right;display:inline-block;width:50%;float:right;"><button class="import-btn" onclick="window.open('/cxg/Public/function/import.php')"><i class="import-btn-img"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;导入学生信息</button><button class="export-btn" onclick="window.open('/cxg/Public/function/export.php');"><i class="export-btn-img"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;导出学生信息</button></p></h1>
<p style="display:inline-block;width:45%;padding-left:30px;">
	姓名：<input type="text" id="sname">&nbsp;&nbsp;
	班级：<select name="sclass" id="sclass">
		<?php if(is_array($classList)): foreach($classList as $key=>$lists): ?><option value="<?php echo ($lists["id"]); ?>"><?php echo ($lists["name"]); ?></option><?php endforeach; endif; ?>
	</select>&nbsp;&nbsp;
	<button class="search"><i class="search-btn-img"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;查找</button>
</p>
<p style="text-align:right;display:inline-block;width:50%;"><button class="add-btn"><i class="add-btn-img"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;添加学生信息</button><button class="export-btn1"><i class="export-btn-img"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;导出学生照片</button></p>
<br>
<div id="con_div" style="left:30px;">
	<table id="table" class="new_table" style="overflow-x:auto;">
		<tr style="display:none;">
			<th>ID</th>
			<th>姓名</th>
			<th>身份证号</th>
			<th>性别</th>
			<th>班级</th>
			<th style="min-width:134px;">宿舍</th>
			<th>联系人</th>
			<th>联系人电话</th>
			<th>备注</th>
			<th style="min-width:130px;">操作</th>
		</tr>
	</table>
</div>
<div id="shell" class="zshow">

</div>
<div  id="shell_img" class="zshow">
        <img src="/cxg/Public/iconfont/loading.gif" width="35" height="35" />
        <p>加载中...</p>
</div>
<div id="add_form" style="position: absolute; left: 0px; top: 0px; right: 0px; z-index: 9999; text-align: center;display:none;">
	<form id="form" onsubmit="return false;" style="display:inline-block;width:600px;background:#fff;margin-top:50px;">
	<br>
		<p>添 加 学 生 信 息</p>
		<br>
		<input type="hidden" id="hid">
		<p class="add_left">姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名：</p><p class="add_right"><input type="text" name="name" id="name"></p><br>
		<!-- <p class="add_left">学&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号：</p><p class="add_right"><input type="text" name="number" id="number"></p><br> -->
		<p class="add_left">身&nbsp;&nbsp;份&nbsp;&nbsp;证：</p><p class="add_right"><input type="text" name="iden" id="iden"></p><br>
		<p class="add_left">性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别：</p><p class="add_right"><input type="radio" name="sex" value="0" class="sex" id="nv" style="width:15px;">&nbsp;女  &nbsp;&nbsp;&nbsp;<input type="radio" name="sex" value="1" class="sex" style="width:15px;" id="nan" checked="checked">&nbsp;男&nbsp;&nbsp;&nbsp;</p><br>
		<p class="add_left">班&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;级：</p><p class="add_right"><select name="class" id="class" style="width:104px;margin-top:6px;"></select></p><br>
		<p class="add_left">联&nbsp;系&nbsp;人：</p><p class="add_right"><input type="text" name="contact" id="contact"></p><br>
		<p class="add_left">电&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;话：</p><p class="add_right"><input type="text" name='phone' id='phone'></p><br>
		<p class="add_left">备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注：</p><p class="add_right"><input type="text" name="note" id="note"></p ><br><br>
		<img src="" width="200" height="280" bbc_type="store_banner" alt="暂无图片">
		<br>
		<a href="javascript:void(0);" class='file'>上传图片
			<input type="file" id="file" name='file' style="position:absolute;font-size:100px;right:0;top:-10px;opacity:0;width:74px;" bbc_type="change_store_banner">
		</a>
		<br><br>
		<button class="confirm-btn">确定</button>&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="cancel-btn">取消</button><br><br>
	</form>
</div>

<div id="ruzhu_form" style="position:absolute;left:0;top:0;right:0;z-index:9999;text-align:center;display:none;">
	<form id="form1" onsubmit="return false;"><br>
		<p>办 理 学 生 入 住</p>
		<br>
		<br>
		<input type="hidden" id="rid">
		<span class="contain">
			楼号：<select name="build" id="build"></select>&nbsp;&nbsp;&nbsp;&nbsp;
		</span>
		<span class="contain">
			楼层：<select name="floor" id="floor"></select>&nbsp;&nbsp;&nbsp;&nbsp;
		</span>
		<span class="contain">
			宿舍号：<select name="hostel" id="hostel"></select>
		</span>
		<span class="contain" id='number_span' style='display:none;'>
			床号：<select name="numbers" id="numbers" style="width:120px;"></select>
		</span>
		<br><br><br>
		<button class="confirm-btn1">确定</button>
		<button class="cancel-btn1">取消</button>
	</form>
</div>

<div id="tips_box" class="tipss" style="position:absolute;left:0;top:0;right:0;z-index:9999;text-align:center;display:none;">
	<div id='tips' class="tipss" style="width:400px;height:300px;margin-top:150px;background:#fff;display:inline-block;">
		<p style="height:50px;margin-top:60px;"><input style="width:20px;" type="radio" name='export_way' value="按班级导出">按班级导出</p>
		<p style="height:50px;margin-top:20px;"><input style="width:20px;" type="radio" name='export_way' value="按宿舍导出">按宿舍导出</p>
		<p style="margin-top:20px;">
			<button class="confirm-btn2">确定</button>&nbsp;&nbsp;&nbsp;&nbsp;<button class="cancel-btn2">取消</button>
		</p>
	</div>
</div>



<script type="text/javascript">
	window.getList = function(data={})
	{
		var url = "index.php?m=Admin&c=Setting&a=getStudentList";
		data.typ = 'json';
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			$("#table").find('tr').show();
			$(".zshow").hide();
			var field = Array();
			field[0] = 'id';
			field[1] = 'name';
			field[2] = 'iden'
			field[3] = 'sex_text';
			field[4] = 'class_text';
			field[5] = 'hostel';
			field[6] = 'contact';
			field[7] = 'contact_phone';
			field[8] = 'note';
			var lists = res.content;
			if(res.leader == 1)
			{
				listPage(lists,1,15,field,true);
			}
			else
			{
				field[8] = 'act_text';
				$(".add-btn").hide();
				listPage(lists,1,15,field);
			}
			
		}
		else
		{
			tips(res.content,2);
			$(".zshow").hide();
			$(".new_table").find('tr').hide();
		}
	}
	window.getBuildInfo = function()
	{
		var url = 'index.php?m=Admin&c=Setting&a=getBuildInfo';
		var data = {typ:'json'};
		var res3 = ajax(url,data);
		return res3;
	}
	window.getFloorByBuild = function(data={})
	{
		var url = "index.php?m=Admin&c=Setting&a=getFloorByBuild";
		data.typ = 'json';
		var res1 = ajax(url,data);
		return res1;
	}
	window.getNoByFloor = function(data={})
	{
		var url = "index.php?m=Admin&c=Setting&a=getNoByFloor";
		data.typ = 'json';
		var res2 = ajax(url,data);
		return res2;
	}
	window.getInfoByNo = function(data={})
	{
		var url = 'index.php?m=Admin&c=Setting&a=getInfoByNo';
		data.typ = 'json';
		var res4 = ajax(url,data);
		return res4;
	}

	$('input[bbc_type="change_store_banner"]').change(function(){
	    console.info(22);
        console.info($(this));
        console.info($(this)[0]);
		var src = getFullPath($(this)[0]);
        console.info(src);
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


	$(".search").click(function()
	{
		var sname = $("#sname").val();
		var sclass = $("#sclass").val();
		var cond = {sname:sname,sclass:sclass};
		getList(cond);
	})

	$(".add-btn").click(function()
	{
		$("#shell").show();
		$("#add_form").show();
		var stuClass = <?php echo ($classLists); ?>;
		var str = '';
		for(var i in stuClass)
		{
			str += '<option value="'+stuClass[i].id+'">'+stuClass[i].name+'</option>';
		}
		$("#class").html(str);
	})

	$(".confirm-btn").click(function()
	{
		var sex = $(".sex:checked").val();
		var id = $("#hid").val();
		var name = $('#name').val();
		if($.trim(name) == '')
		{
			tips('学生姓名不能为空！',2);
			return;
		}
		var stu_class = $("#class").val();
		if($.trim(stu_class) == '')
		{
			tips('请先设置班级！',2);
			return;
		}
		var contact = $("#contact").val();
		if($.trim(contact) == '')
		{
			tips('联系人不能为空！',2);
			return;
		}
		var phone = $("#phone").val();
		if($.trim(phone) == '')
		{
			tips('电话不能为空！',2);
			return;
		}
		var note = $("#note").val();
		if($.trim(note) == '')
		{
			tips('备注不能为空！',2);
			return;
		}
		// var number = $("#number").val();
		// if($.trim(number) == ""){
		// 	tips('学号不能为空！',2);
		// 	return;
		// }
		var iden = $("#iden").val();
		if($.trim(iden) == '')
		{
			tips("身份证号不能为空！",2);
			return;
		}

		//图片上传
		if(typeof(change1) != 'undefined')
		{
			var res = doUpload('form');
			if(res.status == 'success')
			{
				var photo = res.file_name;
				if($.trim(id) == '')
				{
					var url = 'index.php?m=Admin&c=Setting&a=addStudent';
					var data = {name:name,class:stu_class,sex:sex,contact:contact,iden:iden,phone:phone,note:note,photo:photo,typ:'json'};
				}
				else
				{
					var url = 'index.php?m=Admin&c=Setting&a=editStudent';
					var data = {id:id,name:name,class:stu_class,sex:sex,contact:contact,iden:iden,phone:phone,photo,note:note,typ:'json'};
				}
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
			}
			else
			{
				alert(res.content,2);
			}
		}
		else
		{
			if($.trim(id) == '')
			{
				var url = 'index.php?m=Admin&c=Setting&a=addStudent';
				var data = {name:name,class:stu_class,sex:sex,contact:contact,iden:iden,phone:phone,note:note,typ:'json'};
			}
			else
			{
				var url = 'index.php?m=Admin&c=Setting&a=editStudent';
				var data = {id:id,name:name,class:stu_class,sex:sex,iden:iden,contact:contact,phone:phone,note:note,typ:'json'};
			}
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
		}
	})

	$(".cancel-btn").click(function()
	{
		$("#shell").hide();
		$("#add_form").hide();
		$("#hid").val('');
		$("#name").val("");
		$("#number").val("");
		$("#iden").val("");
		$("#contact").val("");
		$("#phone").val("");
		$("#note").val("");
		$('img[bbc_type="store_banner"]').attr('src', "");
	})

	$(".edit-btn").live("click",function()
	{
		var id = $(this).attr('sign');
		var url = "index.php?m=Admin&c=Setting&a=getStudentById";
		var data = {id:id,typ:'json'};
		var res = ajax(url,data);
		if(res.status == 'success')
		{
			$("#hid").val(id);
			$("#shell").show();
			$("#add_form").show();
			var info = res.content;
			$("#name").val(info.name);
			$("#contact").val(info.contact);
			$("#phone").val(info.contact_phone);
			$("#note").val(info.note);
			$("#number").val(info.number);
			$("#iden").val(info.iden);
			$("img[bbc_type='store_banner']").attr('src',info.photo);
			if(info.sex == 1)
			{
				$("#nv").attr("checked",false);
				$("#nan").attr("checked",true);
			}
			else
			{
				$("#nv").attr("checked",true);
				$("#nan").attr("checked",false);
			}
			var classList = <?php echo ($classLists); ?>;
			var str = "";
			for(var i in classList)
			{
				if(classList[i].id == res.content.class_id)
				{
					str += "<option value='"+classList[i].id+"' selected>"+classList[i].name+"</option>";
				}
				else
				{
					str += "<option value='"+classList[i].id+"'>"+classList[i].name+"</option>";
				}
					
			}
			$("#class").html(str);
		}
		else
		{
			tips(res.content,2);
		}

	})

	$(".del-btn").live("click",function()
	{
		var msg = "您真的确定要删除吗？\n\n请确认！";
		if(confirm(msg)==true)
		{
			var _this = $(this);
			var id = $(this).attr("sign");
			var url = "index.php?m=Admin&c=Setting&a=delStudent";
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

	//入住信息
	$(".ruzhu").live("click",function()
	{
		var _this = $(this);
		var res3 = getBuildInfo();
		if(res3.status == 'success')
		{
			var res1 = getFloorByBuild();
			if(res1.status == 'success')
			{
				var res2 = getNoByFloor();
				if(res2.status == 'success')
				{
					$("#shell").show();
					$("#ruzhu_form").show();
					var id = _this.attr('sign');
					$("#rid").val(id);
					var l1 = res3.content;
					var l2 = res1.content;
					var l3 = res2.content;
					var str1 = "";
					var str2 = "";
					var str3 = "";
					for(var i in l1)
					{
						str1 += "<option value='"+l1[i]+"'>"+l1[i]+"</option>";
					}
					$("#build").html(str1);
					for(var j in l2)
					{
						str2 += "<option value='"+l2[j]+"'>"+l2[j]+"</option>";
					}
					$("#floor").html(str2);
					for(var k in l3)
					{
						str3 += "<option value='"+l3[k].id+"'>"+l3[k].no+"</option>";
					}
					$("#hostel").html(str3);

					var vv = $("#hostel").val();
					var res4 = getInfoByNo({hid:vv});
					if(res4.status == 'success')
					{
						var str4 = "";
						$("#number_span").show();
						if(res4.content == '此房间不能入住！')
						{
							str4 += '<option value="">'+res4.content+'</option>';
						}
						else
						{
							var l4 = res4.content;
							for(var l in l4)
							{
								str4 += "<option value='"+l+"'>"+l3[l]+"</option>";
							}
						}
						console.info(str4);
						$("#numbers").html(str4);
					}
					else
					{
						tips(res.content,2);
					}
				}
				else
				{
					tips(res2.content,2);
				}
			}
			else
			{
				tips(res1.content,2);
			}
		}
		else
		{
			tips(res3.content,2);
		}
	})

	$("#build").live("change",function()
	{
		$("#floor").html("");
		$("#hostel").html("");
		$("#number_span").hide();
		var build = $("#build").val();
		var cond = {build:build,typ:'json'};
		var url = "index.php?m=Admin&c=Setting&a=getFloorByBuild1";
		var res1 = ajax(url,cond);
		if(res1.status == 'success')
		{
			var l2 = res1.content;
			var str2 = '';
			for(var j in l2)
			{
				str2 += "<option value='"+l2[j]+"'>"+l2[j]+"</option>";
			}
			$("#floor").html(str2);
		}
		else
		{
			tips(res1.content,2);
		}
	})
	$("#floor").live("change",function()
	{
		$("#hostel").html("");
		$("#number_span").hide();
		var build = $("#build").val();
		var floor = $("#floor").val();
		var cond = {build:build,floor:floor};
		var res2 = getNoByFloor(cond);
		if(res2.status == 'success')
		{
			var str3 = "";
			var l3 = res2.content;
			for(var k in l3)
			{
				str3 += "<option value='"+l3[k].id+"'>"+l3[k].no+"</option>";
			}
			$("#hostel").html(str3);
			$("#hostel").change();
		}
		else
		{
			tips(res2.content,2);
		}
	})
	$("#hostel").live("change",function()
	{
		$("#number_span").show();
		$("#numbers").html("");
		var hid = $(this).val();
		var res4 = getInfoByNo({hid:hid});
		if(res4.status == 'success')
		{
			var str4 = "";
			if(res4.content == '此房间不能入住！')
			{
				str4 += "<option value=''>"+res4.content+"</option>";
			}
			else
			{
				var l4 = res4.content;
				for(var i in l4)
				{
					if(l4[i].indexOf("已住")>0)
					{
						str4 += "<option value="+i+" disabled>"+l4[i]+"</option>";
					}
					else
					{
						str4 += "<option value="+i+">"+l4[i]+"</option>";
					}
					
				}
			}
			$("#numbers").html(str4);
		}
		else
		{
			tips(res4.content,2);
		}
	})

	$(".confirm-btn1").live("click",function()
	{
		var id = $("#rid").val();
		var bid = $("#hostel").val();
		var bno = $("#numbers").val();
		if($.trim(bno) == "")
		{
			tips("此房间不能入住！",2);
			return;
		}
		var url = "index.php?m=Admin&c=Setting&a=stuRuzhu";
		var data = {id:id,bid:bid,bno:bno,typ:'json'};
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
	$(".export-btn1").live("click",function()
	{
		$("#shell").show();
		$(".tipss").show();
	})
	$(".confirm-btn2").live("click",function()
	{
		var export_way = $("input[name='export_way']:checked").val();
		if(export_way == '按班级导出')
		{
			$("#shell").hide();
			$(".tipss").hide();
			window.open("/cxg/Public/function/exportStudentPhoto.php?w=1");
		}
		else if(export_way == '按宿舍导出')
		{
			$("#shell").hide();
			$(".tipss").hide();
			window.open("/cxg/Public/function/exportStudentPhoto.php?w=2");
		}
		else
		{
			tips("请选择导出方式",2);
		}
	})
	$(".cancel-btn2").live("click",function()
	{
		$("#shell").hide();
		$(".tipss").hide();
	})

	$(".cancel-btn1").live("click",function()
	{
		$("#shell").hide();
		$("#ruzhu_form").hide();
		$("#rid").val("");
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
	$(".fun").hide();
	$("#m"+nn).show();
	$("#m"+nn).siblings().show();

</script>