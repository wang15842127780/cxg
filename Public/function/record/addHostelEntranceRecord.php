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

		$arr = @explode("_",$name);
		$pid = $arr[1];
		if($arr[2] == 't')
		{
			$ptype = 't';
		}
		else
		{
			$ptype = 's';
		}
		if(!empty($pid) && $pid>0)
		{
			$redis = new Redis();
			$redis->connect("127.0.0.1",6379);
			$info = array();
			$info['id'] = $pid;
			$info['inout'] = $t;
			$info['ptype'] = $ptype;
			$redis->set("hostelInfo",json_encode($info));

			$sql = "INSERT INTO hostel_entrance_record(alarm_id,device_name,alarm_time,type,ptype,record_type) VALUES('".$pid."','".$device_name."','".date("Y-m-d H:i:s",time())."','".$t."','".$ptype."','new')";
			mysql_query($sql);
		}
			
	}
}
else
{
	echo "错误！";
}
  

?>