<?php
Header("Content-Type:text/html;charset=utf-8");
ini_set('memory_limit','3072M');    // 临时设置最大内存占用为3G
set_time_limit(0);   // 设置脚本最大执行时间 为0 永不过期
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>导出学生照片</title>
	<script type="text/javascript" src='../js/jquery-3.2.1.min.js'></script>
	<script type="text/javascript" src='../js/fun.js'></script>
	<style type="text/css">
		#shell{
			position: absolute;
		    top: 0;
		    left: 0;
		    right: 0;
		    bottom: 0;
		    background: #ccc;
		    opacity: 0.7;
		}
		.zshow{
			display:none;
		}
		#shell_img{
			position: absolute;
		    left: 0;
		    right: 0;
		    text-align: center;
		    top: 400px;
		}
	</style>
</head>
<body>
	<input type="hidden" id='w' value="<?php echo $_GET['w'];?>">
	<div id="shell" class="zshow">
		
	</div>
	<div id="shell_img" class="zshow">
		<img src="/cxg/Public/iconfont/loading.gif" width="35" height="35">
        <p>正在导出...</p>
	</div>
</body>
<script type="text/javascript">
	window.exportPhoto = function()
	{
		$(".zshow").show();
		var w = $("#w").val();
		$.ajax({
			url:'./exportStudentFunction.php',
			data:{w:w,typ:'json'},
			type:'post',
			dataType:'json',
			async:'false',
			success:function(data){
				alert("整理完成，开始下载！");
				window.location.href = data.content;
				setTimeout("window.close();",1000);
			},
			error:function(){
				alert('失败');
			}
		})
	}
	setTimeout("exportPhoto();",500);
</script>
</html>