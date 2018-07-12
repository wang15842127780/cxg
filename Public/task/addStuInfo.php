<?php
/**
*	@fun 	添加学生信息
*	@author Yongjun Wang
*	@time   2017.08.08
*/
	
	include("config.php");
	include("functions.php");
	$cmd1 = "http://192.168.1.56:8000/facedb";
	$return1 = curl_request($cmd1);
	$return11 = json_decode($return1);
	echo "<pre>";
	$sql1 = "delete from student";
	mysql_query($sql1);
	if(!empty($return11->facedb_list))
	{
		foreach($return11->facedb_list as $k=>$v)
		{
			$dbid = $v->db_id;
			$cmd2 = "http://192.168.1.56:8000/facedb/$dbid/persons";
			$return2 = curl_request($cmd2);
			$return22 = json_decode($return2);
			// var_dump($return22);
			if(!empty($return22->person_list))
			{
				// $csql = "select id from where name='".$v->name."'";
				// var_dump($csql);
				// $cres = mysql_query($csql);
				// $cid = mysql_fetch_assoc($cres);
				// var_dump($cid);
				foreach($return22->person_list as $kk=>$vv)
				{
					$sex = $vv->sex=='male'?1:0;
					$sql2 = "INSERT INTO student(id,name,sex,wash) VALUES('".$vv->person_id."','".$vv->name."','".$sex."',1)";
					mysql_query($sql2);
				}
			}
		}
	}
	// var_dump($return11);









	mysql_close($con);
	
?>