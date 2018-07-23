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
	$re = mysql_fetch_assoc($res);
	$value = $re1['value']."/cxg/index.php?m=Home&c=AndroidVisitor&a=getVisitor&types=json&i=".$id."&r=".$rand."\r";                  //二维码内容

	$errorCorrectionLevel = 'L';    //容错级别 
	$matrixPointSize = 14;           //生成图片大小  

	//生成二维码图片
	$s = $id.$rand;
	$filename = '../qrcode/'.$id.$rand.'.png';
	QRcode::png($value,$filename , $errorCorrectionLevel, $matrixPointSize, 2);  

	$QR = $filename;                //已经生成的原始二维码图片文件  
	$logo = "../images/lingxianguoji.png";
	if ($logo !== FALSE) { 
		 $QR = imagecreatefromstring(file_get_contents($QR)); 
		 $logo = imagecreatefromstring(file_get_contents($logo)); 
		 $QR_width = imagesx($QR);//二维码图片宽度 
		 $QR_height = imagesy($QR);//二维码图片高度 
		 $logo_width = imagesx($logo);//logo图片宽度 
		 $logo_height = imagesy($logo);//logo图片高度 
		 $logo_qr_width = $QR_width / 5; 
		 $scale = $logo_width/$logo_qr_width; 
		 $logo_qr_height = $logo_height/$scale; 
		 $from_width = ($QR_width - $logo_qr_width) / 2; 
		 //重新组合图片并调整大小 
		 imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height); 
	} 
	//输出图片 
	imagepng($QR, '../qrcode/'.$s.'_logo.png'); 
	echo '<div style="width:100%;text-align:center;"><img style="display:inline-block;" src="../qrcode/'.$s.'_logo.png"></div>'; 
}
else
{
	die("邀请码错误！");
}
    
	



?>