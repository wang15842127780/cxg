<?php

require_once 'phpqrcode.php';
require_once '../task/config.php';
$id = @$_GET['i'];
$rand = @$_GET['r'];
if(empty($id) || empty($rand))
{
	die("邀请信息不存在！");
}
$sql = "SELECT * FROM entry_record WHERE id='".$id."' AND rand='".$rand."'";
$res = mysql_query($sql);
$sql1 = "SELECT * FROM config WHERE name='host_ip'";
$res1 = mysql_query($sql1);
$re1 = mysql_fetch_assoc($res1);
if(!empty($res))
{
	//生成二维码图片
	$s = $id.$rand;
	echo '<div style="width:100%;text-align:center;"><img style="display:inline-block;" src="../qrcode/'.$s.'_logo.png"></div>'; 
}
else
{
	die("邀请码错误！");
}
    
	



?>