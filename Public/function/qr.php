<?php

require_once 'phpqrcode.php';
require_once '../task/config.php';
$id = @$_GET['i'];
$rand = @$_GET['r'];
if(empty($id) || empty($rand))
{
	die("邀请信息不存在！");
}
$s = $id.explode(",", $rand)[0];
$img = '../qrcode/'.$s.'_logo.png';
if($img)
{
	$s = $id.$rand;
	echo '<div style="width:100%;text-align:center;"><img style="display:inline-block;" src="'.$img.'"></div>'; 
}
else
{
	die("邀请码错误！");
}
    
	



?>