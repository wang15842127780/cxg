<?php
$i = $_GET['i'];
$r = $_GET['r'];
if(!empty($i) && !empty($r)){
	require_once("./phpqrcode.php");
	$value = "&i=".$i."&n=".rand(0000,9999)."&q=".rand(00000,99999)."&r=".$r."\r";
	$errorCorrectionLevel = 'L';    //容错级别 
	$matrixPointSize = 14;           //生成图片大小  

	//生成二维码图片
	$s = $i.$r;
	$filename = '../qrcode/'.$i.$r.'.png';
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
	unlink("../qrcode/".$s.".png");
	echo "success";
}else{
	echo "failure";
}
	

?>