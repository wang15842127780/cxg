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
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/png")
|| ($_FILES["file"]["type"] == "image/pjpeg")))
  {
    $m = $_POST['class'];
    if($_FILES["file"]["size"] < 104857600){
      if ($_FILES["file"]["error"] > 0)
        {
        echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
        }
      else
        {
          $return = array();
          $ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
          $file_name = $m."_".time().rand(00000,99999);
        if (file_exists("/home/wwwroot/cxg/Public/upload/$m_" . $_FILES["file"]["name"]))
          {
            echo $_FILES["file"]["name"] . " already exists. ";
          }
        else
          {
            if(move_uploaded_file($_FILES["file"]["tmp_name"],"/home/wwwroot/cxg/Public/upload/" . $file_name . ".".$ext))
            {
              $img = "/home/wwwroot/cxg/Public/upload/" . $file_name . ".".$ext;
              $img1 = imageResize($file_name . ".".$ext,"/home/wwwroot/cxg/Public/upload/");
              $base64_img = base64EncodeImage($img1);
              unlink($img);
              $return['status'] = 'success';
              $return['file_name'] = $base64_img;
            }
            else
            {
              // echo json_encode('move file error');
              $return['status'] = 'failure';
              $return['content'] = 'move file error';
            }
            
          }
        }
    }
    else
    {
      // echo json_encode("Picture size must not exceed 1M!");
      $return['status'] = 'failure';
      $return['content'] = 'Picture size must not exceed 100M!';
    }
  }
else
  {
  // echo json_encode("Wrong picture type");
    $return['status'] = 'failure';
    $return['content'] = 'Wrong picture type';
  }
  echo json_encode($return);
?>