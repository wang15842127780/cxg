<?php
require("./config.php");
$sql = "select * from config";
$res = mysql_query($sql);
$list = array();
while($re = mysql_fetch_assoc($res))
{
	$list[$re['name']] = $re['value'];
}



?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>系统IP配置中心</title>
	<script type="text/javascript" src='../js/jquery-3.2.1.min.js'></script>
	<script type="text/javascript" src='../js/fun.js'></script>
	<style type="text/css">
		*{
			margin:0;
			padding:0;
		}
		table{
			border-collapse: collapse;
			border:1px solid black;
		}
		tr{
			height:40px;
			font-size:20px;
		}
		th{
			width:300px;
			border:1px solid black;
		}
		td{
			font-size:17px;
			border:1px solid black;
		}
		input{
			border:none;
			width:220px;
			background:transparent;
		}
		input:focus{
			border:none ;
			border-bottom:1px solid black;
			text-decoration: none;
			outline: none;
		}
		#tip{
			width:220px;
			position: fixed;
			right: 0;
			top: 20px;
			color:red;
			font-size:20px;
			padding:10px;
			background-color:#ffd40070;
			border-radius: 8px 0 0 8px;
		}
	</style>
</head>
<body>
	<div style="width:100%;text-align:center;">
		<table style="wdith:600px;display:inline-block;margin-top:20px;border-radius:5px;background:#b3f8ff;">
				<tr>
					<th>名称</th>
					<th>IP地址</th>
				</tr>
				<tr>
					<td>服务器IP</td>
					<td><input type="text" name='host_ip' id="host_ip" value="<?php echo $list['host_ip'];?>"></td>
				</tr>
				<tr>
					<td>教师考勤机IP</td>
					<td><input type="text" name='teacher_attendance_ip' id="teacher_attendance_ip" value="<?php echo $list['teacher_attendance_ip'];?>"></td>
				</tr>
				<tr>
					<td colspan="2">
						<button id="submit" style="width:90px;height:30px;font-size:15px;border-radius:5px;color:#fff;background:darkorange;">确定</button>
					</td>
				</tr>
		</table>
	</div>
	<div id='tip'>
		*提示:IP地址为多个时,用逗号隔开
	</div>
</body>
<script type="text/javascript">
	$("#submit").click(function()
	{
		var url = './function.php';
		var host_ip = $("#host_ip").val();
		var teacher_attendance_ip = $("#teacher_attendance_ip").val();
		var data = {host_ip:host_ip,teacher_attendance_ip:teacher_attendance_ip,act:'editIpConfig',typ:'json'};
		var res = ajax(url,data);

		if(res.status == 'success')
		{
			alert(res.content);
		}
		else
		{
			alert(res.content);
		}
	})
</script>
</html>