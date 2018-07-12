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
	$filename = '../qrcode/'.$id.$rand.'.png';
	QRcode::png($value,$filename , $errorCorrectionLevel, $matrixPointSize, 2);  

	$QR = $filename;                //已经生成的原始二维码图片文件  


	$QR = imagecreatefromstring(file_get_contents($QR));  

	//输出图片  
	imagepng($QR, 'qrcode.png');
	echo "<div style='width:100%;padding-top:50px;text-align:center;'><img src='".$filename."'></div>";
}
else
{
	die("邀请码错误！");
}
    
	



?>