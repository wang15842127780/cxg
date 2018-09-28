<?php
Header("Content-Type:text/html;charset=utf-8");
ini_set('memory_limit','3072M');    // 临时设置最大内存占用为3G
set_time_limit(0);   // 设置脚本最大执行时间 为0 永不过
$type = @$_GET['types'];
$return = array();
if($type == 'json')
{
	//连接数据库
	$conn = mysql_connect("localhost","root","123456");
	if(!$conn)
	{
		echo "数据库连接失败！";
	}
	else
	{
		mysql_set_charset("utf8");
		mysql_select_db("manage");

		$name = $_GET['person_name'];
		$device_name = $_GET['device_name'];
		$t = $_GET['inout'];

		$aa = explode("_", $name);
		$pid = $aa[1];
		if($aa[2] == 't'){
			$p = "t";
		}else
		{
			$p = "s";
		}

		$sql = "INSERT INTO main_entrance_record(alarm_id,device_name,alarm_time,type,ptype) VALUES('".$pid."','".$device_name."','".date("Y-m-d H:i:s",time())."','".$t."','".$p."')";
		$res = mysql_query($sql);
		// echo "成功！";
	}
}
else
{
	// echo "错误！";
}
  

?>