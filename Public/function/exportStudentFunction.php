<?php
Header("Content-Type:text/html;charset=utf-8");
ini_set('memory_limit','3072M');    // 临时设置最大内存占用为3G
set_time_limit(0);   // 设置脚本最大执行时间 为0 永不过
$type = @$_POST['typ'];
$return = array();
if($type == 'json')
{
	$w = $_POST['w'];

	//连接数据库
	$conn = mysql_connect("localhost","root","123456");
	if(!$conn)
	{
		$return['status']	= 'failure';
		$return['content']	= '数库连接失败！';
	}
	else
	{
		mysql_set_charset("utf8");
		mysql_select_db("manage");

		//获取学生信息
		$sql1 = "select * from student";
		$res1 = mysql_query($sql1);
		$student_list = array();
		while($re1 = mysql_fetch_assoc($res1))
		{
			$student_list[] = $re1;
		}

		$download_file = array();

		//获取班级信息
		$sql2 = "select * from class";
		$res2 = mysql_query($sql2);
		$class_list = array();
		while($re2 = mysql_fetch_assoc($res2))
		{
			$class_list[$re2['id']] = $re2;
		}

		//获取宿舍信息
		$sql3 = "select * from hostel";
		$res3 = mysql_query($sql3);
		$hostel_list = array();
		$build_ids = array();
		while($re3 = mysql_fetch_assoc($res3))
		{
			$hostel_list[$re3['id']]['build'] = $re3['build'];
			$hostel_list[$re3['id']]['hostel']['id'] = $re3['id'];
			$hostel_list[$re3['id']]['hostel']['no'] = $re3['no'];
		}

		//获取教师信息
		$sql4 = "select * from leader";
		$res4 = mysql_query($sql4);
		$leader_list = array();
		while($re4 = mysql_fetch_assoc($res4))
		{
			$leader_list[] = $re4;
		}

		//清空文件夹下面的所有文件
		$dirs = "./TestImg/";
		$exp_arr = array(".","..");
		do {
		   rmdirs($dirs);
		} while (scandir($dirs) !== $exp_arr);

		if($w == 1)
		{
			//按班级导出
			//把学生分班
			$base_path = 'TestImg/';
			foreach($student_list as $key=>$val)
			{
				$class_list[$val['class_id']]['student_list'][] = $val;
			}

			foreach($class_list as $k=>$v)
			{
				$p = $base_path.$v['name'];
				@mkdir($p);
				chmod($p."/",0777);
				foreach($v['student_list'] as $kk=>$vv)
				{
					$rr = base64_image_content($vv['photo'], $base_path.$v['name'],$vv['name']."_".$vv['id']);
					$download_file[] = $v['name']."/".$vv['name']."_".$vv['id'].".".$rr;
				}
			}
		}

		if($w == 2)
		{
			//按宿舍导出
			//把学生分楼   宿舍
			$base_path = "TestImg/";
			foreach($student_list as $key=>$val)
			{
				if($val['dormitory_id']==0 || empty($val['dormitory_id']))
				{
					$n = "走勤";
					@mkdir($base_path.$n);
					chmod($base_path.$n."/",0777);
					$rr = base64_image_content($val['photo'], $base_path.$n,$val['name']."_".$val['id']);
					$download_file[] = $n."/".$val['name']."_".$val['id'].".".$rr;
				}
				else
				{
					@mkdir($base_path.$hostel_list[$val['dormitory_id']]['build']);
					chmod($base_path.$hostel_list[$val['dormitory_id']]['build']."/",0777);
					@mkdir($base_path.$hostel_list[$val['dormitory_id']]['build']."/".$hostel_list[$val['dormitory_id']]['hostel']['no']);
					chmod($base_path.$hostel_list[$val['dormitory_id']]['build']."/".$hostel_list[$val['dormitory_id']]['hostel']['no']."/",0777);
					$rr = base64_image_content($val['photo'], $base_path.$hostel_list[$val['dormitory_id']]['build']."/".$hostel_list[$val['dormitory_id']]['hostel']['no'],$val['name']."_".$val['id']);
					$download_file[] = $hostel_list[$val['dormitory_id']]['build']."/".$hostel_list[$val['dormitory_id']]['hostel']['no']."/".$val['name']."_".$val['id'].".".$rr;
				}
			}
		}

		if($w == 3)
		{
			//导出教师信息
			$base_path = "TestImg/";
			foreach($leader_list as $key=>$val)
			{
				$rr = base64_image_content($val['photo'], $base_path,$val['name']."_".$val['id']."_t");
				$download_file[] = $val['name']."_".$val['id']."_t.".$rr;
			}
		}

		//打包下载
        $cur_file = "./TestImg";
        $save_path = './TestImg/';
        require_once("./fileToZip.php");
        
        // 打包下载
        $handler = opendir($cur_file); //$cur_file 文件所在目录
        closedir($handler);
        if($w == 1)
        {
        	 $scandir = new traverseDir($cur_file,$save_path,"studentByClass"); //$save_path zip包文件目录
        }
       	if($w == 2)
        {
        	 $scandir = new traverseDir($cur_file,$save_path,"studentByHostel"); //$save_path zip包文件目录
        }
        if($w == 3)
        {
        	$scandir = new traverseDir($cur_file,$save_path,"teacher"); //$save_path zip包文件目录
        }
        $rs = $scandir->toZip($download_file);
		$return['status']	= 'success';
		$return['content']	= $rs;
	}

		
}
else
{
	$return['status']	= 'failure';
	$return['content']	= '协议内容有误！';
}
echo json_encode($return);

function base64_image_content($base64_image_content,$path,$name){
    //匹配出图片的格式
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
        $type = $result[2];
        $new_file = $path."/";
        if(!file_exists($new_file)){
            //检查是否有该文件夹，如果没有就创建，并给予最高权限
            mkdir($new_file, 0700);
        }
        $new_file = $new_file.$name.".{$type}";
        if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
            return $type;
        }else{
            return false;
        }
    }else{
        return false;
    }
}


function rmdirs($dir){
        //error_reporting(0);    函数会返回一个状态,我用error_reporting(0)屏蔽掉输出
        //rmdir函数会返回一个状态,我用@屏蔽掉输出
        $dir_arr = scandir($dir);
        foreach($dir_arr as $key=>$val){
            if($val == '.' || $val == '..'){}
            else {
                if(is_dir($dir.'/'.$val))    
                {                            
                    if(@rmdir($dir.'/'.$val) == 'true'){}    //去掉@您看看                
                    else
                    rmdirs($dir.'/'.$val);                    
                }
                else                
                unlink($dir.'/'.$val);
            }
        }
    }    

?>