<?php
/**
* @author  Yongjun Wang
* @function 重新学生的分数（每月月初执行）
* @date    25/04/2018
*/

$con = mysql_connect("localhost",'root','123456');
if(!$con)
{
	die("数据库连接失败！");
}
mysql_set_charset("utf8");
mysql_select_db("manage");
$sql = "UPDATE student SET points=100";
$res = mysql_query($sql);
var_dump($res);
mysql_close($con);


?>