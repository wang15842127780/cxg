<?php
/**
*	@fun 	添加报警信息
* 	@author Yongjun Wang
*	@time  	2017.08.09
*	@table 	warning
*/

require("config.php");
$i=1;
for($j=1;$j<24;$j++)
{
	$array = array();
	for($k=1;$k<101;$k++)
	{
		$array[] = $i;
		$i++;
	}
	$id_row = implode(",",$array);
	$sql = "UPDATE syllabus SET student='".$id_row."' WHERE id=$j";
	mysql_query($sql);
	var_dump($sql);
	echo "<br>";
}


?>