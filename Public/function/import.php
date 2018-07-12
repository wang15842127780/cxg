<?php
function base64EncodeImage ($image_file) {
  $base64_image = '';
  $image_info = getimagesize($image_file);
  $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
  $base64_image = 'data:' . $image_info['mime'] . ';base64,' . base64_encode($image_data);
  return $base64_image;
}
function imageResize($picname,$path,$maxWidth=480,$maxHeight=640,$pre="s_")
{
  $path = rtrim($path,"/")."/";
  //1获取被缩放的图片信息
  $info = getimagesize($path.$picname);
  //获取图片的宽和高
  $width = $info[0];
  $height = $info[1];

  //2根据图片类型，使用对应的函数创建画布源。
  switch($info[2]){
      case 1: //gif格式
          $srcim = imagecreatefromgif($path.$picname);
          break;
      case 2: //jpeg格式
          $srcim = imagecreatefromjpeg($path.$picname);
          break;
      case 3: //png格式
          $srcim = imagecreatefrompng($path.$picname);
          break;
     default:
          return false;
          //die("无效的图片格式");
          break;
  }
  //3. 计算缩放后的图片尺寸
  if($maxWidth/$width<$maxHeight/$height){
      $w = $maxWidth;
      $h = ($maxWidth/$width)*$height;
  }else{
      $w = ($maxHeight/$height)*$width;
      $h = $maxHeight;
  }
  //4. 创建目标画布
  $dstim = imagecreatetruecolor($w,$h); 

  //5. 开始绘画(进行图片缩放)
  imagecopyresampled($dstim,$srcim,0,0,0,0,$w,$h,$width,$height);

  //6. 输出图像另存为
  $path = "/home/wwwroot/cxg/Public/upload/";
  switch($info[2]){
      case 1: //gif格式
          imagegif($dstim,$path.$pre.$picname);
          break;
      case 2: //jpeg格式
          imagejpeg($dstim,$path.$pre.$picname);
          break;
      case 3: //png格式
          imagepng($dstim,$path.$pre.$picname);
          break;
  }

  //7. 释放资源
  imagedestroy($dstim);
  imagedestroy($srcim);
  return $path.$pre.$picname;
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>文件上传</title>
    <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
</head>
<body>
    <form id="form" action="" method="post" enctype="multipart/form-data">
        <input type="file" name="excel" ><br><br>
        <input type="submit" value="上传文件">
    </form>
    <button id="ccc" style="display:none;">cccc</button>
    <div id="shell" class="zshow" style="display: none;position:absolute;top:0;bottom:0;left:0;right:0;background:#ccc;opacity:0.6;">

    </div>
    <div id="shell_img" class="zshow" style="position:absolute;left:0;right:0;top:400px;text-align:center;">
        <img src="/cxg/Public/iconfont/loading.gif" width="35" height="35">
        <p>导入中...</p>
    </div>
    <div id="time_box" style="display:none;position:absolute;top:0;bottom:0;left:0;right:0;background:#ccc;opacity:0.6;text-align:center;">
        <span style="display:inline-block;margin-top:300px;width:300px;font-size:30px;"><span id="times" style="color:red;">5</span>秒后自动关闭</span>
    </div>
</body>
</html>
<script type="text/javascript">
    $("#ccc").click(function()
    {
        $('.zshow').show();
        $('#shell_img').hide();
        $('#time_box').show();
        closeWindow();
    })
    window.closeWindow = function()
    {
        var time = $('#times').html();
        if(parseInt(time)>=1)
        {
            var etime = parseInt(time)-1;
            setTimeout("$('#times').html("+etime+");closeWindow();",1000);  
        }
        else
        {
            window.close();
        }
    }
</script>
<?php	
    @$ex = $_FILES['excel'];
	if(!empty($ex))
	{
        // echo "<script>$('.zshow').show();alert('开始上传！');</script>";
		if($ex['type']=='application/vnd.ms-excel' || $ex['type']=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
		{
			$filename = time().substr($ex['name'],stripos($ex['name'],'.'));  
	        $path = '../upload/'.$filename;//设置移动路径  
	        $bool = move_uploaded_file($ex['tmp_name'],$path);  
	        //表用函数方法 返回数组  
	        if($bool)
	        {
	        	doImport($path);
	        }
	        else
	        {
	        	echo "<script>alert('上传失败，请检查该目录的权限！');</script>";
	        }
		}
		else
		{
			echo "<script>alert('上传文件类型错误！');</script>";
		}
	}
    else
    {
        echo "<script>setTimeout(\"$('.zshow').hide();\",300)</script>";
    }
	function doImport($path)
	{
		require_once("../PHPExcel-1.8/Classes/PHPExcel/IOFactory.php");
		// $objReader = \PHPExcel_IOFactory::createReader('Excel5');//创建读取实例
		$extension = pathinfo($path,PATHINFO_EXTENSION);
		if( $extension =='xlsx' )
		{
		 $objReader = PHPExcel_IOFactory::createReader('Excel2007');
		}
		else
		{
		 $objReader = PHPExcel_IOFactory::createReader('Excel5');
		}
        /*
         * log()//方法参数
         * $file_name excal文件的保存路径
         */
        $objPHPExcel = $objReader->load($path,$encode='utf-8');//加载文件
        $sheet = $objPHPExcel->getSheet(0);//取得sheet(0)表
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumn = $sheet->getHighestColumn(); // 取得总列数
        $conn=mysql_connect("localhost","root","123456");
        if(!$conn)
        {
        	die("数据库连接失败！");
        }
        mysql_select_db("manage",$conn);
        mysql_set_charset("utf8");
        $sex = array("男"=>1,"女"=>0);
        var_dump($highestRow);
        for($i=2;$i<=$highestRow;$i++)
        {
            $number=$objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue();
            $data['name'] = $objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue();
            // $data['iden'] = number_format($iden,0,'','');
            // $sexs = $objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue();
            // $data['sex']= $sex[$sexs];
            // $aaa0 = $objPHPExcel->getActiveSheet()->getCell("D".$i)->getValue();
            
            // $data['class_id'] = $objPHPExcel->getActiveSheet()->getCell("E".$i)->getValue();
            // $data['dormitory_id'] = $objPHPExcel->getActiveSheet()->getCell("F".$i)->getValue();
            $data['class_id'] = 1;
            $data['sex'] = 1;
            $data['dormitory_id'] = 1;
            // $data['contact'] = $objPHPExcel->getActiveSheet()->getCell("G".$i)->getValue();
            // $data['contact_phone'] = $objPHPExcel->getActiveSheet()->getCell("H".$i)->getValue();
            $data['iden'] = $objPHPExcel->getActiveSheet()->getCell("I".$i)->getValue();
            // $data['note'] = $objPHPExcel->getActiveSheet()->getCell("I".$i)->getValue();
            $img1 = imageResize($data['iden'] . ".jpg","/home/wwwroot/cxg/student_photo/");
            $base64_img = base64EncodeImage($img1);

            $sql = "select * from student where iden = '".$data['iden']."'";
            $res = mysql_query($sql);
            $re = mysql_fetch_assoc($res);
            if($re)
            {
            	$sql1 = "update student set name='".$data['name']."',iden='".$data['iden']."',sex='".$data['sex']."',class_id='".$data['class_id']."',dormitory_id='".$data['dormitory_id']."',contact='".$data['contact']."',contact_phone='".$data['contact_phone']."',note='".$data['note']."',photo='".$base64_img."' where iden='".$dat['iden']."'";
            	mysql_query($sql1);
            }
            else
            {
            	$sql1 = "insert into student (name,iden,sex,class_id,dormitory_id,contact,contact_phone,note,photo) values('".$data['name']."','".$data['iden']."','".$data['sex']."','".$data['class_id']."','".$data['dormitory_id']."','".$data['contact']."','".$data['contact_phone']."','".$data['note']."','".$base64_img."')";
            	mysql_query($sql1);
            }
            if($i == $highestRow)
            {
            	echo "<script>alert('导入完成！');$('#ccc').click();</script>";
            }
        }
	}

?>


