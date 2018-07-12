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
$url_arr = explode(",",$url_row);
foreach($url_arr as $key=>$url)
{
	$cmd1 = "/rtmonitor/manage";
	$return1 = curl_request($url.$cmd1);
	$return11 = json_decode($return1);
	var_dump($return11);

	//获取所在的相机
	$camera_ids = array();
	if(!empty($return11->camera_list))
	{
		foreach($return11->camera_list as $k=>$v)
		{
			$camera_ids[$v->camera_id] = $v->camera_id;
		}
		var_dump($camera_ids);

		//循环开启相机
		// foreach($camera_ids as $k=>$v)
		// {
		// 	$cmd2 = "/rtmonitor/manage/video_recognition/".$v;
		// 	$return2 = curl_request($url.$cmd2);
		// 	$return22 = json_decode($return2);
		// }

		//根据相机列表查出每个相机绑定的班级
		$camera_row = implode(",",$camera_ids);
		$sql2 = "SELECT * FROM camera where name='".$return11->camera_list[0]->camera_name."'";
		$resource = mysql_query($sql2);
		$camera_list = array();
		while($re = mysql_fetch_assoc($resource))
		{
			$camera_list[$re['room']][] = $re;
		}
		echo "相机绑定的班级";
		var_dump($camera_list);

		foreach($camera_list as $k=>$v)
		{
			$cc = array();
			foreach($v as $kk=>$vv)
			{
				$cc[] = $vv['id'];
			}
			echo "班级的相机";
			$class_sql = "SELECT * FROM syllabus where room='".$k."' AND time='3' AND week='".date('w')."'";
			$class_res = mysql_query($class_sql);
			$fff = mysql_fetch_assoc($class_res);
			$class_stu = $fff['student'];
			$lesson_id = $fff['subject'];
			if(!empty($class_stu))
			{
				$attend_ids = explode(",",$class_stu);
				var_dump($attend_ids);
				$class_camera = implode("+",$cc);
				$time_start = date("Y/m/d+H:i:s",time()-2400);
				$time_end = date("Y/m/d+H:i:s",time());
				$face_cmd = "/rtmonitor/alarm?alarm_type=1&time_start=".$time_start."&time_end=".$time_end;
				var_dump($face_cmd);
				$renlian = curl_request($url.$face_cmd);
				$face_res = json_decode($renlian);
				var_dump($face_res);
				$true_ids = array();
				if(!empty($face_res->alarm_list))
				{
					foreach($face_res->alarm_list as $kkk=>$vvv)
					{
						if(!in_array($vvv->search_list[0]->person_id,$true_ids) && in_array($vvv->search_list[0]->person_id,$attend_ids))
						{
							$true_ids[] = $vvv->search_list[0]->person_id;
							$initsql = "INSERT INTO attend_detail(id,stu_id,room,time,type,week,weektime) VALUES(NULL,'".$vvv->search_list[0]->person_id."','".$k."','".$vvv->alarm_time."',1,'".date('w')."',3)";
							mysql_query($initsql);
						}
					}
				}
				echo "实际出席人数<br>";
				var_dump($true_ids);
				$dis_ids = array_diff($attend_ids,$true_ids);
				var_dump($dis_ids);
				if(!empty($dis_ids))
				{
					foreach($dis_ids as $key=>$val)
					{
						$initsql = "INSERT INTO attend_detail(id,stu_id,room,time,type,week,weektime) VALUES(NULL,'".$val."','".$k."','".date("Y-m-d H:i:s",time())."',3,'".date('w')."',3)";
						mysql_query($initsql);
					}
				}
				$detail_sql = "INSERT INTO attend_record(id,room,date,week,time,total,attend,absent,absent_id,lesson) VALUES(null,'".$k."','".date('Y-m-d')."','".date('w')."','3','".count($attend_ids)."','".count($true_ids)."','".count($dis_ids)."','".@implode(',',$dis_ids)."','".$lesson_id."')";
				mysql_query($detail_sql);
				var_dump($detail_sql);
			}
			
		}


	}
}




$time = date('Y-m-d H:i:s',time());
$time .= "星期".date('w').".........";
file_put_contents("lesson3.txt",$time,FILE_APPEND);
mysql_close($con);


?>
