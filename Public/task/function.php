<?php
require("./config.php");
$act = $_POST['act'];
$act();

function editIpConfig()
{
	$type = @$_POST['typ'];
	$return = array();
	if($type == 'json')
	{
		$host_ip = $_POST['host_ip'];
		$outside_ip = $_POST['outside_ip'];
		$teacher_attendance_ip = $_POST['teacher_attendance_ip'];

		$sql1 = "UPDATE config SET value='".$host_ip."' WHERE name='host_ip'";
		mysql_query($sql1);
		$res1 = mysql_affected_rows();

		$sql2 = "UPDATE config SET value='".$teacher_attendance_ip."' WHERE name='teacher_attendance_ip'";
		mysql_query($sql2);
		$res2 = mysql_affected_rows();

		$sql3 = "UPDATE config SET value='".$outside_ip."' WHERE name='outside_ip'";
		mysql_query($sql3);
		$res3 = mysql_affected_rows();

		if($res1 || $res2 || $res3)
		{
			$return['status']	= 'success';
			$return['content']	= '修改配置文件成功！';
		}
		else
		{
			$return['status']	= 'failure';
			$return['content']	= '修改配置文件失败！';
		}
	}
	else
	{
		$return['status']	= 'failure';
		$return['content']	= '协议内容有误！';
	}
	echo json_encode($return);
}


?>