<?php 
/**
*	@fun       添加相机信息
* 	@author    Yongjun Wang
*	@time      2017.08.08
*
*/
	include("functions.php");
	include("config.php");
	$cmd = "/rtmonitor/manage";
	var_dump($url_row);
	var_dump($url);
	$url_arr = explode(",",$url_row);
	foreach($url_arr as $url)
	{
		$return = curl_request($url.$cmd);
		$return1 = json_decode($return);
		var_dump($return1);
		//清除所记录
		$sql = "DELETE FROM camera";
		$res = mysql_query($sql);
		if($return1->camera_list)
		{
			$size = $return1->list_size;
			//添加相机
			for($i=0;$i<$size;$i++)
			{
					$sql1 = "INSERT INTO camera(id,name,url,status) VALUES('".$return1->camera_list[$i]->camera_id."','".$return1->camera_list[$i]->camera_name."','".$return1->camera_list[$i]->rtsp."','".$return1->camera_list[$i]->camera_state."')";
					$res1 = mysql_query($sql1);
			}
		}
	}
		

	mysql_close($con);
?>

