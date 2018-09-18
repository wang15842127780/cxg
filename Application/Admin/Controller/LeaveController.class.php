<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Cache\Driver\Redis;
use Admin\Model\MenuModel;
use Admin\Model\StudentLeaveModel;
use Home\Model\StudentModel;
use Home\Model\ClassModel;
use Admin\Model\ClassYearModel;
use Admin\Model\ConfigModel;
use Home\Model\ManageModel;
use Home\Model\TeacherLeaveModel;
use Admin\Model\LeaderModel;
require_once(COMMON_PATH."/Common/function.php");

class LeaveController extends Controller{
	public function index()
	{
		//身份判断
    	if(empty($_COOKIE['auser']))
    	{
    		header("Location:/cxg/index.php?m=Admin");
    		die;
    	}
        $menu = new MenuModel();
        $act = @$_GET['id'];
        $this->assign("typ",$act);
        $type = explode(".",$act)[1];
        switch($type)
        {
        	case "62":
        	$this->viewRecord();
        	break;
            case "80":
            $this->viewTeacherRecord();
            break;
            default:
            header("Location:/cxg/index.php?m=Admin");
            break;
        }
	}

	public function viewRecord()
	{
		$menu = new MenuModel();
        $menus = $menu->getMenuTree();
        $main_menu = $menus[0]['sub_menu'];
        $this->assign('main_menu',$main_menu);
		$this->display('viewRecord');
	}

    public function getLeaveList()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $cond = array();
            $student = new StudentModel();
            $student_list = $student->getAssocStudent();
            $class = new ClassModel();
            $class_list = $class->getAssocClass();
            foreach($student_list as $k=>$v)
            {
                $student_list[$k]['class_text'] = $class_list[$v['class_id']]['name'];
            }

            $uid = $_COOKIE['aid'];
            $year = new ClassYearModel();
            $year_info = $year->getClassYear(array('director_id'=>$uid));
            if(!empty($year_info))
            {
                $cond['year_id'] = $year_info[0]['id'];
            }

            if(!empty($_POST['uname']))
            {
                $uname = $_POST['uname'];
                $student_list = $student->getStudent(array('name'=>$uname));
                if(!empty($student_list))
                {
                    $ids = array();
                    foreach($student_list as $kk=>$vv)
                    {
                        $ids[] = $vv['id'];
                    }
                    $cond['student_id'] = array("IN",$ids);
                }
            }
            if(!empty($_POST['stime']))
            {
                $stime = $_POST['stime'];
                $cond['begin_date'] = array('gt',$stime);
            }
            if(!empty($_POST['etime']))
            {
                $etime = $_POST['etime'];
                $cond['end_date'] = array('lt',$etime);
            }
            $status = 5;
            $leave = new StudentLeaveModel();
            $leave_list = $leave->getStudentLeave($cond,array('id'=>"desc"));
            $status = array(
                1=>'待提交',
                3=>'<a href="javascript:void(0)" class="receive">待签收</a>',
                4=>'待审核',
                5=>'已批准',
                6=>'已完成',
                7=>'已退回'
            );
            $status1 = array(
                1=>'待提交',
                3=>'待签收',
                4=>'待审核',
                5=>'已批准',
                6=>'已完成',
                7=>'已退回'
            );
            if(!empty($leave_list))
            {
                //获取用户权限
                $manage = new ManageModel();
                $aid = $_COOKIE['aid'];
                $manage_info = $manage->getManage(array("id"=>$aid));
                $power = $manage_info[0]['power'];
                $power_arr = @explode(",",$power);
                if(in_array(6,$power_arr) || $power==="0")
                {
                    $return['leader'] = 1;
                    foreach($leave_list as $key=>$val)
                    {
                        $leave_list[$key]['student_text'] = $student_list[$val['student_id']]['name'];
                        $leave_list[$key]['class_text'] = $student_list[$val['student_id']]['class_text'];
                        $leave_list[$key]['status_text'] = $status[$val['status']];
                        $leave_list[$key]['detail_text'] = "<a href='javascript:void(0);' class='detail'>查看详情</a>";
                        if($val['status'] == 4)
                        {
                            $leave_list[$key]['act_text'] = "<a href='javascript:void(0)' class='check'>审核</a>";
                        }
                        else
                        {
                            $leave_list[$key]['act_text'] = '无';
                        }
                        if($val['type'] == 1)
                        {
                            $leave_list[$key]['leave_date'] = $val['begins_date']." — ".$val['ends_date']."<br>每天<br>".$val['begins_time']." — ".$val['ends_time'];
                        }
                        else
                        {
                            $leave_list[$key]['leave_date'] = $val['begin_date']."至".$val['end_date'];
                        }
                    }
                }
                else
                {
                    $return['leader'] = 0;
                    foreach($leave_list as $key=>$val)
                    {
                        $leave_list[$key]['student_text'] = $student_list[$val['student_id']]['name'];
                        $leave_list[$key]['class_text'] = $student_list[$val['student_id']]['class_text'];
                        $leave_list[$key]['status_text'] = $status1[$val['status']];
                        $leave_list[$key]['detail_text'] = "<a href='javascript:void(0);' class='detail'>查看详情</a>";
                        $leave_list[$key]['act_text'] = "无";
                    }
                }
                $return['status']   = 'success';
                $return['content']  = $leave_list;
            }
            else
            {
                $return['status']   = 'failure';
                $return['content']  = '暂无数据！';
            }
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容错误！';
        }
        $this->ajaxReturn($return);
    }

    //签收
    public function receive()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['id'];
            if(empty($id))
            {
                $return['status']   = 'failure';
                $return['content']  = '传值错误！';
            }
            else
            {
                $leave = new StudentLeaveModel();
                $cond = array();
                $cond['status'] = 4;
                $res = $leave->editStudentLeave($id,$cond);
                if($res)
                {
                    $return['status']   = 'success';
                    $return['content']  = '签收成功！';
                }
                else
                {
                    $return['status']   = 'failure';
                    $return['content']  = '签收失败！';
                }
            }
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容错误！';
        }
        $this->ajaxReturn($return);
    }

    public function receiveAll()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_COOKIE['aid'];
            $cond = array();
            $year = new ClassYearModel();
            $year_info = $year->getClassYear(array('director_id'=>$id));
            if(!empty($year_info))
            {
                $cond['year_id'] = $year_info[0]['id'];
            }
            $cond['status'] = 3;
            $leave = new StudentLeaveModel();
            $data = array();
            $data['status'] = 4;
            $res = $leave->data($data)->where($cond)->save();
            if($res)
            {
                $return['status']   = 'success';
                $return['content']  = '签收成功！';
            }
            else
            {
                $return['status']   = 'failure';
                $return['content']  = '签收失败！';
            }

        }  
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容错误！';
        }
        $this->ajaxReturn($return);
    }

    //审批假条
    public function checkLeave()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['id'];
            if(empty($id))
            {
                $return['status']   = 'failure';
                $return['content']  = '传值错误！';
            }
            else
            {
                $cond = array();
                $cond['leader_note'] = $_POST['reason'];
                $cond['auditby'] = $_COOKIE['auser'];
                $cond['status'] = $_POST['status'];
                $leave = new StudentLeaveModel();
                $res = $leave->editStudentLeave($id,$cond);
                if($res)
                {
                    $return['status']   = 'success';
                    $return['content']  = '操作成功！';
                }
                else
                {
                    $return['status']   = 'failure';
                    $return['content']  = '操作失败！';
                }
            }
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容错误！';
        }
        $this->ajaxReturn($return);
    }

    public function checkLeave1()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['id'];
            if(empty($id))
            {
                $return['status']   = 'failure';
                $return['content']  = '传值错误！';
            }
            else
            {
                $id = $_POST['id'];
                $leave = new StudentLeaveModel();
                $leave_info = $leave->getStudentLeave(array('id'=>$id));
                $sid = $leave_info[0]['student_id'];
                $student = new StudentModel();
                $student_info = $student->getStudent(array('id'=>$sid));
                $sex = array('female','male');
                $photo = $student_info[0]['photo'];
                $img = explode(",",$photo)[1];
                $img1 = str_replace(array("\r\n", "\r", "\n"), "", $img);
                $a = $student_info[0]['sex'];
                $cid = $student_info[0]['class_id'];
                $xingbie = $sex[$a];
                $person_name = $student_info[0]['name'];
                $class = new ClassModel();
                $class_list = $class->getAssocClass();

                //拼接时间信息 
                $sinfo = $leave_info[0];
                if($sinfo['type'] == 1)
                {
                	$date = $sinfo['begins_date']."至".$sinfo['ends_date'].'每天'.$sinfo['begins_time']."至".$sinfo['ends_time'];
                }
                else
                {
                	$date = $sinfo['begin_date'].'至'.$sinfo['end_date'];
                }
                
                $cond = array();
                $cond['leader_note'] = $_POST['reason'];
                $cond['auditby'] = $_COOKIE['auser'];
                $cond['status'] = $_POST['status'];
                $leave->startTrans();

                // $res1 = $this->person_register($img1,$person_name,$xingbie);
                 // iconv('GB2312', 'UTF-8', $str);  //utf-8转成gb2312
                $imgs = str_split($img1,102400); //	将图片按照100M分段传
                $aa = array();
                $aa['img'] = $imgs;
                $aa['name'] = $person_name;
                $aa['sex'] = $xingbie;
                $aa['len'] = strlen($img1);
                $aa['dates'] = $date;
                $aa['classes'] = $class_list[$cid]['name'];

                $res = $leave->editStudentLeave($id,$cond);
                if($res)
                {
                    $leave->commit();
                    $return['status']   = 'success';
                    $return['content']  = $aa;
                }
                else
                {
                    $leave->rollback();
                    $return['status']   = 'failure';
                    $return['content']  = '操作失败！';
                    $return['res'] = $res."-".$res1;
                }
            }
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容错误！';
        }
        $this->ajaxReturn($return);
    }

    public function Test()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['id'];
            $student = new StudentModel();
            $student_info = $student->getStudent(array('id'=>$id));
            $sex = array('female','male');
            $photo = $student_info[0]['photo'];
            var_dump($photo);
            $img = explode(",",$photo)[1];
            $a = $student_info[0]['sex'];
            $ssex = $sex[$a];
            $name = $student_info[0]['name'];
            // $res = $this->person_register($img,$name,$ssex);
            if(true)
            {
                $return['status']   = 'success';
                $return['content']  = $res;
            }
            $this->ajaxReturn($return);

        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容错误！';
        }
        $this->ajaxReturn($return);
    }

    function curl_request($url,$post='',$cookie='', $returnCookie=0){
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
            curl_setopt($curl, CURLOPT_REFERER, "http://XXX");
            if($post) {
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
            }
            if($cookie) {
                curl_setopt($curl, CURLOPT_COOKIE, $cookie);
            }
            curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
            curl_setopt($curl, CURLOPT_TIMEOUT, 20);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_BINARYTRANSFER, true); 
            $data = curl_exec($curl);
            if (curl_errno($curl)) {
                return curl_error($curl);
            }
            curl_close($curl);
            if($returnCookie){
                list($header, $body) = explode("\r\n\r\n", $data, 2);
                preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
                $info['cookie']  = substr($matches[1][0], 1);
                $info['content'] = $body;
                return $info;
            }else{
                return $data;
            }
    }

    public function person_register($img1,$person_name,$xingbie)
    {
                $this_header = array("content-type: application/json; charset=UTF-8");
                curl_setopt($ch1,CURLOPT_HTTPHEADER,$this_header);
                //人脸检测
                $arr = "";
                $db_id = 1;
                $site= "http://192.168.1.240:8000";
 
                $cmd = "/faceops/image_detection";
    
                $url=$site.$cmd;
                $data1 = json_encode(array('image_data' => array('type' => 'jpg','content'=>$img1 ) ));
                //curl使用post方式传输数据
                $ch1 = curl_init();
                curl_setopt($ch1,CURLOPT_HTTPHEADER,$this_header);
                curl_setopt($ch1, CURLOPT_URL, $url);
                curl_setopt($ch1, CURLOPT_POST, 1);
                curl_setopt($ch1, CURLOPT_POSTFIELDS, $data1);
                curl_setopt($ch1,CURLOPT_RETURNTRANSFER,1);
                curl_exec($ch1);
                $return1 = curl_multi_getcontent($ch1);
                $return1 = json_decode($return1);
                $ccc = $return1;
                $image1=$return1->dection_list[0]->image_data;
                $image1=$image1->content;
                $feature1=$return1->dection_list[0]->feature_data;
                $feature1=$feature1->content;

  
                curl_close($ch1);

                
                 
                $cmd="/facedb/".$db_id."/persons?name=".$person_name."&sex=".$xingbie."&card_type=128&id_card=212221";
                $url=$site.$cmd;
                //curl使用post方式传输数据
                $ch1 = curl_init();
                curl_setopt($ch1,CURLOPT_HTTPHEADER,$this_header);
                curl_setopt($ch1, CURLOPT_URL, $url);
                curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch1,CURLOPT_RETURNTRANSFER,1);
                curl_exec($ch1);
                $return1 = curl_multi_getcontent($ch1);
                $return1 = json_decode($return1);
                $person_id=$return1->person_data->person_id;
                curl_close($ch1);


                $data = array();
                $data['image_data']=array('type' => 'jpg','content'=>$image1);
                $data['feature_data']=array('content'=>$feature1);
                $data['blur']=1;
                $data = json_encode($data);
                $cmd="/facedb/".$db_id."/persons/".$person_id."/faces";
                $url=$site.$cmd;
                $ch1 = curl_init();
                curl_setopt($ch1,CURLOPT_HTTPHEADER,$this_header);
                curl_setopt($ch1, CURLOPT_URL, $url);
                curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch1, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch1,CURLOPT_RETURNTRANSFER,1);
                curl_exec($ch1);
                $return1 = curl_multi_getcontent($ch1);
                // $return1 = json_decode($return1);

                if($return1->ret == 0)
                {
                    return 'success';
                }
                else
                {
                    return "failure";
                }

    }

    public function getLeaveById()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['id'];
            if(empty($id))
            {
                $return['status']   = 'failure';
                $return['content']  = '传值错误！';
            }
            else
            {
                $leave = new StudentLeaveModel();
                $leave_info = $leave->getStudentLeave(array('id'=>$id));
                $status = array(
                    1=>'待提交',
                    3=>'待签收',
                    4=>'待批准',
                    5=>'已批准',
                    6=>'已完成',
                    7=>'已退回'
                );
                if(!empty($leave_info))
                {
                    $info = $leave_info[0];
                    $info['status_text'] = $status[$info['status']];
                    $return['status']   = 'success';
                    $return['content']  = $info;
                }
                else
                {
                    $return['status']   = 'failure';
                    $return['content']  = '数据错误！';
                }
            }
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容错误！';
        }
        $this->ajaxReturn($return);
    }


    //========================================================================================================
    //教师请假部分
    public function viewTeacherRecord()
    {
        $menu = new MenuModel();
        $menus = $menu->getMenuTree();
        $main_menu = $menus[0]['sub_menu'];
        $this->assign('main_menu',$main_menu);
        $this->display("viewTeacherRecord");
    }

    public function getTeacherLeaveList()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $tleave = new TeacherLeaveModel();
            $tleave_list = $tleave->getTeacherLeave(array(),array("id"=>"DESC"));

            $leader = new LeaderModel();
            $leader_list = $leader->getAssocList();

            $status_array = array(
                    "4"=>"<a href='javascript:void(0);' class='check'>审核</a>",
                    "5"=>"<span style='color:green;'>已完成</span>",
                    "7"=>"<span style='color:red;'>已退回</span>"
                );
            foreach($tleave_list as $key=>$val)
            {
                $tleave_list[$key]['teacher_name'] = $leader_list[$val['teacher_id']]['name'];
                $tleave_list[$key]['status_text'] = $status_array[$val['status']];
                if(empty($val['auditby']))
                {
                    $tleave_list[$key]['auditby'] = "";
                }
                if(empty($val['auditby_note']))
                {
                    $tleave_list[$key]['auditby_note'] = "";
                }
            }
            if(!empty($tleave_list))
            {
                $return['status']   = 'success';
                $return['content']  = $tleave_list;
            }
            else
            {
                $return['status']   = 'failure';
                $return['content']  = '暂无数据！';
            }
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容错误！';
        }
        $this->ajaxReturn($return);
    }


    public function agreeTeacherLeave()
    {
    	$type = @$_POST['typ'];
    	$return = array();
    	if($type == 'json')
    	{
    		$tleave = new TeacherLeaveModel();
    		$id = $_POST['id'];
    		if(empty($id))
    		{
    			$return['status']	= 'failure';
    			$return['content']	= '传值错误！';
    		}
    		else
    		{
    			$edit_row = array();
    			$edit_row['auditby']		= $_COOKIE['auser'];
    			$edit_row['auditby_note']	= $_POST['reason'];
    			$edit_row['status']			= $_POST['status'];
    			$tleave->startTrans();
    			$res = $tleave->editTeacherLeave($id,$edit_row);

    			$tleave_info = $tleave->getTeacherLeave(array("id"=>$id));
                $leader = new LeaderModel();
                $lid = $tleave_info[0]['teacher_id'];
                $leader_info = $leader->getLeader(array("id"=>$lid));
                $photo = $leader_info[0]['photo'];
                $img = explode(",",$photo)[1];
                $img1 = str_replace(array("\r\n", "\r", "\n"), "", $img);

    			$fff = array();
                $fff['content']['name'] = $leader_info[0]['name'];
                $fff['fin'] = 1;
                $fff['action'] = "person_add";
                $fff['content']['bdate'] = $tleave_info[0]['begin_date']."至".$tleave_info[0]['end_date'];
                $fff['content']['img'] = $img1;
                $ddd = json_encode($fff);

                $redis = new \Redis();
                $res0 = $redis->connect("192.168.1.234",6379);
                $res1 = $redis->publish("face_door",$ddd);
                if($res && $res1)
                {
                	$tleave->commit();
                	$return['status']	= 'success';
                	$return['content']	= '操作成功！';
                }
                else
                {
                	$tleave->rollback();
                	$return['status']	= 'failure';
                	$return['content']	= '操作失败！';
                }
    		}
    	}
    	else
    	{
    		$return['status']	= 'failure';
    		$return['content']	= '协议内容错误！';
    	}
    	$this->ajaxReturn($return);
    }

    public function disagreeTeacherLeave()
    {
    	$type = @$_POST['typ'];
    	$return = array();
    	if($type == 'json')
    	{
    		$id = $_POST['id'];
    		if(empty($id))
    		{
    			$return['status']	= 'failure';
    			$return['content']	= '传值错误！';
    		}
    		else
    		{
    			$tleave = new TeacherLeaveModel();
    			$edit_row = array();
    			$edit_row['auditby_note']	= $_POST['reason'];
    			$edit_row['auditby']		= $_COOKIE['auser'];
    			$edit_row['status']			= $_POST['status'];

    			$res = $tleave->editTeacherLeave($id,$edit_row);
    			if($res)
    			{
    				$return['status']	= 'success';
    				$return['content']	= '操作成功！';
    			}
    			else
    			{
    				$return['status']	= 'failure';
    				$return['content']	= '操作失败！';
    			}
    		}
    	}
    	else
    	{
    		$return['status']	= 'failure';
    		$return['content']	= '协议内容错误！';
    	}
    	$this->ajaxReturn($return);
    }
   
}


?>