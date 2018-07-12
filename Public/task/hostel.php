<?php
/**
*	@fun 	添加报警信息
* 	@author Yongjun Wang
*	@time  	2017.08.09
*	@table 	warning
*/
header("Content-Type:text/html;charset=utf-8;");
require("functions.php");
require("config.php");
echo "<pre>";
$cmd1 = "/rtmonitor/manage";
$return1 = curl_request($url.$cmd1);
$return11 = json_decode($return1);
var_dump($return11);

//获取所在的相机
$camera_ids = array(13);
$in_camera = array(13);
$stu_list = array();
$out_camera = array();
//循环开启相机
// foreach($camera_ids as $k=>$v)
// {
// 	$cmd2 = "/rtmonitor/manage/video_recognition/".$v;
// 	$return2 = curl_request($url.$cmd2);
// 	$return22 = json_decode($return2);
// }

$camera_row = implode("+",$camera_ids);
$time_start = date("Y/m/d+H:i:s",time()-3600);
$time_end = date("Y/m/d+H:i:s",time());
$face_cmd = "/rtmonitor/alarm?alarm_type=1&time_start=".$time_start."&time_end=".$time_end."&camera_id_list=".$camera_row;
$record_res = curl_request($url.$face_cmd);
$record = json_decode($record_res);
var_dump($record->alarm_list);
if(!empty($record->alarm_list))
{
	foreach($record->alarm_list as $k=>$v)
	{
		if(!in_array($v->search_list[0]->person_id,$stu_list))
		{
			$stu_list = $v->search_list[0]->person_id;
			if(in_array($v->camera_id,$in_camera))
			{
				$sql = "INSERT INTO hostel_record(id,stu_id,date,time,type) VALUES(NULL,'".$v->search_list[0]->person_id."','".date('Y-m-d')."','".date("Y-m-d H:i:s")."','in')";
			}
			if(in_array($v->camera_id,$out_camera))
			{
				$sql = "INSERT INTO hostel_record(id,stu_id,date,time,type) VALUES(NULL,'".$v->search_list[0]->person_id."','".date('Y-m-d')."','".date("Y-m-d H:i:s")."','out')";
			}
			mysql_query($sql);
		}
	}
	var_dump($stu_list);
}
	
	





$time = date('Y-m-d H:i:s',time());
$time .= "星期".date('w').".........";
file_put_contents("hostel.txt",$time,FILE_APPEND);
mysql_close($con);


?>