<?php
/**
*	@fun 	添加报警信息
* 	@author Yongjun Wang
*	@time  	2017.08.09
*	@table 	warning
*/

require("functions.php");
require("config.php");
$time_start = date("Y/m/d+H:i:s",time()-24*3600);
$cmd = "/rtmonitor/alarm?alarm_type=1&amera_id_list=13&time_start=".$time_start."&top=20";
$return = curl_request($url.$cmd);
$return1 = json_decode($return);
$size = $return1->alarm_size;
echo "<pre>";
var_dump($return1);
$allow_list = array(13);
if(!empty($size))
{
	for($i=0;$i<$size;$i++)
	{
		$camera_id = $return1->alarm_list[$i]->camera_id;
		if(in_array($camera_id,$allow_list))
		{
			$j = 0;
			while($return1->alarm_list[$i]->search_list[$j])
			{
				$sql = "SELECT * FROM warning WHERE alarm_id='".$return1->alarm_list[$i]->search_list[$j]->search_result_id."'";
				$res = mysql_query($sql);
				$re = mysql_fetch_assoc($res);
				if(!$re)
				{
					// $sql1 = "INSERT INTO warning(id,alarm_id,stu_id,camera_id,camera_name,time) VALUES(NULL,'".$return1->alarm_list[$i]->search_list[$j]->search_result_id."','".$return1->alarm_list[$i]->search_list[$j]->person_id."','".$return1->alarm_list[$i]->camera_id."','".$return1->alarm_list[$i]->camera_name."','".$return1->alarm_list[$i]->alarm_time."')";
					// $res1 = mysql_query($sql1);
					// var_dump($res1);
				}
				$j++;
			}
		}
	}
}
echo "<pre>";
var_dump($return1);
file_put_contents("warning.txt","123",FILE_APPEND);
mysql_close($con);


?>