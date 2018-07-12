<?php

/**
*	@fun 	开启相机抓拍功能
*	@author Yongjun Wang
*	@time 	2017.08.12
*/

	include("functions.php");
	include("config.php");
	$cmd = "/rtmonitor/manage";
	$return = curl_request($url.$cmd);
	$return1 = json_decode($return);
	$camera_list = array();
	$size = $return1->list_size;
	if(!empty($size))
	{
		for($i=0;$i<$size;$i++)
		{
			$cid = $return1->camera_list[$i]->camera_id;
			if(!in_array($cid,$camera_id))
			{
				$camera_list[] = $cid;
			}
		}
	}

	echo "<pre>";
	var_dump($return1);
	var_dump($camera_list);

	foreach($camera_list as $k=>$v)
	{
		$cmd1 = "/rtmonitor/manage/video_recognition/".$v;
		curl_request($url.$cmd1);
	}

?>