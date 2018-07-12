<?php
	$con = mysql_connect('localhost','root','123456');
	if(!$con)
	{
		die('数据库连接失败！');
	}
	mysql_set_charset("utf8");
	mysql_select_db('manage');

	$sss = "SELECT * FROM config WHERE name='url'";
	$ss = mysql_query($sss);
	$url_row = mysql_fetch_assoc($ss)['value'];
	


?>