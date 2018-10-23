<?php
namespace Home\Controller;
use Think\Controller;
use Think\Cache\Driver\Redis;
use Home\Model\ManageModel;
use Home\Model\MenuModel;
use Home\Model\ClassModel;
use Home\Model\StudentModel;
use Home\Model\HostelModel;
use Home\Model\HostelRecordModel;
use Admin\Model\StudentLeaveModel;
use Admin\Model\HostelEntranceRecordModel;
use Admin\Model\LeaderModel;
use Home\Model\MemberModel;
class HostelController extends Controller{
	public function index(){
    	//身份判断
    	if(empty($_COOKIE['user']))
    	{
    		$this->login();
    		die;
    	}
        $menu = new MenuModel();
        $act = @$_GET['id'];
        $res = $this->yanzheng($act);
        if(!$res)
        {
            $this->error('URL有误',header("Location:/cxg"));
        }
        
        // $main_menu = $menu->getMenu(array('parent_id'=>0));
        // $menus = $menu->getMenuTree();
        // $this->assign('main_menu',$main_menu);
        // $this->assign("menu",$menus);

        //身份判断
        if($_COOKIE['type'] == 1)
        {
            // $this->getWarningInfo();
            $this->manage();
        }
        elseif($_COOKIE['type'] == 2)
        {
            $this->teacher();
        }
        elseif($_COOKIE['type'] == 3)
        {
            $this->shitang();
        }
        elseif($_COOKIE['type'] == 4)
        {
            $this->sushe();
        }
        elseif($_COOKIE['type'] == 5)
        {
            $this->menwei();
        }

        $this->assign("typ",$act);
        $type = explode(".",$act)[1];
        switch($type)
        {
            case "31":
            $this->viewLeave();
            break;
            case "49":
            $this->viewAll();
            break;
            case "50":
            $this->hostelRecord();
            break;
            case "56":
            $this->video();
            break;
            default:;
        }
        
    }

    public function login()
    {
    	header("Location:/cxg/index.php");
    }

    //验证路径
    public function yanzheng($type)
    {
        $menu = new MenuModel();
        $a = explode(".",$type)[0];
        $b = explode(".",$type)[1];
        $array1 = $menu->getMenu(array('parent_id'=>$a));
        $array2 = $menu->getMenu(array('id'=>$b));
        $c = array();
        if(!empty($array1))
        {
            foreach($array1 as $k=>$v)
            {
                $c[] = $v['id'];
            }
        }
        else
        {
            return false;
            die;
        }
        $id = $array2[0]['parent_id'];
        if(!in_array($id,$c))
        {
            return false;
            die;
        }
        else
        {
            return true;
            die;
        }
    }

//身份判断
    public function manage()
    {
        $menu = new MenuModel();
        $main_menu = $menu->getMenu(array('parent_id'=>0));
        $menus = $menu->getMenuTree();
        $this->assign('main_menu',$main_menu);
        $this->assign("menu",$menus);
    }

    public function teacher()
    {
        $menu = new MenuModel();
        $main_menu = $menu->getMenu(array('parent_id'=>0));
        $menus = $menu->getMenuTree();
        $shell = array(1,2,3,64);
        foreach($main_menu as $k=>$v)
        {
            if(in_array($v['id'],$shell))
            {

            }
            else
            {
                unset($main_menu[$k]);
            }
        }

        $this->assign('main_menu',$main_menu);
        $this->assign("menu",$menus);
    }
    public function shitang()
    {
        $menu = new MenuModel();
        $main_menu = $menu->getMenu(array('parent_id'=>0));
        $menus = $menu->getMenuTree();
        $shell = array(5,64);
        foreach($main_menu as $k=>$v)
        {
            if(in_array($v['id'],$shell))
            {

            }
            else
            {
                unset($main_menu[$k]);
            }
        }

        $this->assign('main_menu',$main_menu);
        $this->assign("menu",$menus);
    }

    public function sushe()
    {
        $menu = new MenuModel();
        $main_menu = $menu->getMenu(array('parent_id'=>0));
        $menus = $menu->getMenuTree();
        $shell = array(2,64);
        foreach($main_menu as $k=>$v)
        {
            if(in_array($v['id'],$shell))
            {

            }
            else
            {
                unset($main_menu[$k]);
            }
        }

        $this->assign('main_menu',$main_menu);
        $this->assign("menu",$menus);
    }

    public function menwei()
    {
        $menu = new MenuModel();
        $main_menu = $menu->getMenu(array('parent_id'=>0));
        $menus = $menu->getMenuTree();
        $shell = array(4,64);
        foreach($main_menu as $k=>$v)
        {
            if(in_array($v['id'],$shell))
            {

            }
            else
            {
                unset($main_menu[$k]);
            }
        }

        $this->assign('main_menu',$main_menu);
        $this->assign("menu",$menus);
    }

//===============================================================================================
    //人员管理
    public function editPass()
    {
    	$type = @$_POST['typ'];
    	if($type == 'json')
    	{
    		$new = $_POST['new_pass'];
    		$user = $_COOKIE['user'];
    		$manage = new ManageModel();
    		$info = $manage->getManage(array('nick'=>$user));
    		$info = array_values($info);
    		$id = $info[0]['id'];
    		$cond = array();
    		$cond['password'] = md5($new);
    		$res = $manage->editManage($id,$cond);
    		$return = array();
    		if($res)
    		{
    			setcookie('user','',time()-3600,"/");
				setcookie('type','',time()-3600,"/");
    			$return['status']	= 'success';
    			$return['content']	= '修改成功，请重新登录！';
    		}
    		else
    		{
    			$return['status']	= 'failure';
    			$return['content']	= '修改失败！';
    		}
    		$this->ajaxReturn($return);
    	}
    	else
    	{
    		$this->display('editPass');
    	}
    }


    public function checkPass()
    {
    	$type = @$_POST['typ'];
    	$return = array();
    	if($type == 'json')
    	{
    		$old = $_POST['old'];
    		$user = $_COOKIE['user'];
    		$manage = new ManageModel();
    		$info = $manage->getManage(array('nick'=>$user));
    		$info = array_values($info);
    		$pass = $info[0]['password'];
    		if($pass == md5($old))
    		{
    			$return['status']	= 'success';
    			$return['content']	= '';
    		}
    		else
    		{
    			$return['status']	= 'failure';
    			$return['content']	= '旧密码不正确，请重新输入！';
    		}

    	}
    	else
    	{
    		$return['status']	= 'failure';
    		$return['content']	= '协议内容有误！';
    	}
    	$this->ajaxReturn($return);
    }

//=========================================================================================================================
    //请假记录
    public function viewLeave()
    {
        $this->display('leaveRecord');
    }

    public function leaveRecord()
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

            //查看所管理的楼
            $member = new MemberModel();
            $id = $_COOKIE['id'];
            $member_info = $member->getMember(array("id"=>$id));
            $hostel_id = $member_info[0]['hostel_id']; //hostel_id  是楼房的名子，并非是楼房的ID
            $hostel = new HostelModel();
            $hostel_list = $hostel->getHostel(array('build'=>$hostel_id));//根据楼房名查出所有的房间信息
            $hids = array();
            foreach($hostel_list as $a=>$b)
            {
                $hids[] = $b['id']; //将本楼房里面的所有房间ID取出来
            }

            $uids = array();//所在住在这个楼里面的学生ID
            //将所有学生进行筛选   将所在宿舍并不是这个楼里面的学生除去
            foreach($student_list as $q=>$w)
            {
                if(!in_array($w['dormitory_id'],$hids))
                {
                    unset($student_list[$q]);
                }
                else
                {
                    $uids[] = $w['id'];
                }
            }
            $cond['student_id'] = array("IN",$uids);


            if(!empty($_POST['uname']))
            {
                $uname = $_POST['uname'];
                $student_info = $student->getStudent(array('name'=>$uname));
                $ids = array();
                if(!empty($student_info))
                {
                    foreach($student_info as $kk=>$vv)
                    {
                        $ids[] = $vv['id'];
                    }

                }
                $news = array_intersect($uids,$ids);
                $cond['student_id']  = array('IN',$news);
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

            if($_POST['status'] == 10)
            {
                $cond['status'] = array('gt',0);
            }
            elseif(!empty($_POST['status']))
            {
                $cond['status'] = $_POST['status'];
            }
            else
            {
                $cond['status'] = array("IN",array(5,6));
            }

            $status = array(
                1=>'待提交',
                3=>'待签收',
                4=>'待批准',
                5=>'已批准',
                6=>'已完成',
                7=>'已退回'
            );
            $leave = new StudentLeaveModel();
            $leave_list = $leave->getStudentLeave($cond,array('id'=>'desc'));
            if(!empty($leave_list))
            {
                foreach($leave_list as $key=>$val)
                {
                    $leave_list[$key]['status_text'] = $status[$val['status']];
                    $leave_list[$key]['student_text'] = $student_list[$val['student_id']]['name'];
                    $leave_list[$key]['class_text'] = $student_list[$val['student_id']]['class_text'];
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
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

//=========================================================================================================================
    //宿舍管理
    public function viewAll()
    {
        $hostel = new HostelModel();
        $hostel_list = $hostel->getHostelList();
        $this->assign('hostel',$hostel_list);
        $build = $_POST['build'];
        if(!empty($build))
        {
        	$this->assign("bb",$build);
            $cond = array();
            $cond['build'] = $build;
            $order = array();
            $order['floor'] = "DESC";
            $order['no'] = "ASC";
            $hostel_listss = $hostel->getHostel($cond,$order);
            $hostel_lists = array();
            foreach($hostel_listss as $aaa=>$bbb)
            {
            	$hostel_lists[$bbb['id']] = $bbb;
            }

            // echo "<pre>";
            // var_dump($hostel_lists);

            //将宿舍的ID整出来
            $hostel_ids = array();
            foreach($hostel_lists as $k=>$v)
            {
            	//回舍情况   人数归0
            	$hostel_lists[$k]['in_num'] = 0;
            	$hostel_lists[$k]['out_num'] = 0;
            	$hostel_ids[] = $v['id'];
            }
            // var_dump($hostel_ids);

            //将这些宿舍里面的学生信息提取出来
            $student = new StudentModel();
            $cond_stu = array();
            $cond_stu['dormitory_id'] = array('IN',$hostel_ids);
            $student_list = $student->getStudent($cond_stu);

            //将学生ID提取出来
            $student_ids = array();
            foreach($student_list as $kk=>$vv)
            {
            	$student_ids[] = $vv['id'];
            }

            //将今天回舍的并为该宿舍的整合到一起
            $hostel_record = new HostelEntranceRecordModel();
            $cond_hostel = array();
            $order_hostel = array();
            $cond_hostel['alarm_id'] = array("IN",$student_ids);
            $tt = date("Y-m-d 00:00:00",time()-3600*24);
            $cond_hostel['alarm_time'] = array("gt",$tt);
            $con_hostel['ptype'] = 's';
            $order_hostel['id'] = "DESC";
            $hostel_record_list = $hostel_record->getHostelEntranceRecord($cond_hostel,$order_hostel,1,50000);
            //去重   获取最后的一条数据
            $new_record_list = array();
            $act_ids = array();  //判断的数组
            foreach($hostel_record_list as $kkk=>$vvv)
            {
            	if(!in_array($vvv['alarm_id'],$act_ids))
            	{
            		$act_ids[] = $vvv['alarm_id'];
            		$new_record_list[$vvv['alarm_id']] = $vvv;
            	}
            }
            // var_dump($new_record_list);

            //将学生的回舍信息整合的学生信息里面
            foreach($student_list as $kkkk=>$vvvv)
            {
            	$sid = $vvvv['id'];
            	if(!empty($new_record_list[$sid]) && $new_record_list[$sid]['type']=='in')
            	{
            		$student_list[$kkkk]['inout'] = 'in';
            	}
            	else
            	{
            		$student_list[$kkkk]['inout'] = 'out';
            	}
            }
            // var_dump($student_list);

            //将学生分配到宿舍。 并记下出回来的数目
            foreach($student_list as $key=>$val)
            {
            	if($val['inout'] == 'in')
            	{
            		$hostel_lists[$val['dormitory_id']]['in_num'] += 1;
            	}
            	else
            	{
            		$hostel_lists[$val['dormitory_id']]['out_num'] += 1;
            	}
            }
             // var_dump($hostel_lists);

           	//将宿舍按楼层分组
           	$final_arr = array();
           	foreach($hostel_lists as $keys=>$vals)
           	{
           		$final_arr[$vals['floor']][] = $vals;
           	}

            // var_dump($final_arr);
            $this->assign("hostel_list",$final_arr);
            
        }
        $this->display('viewHostel');
    }

    public function hostelRecord()
    {
       //班级列表信息
    	$class = new ClassModel();
    	$class_list = $class->getAssocClass();
    	$this->assign("clist",$class_list);
    	//楼号列表
    	$hostel = new HostelModel();
        $hostel_list = $hostel->getHostelList();
        $this->assign('hostel',$hostel_list);

    	//首先是根据条件来获取学生信息
    	$stu_cond = array();
    	if(!empty($_POST['croom']))
    	{
    		$this->assign("aa",$_POST['croom']);
    		$stu_cond['class_id'] = $_POST['croom'];
    	}
    	if(!empty($_POST['sbuild']) || !empty($_GET['sbuild']))
    	{
    		$sbuild = !empty($_POST['sbuild']) ? $_POST['sbuild']:$_GET['sbuild'];
    		$this->assign("bb",$sbuild);
    		$hostel_info = $hostel->getHostel(array("build"=>$sbuild));
    		$hostel_ids = array();
    		foreach($hostel_info as $k=>$v)
    		{
    			$hostel_ids[] = $v['id'];
    		}
    		$stu_cond['dormitory_id'] = array("IN",$hostel_ids);
    	}
    	if(!empty($_GET['shostel']))
    	{
    		$stu_cond['dormitory_id'] = $_GET['shostel'];
    	}
    	if(!empty($_POST['cname']))
    	{
    		$this->assign("cc",$_POST['cname']);
    		$stu_cond['name'] = $_POST['cname'];
    	}
    	//获取符合条件的学生信息
    	$stu_order = array();    //学生信息排序，   班级   宿舍
    	$stu_order['class_id'] = "ASC";
    	$stu_order['dormitory_id'] = "ASC";
    	$student = new StudentModel();
    	$student_list = $student->getStudent($stu_cond,$stu_order,1,500);
    	// echo "<pre>";
    	// var_dump($student_list);
    	$student_ids = array();
    	foreach($student_list as $kk=>$vv)
    	{
    		$student_ids[] = $vv['id'];
    	}

    	//获取回舍信息
    	$hostel_cond = array();
    	$hostel_cond['alarm_id'] = array("IN",$student_ids);
    	$hostel_cond['ptype'] = 's';
    	if(empty($_POST['stime']))
    	{
    		$tt = date("Y-m-d 00:00:00",time());
    		$hostel_cond['alarm_time'] = array("gt",$tt);
    		$this->assign("dd",$tt);
    	}
    	else
    	{
    		$hostel_cond['alarm_time'] = array("gt",$_POST['stime']);
    		$this->assign("dd",$_POST['stime']);
    	}
    	if(!empty($_POST['etime']))
    	{
    		$hostel_cond['alarm_time'] = array(array('egt',$_POST['stime']),array('elt',$_POST['etime']),'AND');
    		$this->assign("ee",$_POST['etime']);
    	}
    	$hostel_record = new HostelEntranceRecordModel();
    	$hostel_record_list = $hostel_record->getHostelEntranceRecord($hostel_cond,array("id"=>"DESC"),1,10000);
    	//去掉重复的数据
    	$new_record_list = array();
    	$true_ids = array();
        $new_student_list;
        $type_array = array("in"=>"进入宿舍","out"=>"离开宿舍");
        if(empty($_POST['cname']))
        {
            foreach($hostel_record_list as $kkk=>$vvv)
            {
                if(!in_array($vvv['alarm_id'],$true_ids))
                {
                    $new_record_list[$vvv['alarm_id']] = $vvv;
                    $true_ids[] = $vvv['alarm_id'];
                }
            }

            foreach($student_list as $key=>$val)
            {
                $new_student_list[$key]['class_text'] = $class_list[$val['class_id']]['name'];
                $new_student_list[$key]['photo'] = '';
                $new_student_list[$key]['name'] = $val['name'];
                $new_student_list[$key]['id'] = $val['id'];
                if(!empty($new_record_list[$val['id']]))
                {
                    $new_student_list[$key]['time_text'] = $new_record_list[$val['id']]['alarm_time'];
                    $ff = $new_record_list[$val['id']]['type'];
                    $new_student_list[$key]['type_text'] = $type_array[$ff];
                }
                else
                {
                    $new_student_list[$key]['time_text'] = '无';
                    $new_student_list[$key]['type_text'] = '此时间段内暂无通行记录！';
                }
            }
        }
        else
        {
            $new_record_list = $hostel_record_list;
            $cid = $student_list[0]['class_id'];
            
            if(!empty($new_record_list))
            {
                foreach($new_record_list as $key=>$val)
                {
                    $new_student_list[$key]['id'] = $val['id'];
                    $new_student_list[$key]['name'] = $student_list[0]['name'];
                    $new_student_list[$key]['class_text'] = $class_list[$cid]['name'];
                    $new_student_list[$key]['photo'] = '';
                    $new_student_list[$key]['time_text'] = $val['alarm_time'];
                    $ff = $val['type'];
                    $new_student_list[$key]['type_text'] = $type_array[$ff];
                }
            }
            else
            {
                $new_student_list[0]['id'] = $student_list[0]['id'];
                $new_student_list[0]['name'] = $student_list[0]['name'];
                $new_student_list[0]['class_text'] = $class_list[$cid]['name'];
                $new_student_list[0]['photo'] = '';
                $new_student_list[0]['time_text'] = '无';
                $new_student_list[0]['type_text'] = '此时间段内暂无通行记录！';
            }
        }
        	
    	// var_dump($new_record_list);
        // echo "<pre>";
    	//将学生数据和回舍信息整合到一起
    	
        	
    	// var_dump($new_student_list);die;
    	$this->assign("student_list",$new_student_list);
        $this->display('hostelRecord');
    }

    public function getOneHostelInfo()
    {
    	$class = new ClassModel();
        $class_list = $class->getAssocClass();
    	$hostel_id = $_POST['hostel_id'];
    	$student = new StudentModel();
        $stu_list = $student->getStudent(array('hostel'=>$hostel_id));
        //总共的ID
        $ids = array();
        foreach($stu_list as $k=>$v)
        {
        	$ids[] = $v['id'];
        }

        $time = date("Y-m-d 00:00:00",time());
        $hostel = new HostelRecordModel();
        $str1 = 1;
        if(!empty($ids))
        {
        	$id_row = implode(",",$ids);
        	$str1 .= " AND stu_id in (".$id_row.")";
        }
        $str1 .= "AND time>'".$time."'";
        $hostel_list = $hostel->getHostelRecord($str1,array('time'=>"DESC"));
        $stu_lists = $student->getAssocStudent();
        $hhh = new HostelModel();
        $hhh_list = $hhh->getAssocHostel();
        $isid = array();
        foreach($hostel_list as $k=>$v)
        {
        	$hostel_list[$k]['stu_name'] = $stu_lists[$v['stu_id']]['name'];
        	$cid = $stu_lists[$v['stu_id']]['class'];
        	$hostel_list[$k]['stu_class'] = $class_list[$cid]['name'];
            $hid = $stu_lists[$v['stu_id']]['hostel'];
            $hostel_list[$k]['hostel_text'] = $hhh_list[$hid]['name'];
        	if($v['type'] == "in")
        	{
        		$hostel_list[$k]['type_text'] = "进入宿舍";
        	}
        	else
        	{
        		$hostel_list[$k]['type_text'] = "离开宿舍";
        	}
        	if(!in_array($v['stu_id'],$isid))
        	{
        		$isid[] = $v['stu_id'];
        	}
        }
        $disid = array_diff($ids,$isid);
        $str2 = 1;
        if(!empty($disid))
        {
        	$dis_row = implode(",",$disid);
        	$str2 .= " AND id in (".$dis_row.")";
        	$dis_list = $student->getStudent($str2);
        	foreach($dis_list as $k=>$v)
        	{
        		$dis_list[$k]['id'] = '无';
        		$dis_list[$k]['stu_name'] = $v['name'];
        		$dis_list[$k]['stu_class'] = $class_list[$v['class']]['name'];
                $dis_list[$k]['hostel_text'] = $hhh_list[$v['hostel']]['name'];
        		$dis_list[$k]['time'] = '无';
        		$dis_list[$k]['type_text'] = '未归';
        	}
        	$this->assign('dlist',$dis_list);

        }
        $this->assign('hostel',$hostel_list);
        $this->display('hostelRecord');

    }

    public function video()
    {
        $hostel_record = new HostelEntranceRecordModel();
        $student = new StudentModel();
        $class = new ClassModel();
        $class_list = $class->getAssocClass();
        $hostel_record_list = $hostel_record->getHostelEntranceRecord(array('ptype'=>'s'),array("id"=>"DESC"),1,8);
        //获取学生ID
        $student_ids = array();
        foreach($hostel_record_list as $k=>$v)
        {
            if(!in_array($v['alarm_id'],$student_ids))
            {
                $student_ids[] = $v['alarm_id'];
            }
        }
        $stu_cond = array();
        $stu_cond['id'] = array("IN",$student_ids);
        $student_list = $student->getStudent($stu_cond);
        $new_student_list = array();
        foreach($student_list as $kkk=>$vvv)
        {
            $new_student_list[$vvv['id']] = $vvv;
            $new_student_list[$vvv['id']]['class_text'] = $class_list[$vvv['class_id']]['name'];
        }
        // echo "<pre>";
        $type_array = array("in"=>"进入宿舍","out"=>"离开宿舍");
        //将学生姓名，班级添加到记录表
        foreach($hostel_record_list as $kkkk=>$vvvv)
        {
            $hostel_record_list[$kkkk]['class_text'] = $new_student_list[$vvvv['alarm_id']]['class_text'];
            $hostel_record_list[$kkkk]['name_text'] = $new_student_list[$vvvv['alarm_id']]['name'];
            $hostel_record_list[$kkkk]['photo_text'] = $new_student_list[$vvvv['alarm_id']]['photo'];
            $hostel_record_list[$kkkk]['inout'] = $type_array[$vvvv['type']];
        }
        //获取记录的ID，更新数据库
        $this->updateHostelRecord();
        $this->assign("record_list",$hostel_record_list);
        $this->display("video");
    }

    //清空redis里的宿舍信息
    public function unsetHostelEntranceRedis()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $redis = new \Redis();
            $res = $redis->connect("127.0.0.1",6379);
            $redis->set("hostelInfo","");
            if($res)
            {
                $return['status']	= 'success';
                $return['content']	= '成功！';
            }
            else
            {
            	$return['status']	= 'failure';
            	$return['content']	= '失败！';
            }
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }


    //获取新得到的数据
    public function getNewHostelInfo()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
        	$startTime = time();
        	$redis = new \Redis();
		    $redis->connect("127.0.0.1",6379);
		    $redis->setOption(\Redis::OPT_READ_TIMEOUT, -1);
        	while(true)
        	{
        		$time = time();
        		$tt = $time-$startTime;
        		if($tt <= 30)
        		{
		            $res = $redis->get("hostelInfo");
		            $info = json_decode($res);
		            $id = $info->id;
		            $inout = $info->inout;
                    $ptype = $info->ptype;
		            $inout_array = array("in"=>"进入宿舍","out"=>"离开宿舍");

                    //区分是教师还是学生
                    if($ptype == 't')
                    {
                        $leader = new LeaderModel();
                        $leader_info = $leader->getLeader(array("id"=>$id));
                        $new_array = array();
                        $new_array['name_text'] = $leader_info[0]['name'];
                        $new_array['inout'] = $inout_array[$inout];
                        $new_array['alarm_time'] = date("Y-m-d H:i:s",time());
                        $new_array['class_text'] = '教师';
                        $new_array['photo_text'] = $leader_info[0]['photo'];
                    }
                    else
                    {
                        $class = new ClassModel();
                        $student = new StudentModel();
                        $class_list = $class->getAssocClass();
                        $student_info = $student->getStudent(array("id"=>$id));
                        $class_id = $student_info[0]['class_id'];

                        $new_array = array();
                        $new_array['name_text'] = $student_info[0]['name'];
                        $new_array['inout'] = $inout_array[$inout];
                        $new_array['alarm_time'] = date("Y-m-d H:i:s",time());
                        $new_array['class_text'] = $class_list[$class_id]['name'];
                        $new_array['photo_text'] = $student_info[0]['photo'];
                    }
    		            

		            //获取新的信息

		            if(!empty($res))
		            {
		            	if(!empty($new_array['name_text']))
		            	{
		            		$return['status']   = 'success';
			                $return['content']  = $new_array;
			                $redis->set("hostelInfo","");
			                $this->ajaxReturn($return);
			                die;
		            	}
		            	else
		            	{
		            		$return['status']   = 'failure';
                            $return['content']  = 'no_person';
		            		$this->ajaxReturn($return);
		            		die;
			            } 
		            }
		            	
        		}
        		else
        		{
        			$return['status']	= 'failure';
        			$return['content']	= 'TimeOut';
        			$this->ajaxReturn($return);
        			die;
        		}
	        		
        	}
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
            $this->ajaxReturn($return);
        }
        
    }

    //将数据库的最新数据更改为已读
    public function updateHostelRecord($record_id = array())
    {
        $hostel_record = new HostelEntranceRecordModel();
        $cond = array();
        $cond['record_type'] = 'old';
        if(!empty($record_id))
        {
            foreach($record_id as $key=>$val)
            {
                $hostel_record->editHostelEntranceRecord($val,$cond);
            }
        }
        else
        {
            $w = array();
            $w['id'] = array("egt",1);
            M('HostelEntranceRecord')->where($w)->setField('record_type','old');
        }
    }


    //
    public function getInfo()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['id'];
            $stu = new StudentModel();
            $cond = array();
            $cond['id'] = $id;
            $stu_info = $stu->getStudent($cond);
            if(!empty($stu_info))
            {
                $class = new ClassModel();
                $cond_row = array();
                $cond_row['id'] = $stu_info[0]['class'];
                $class_info = $class->getClass($cond_row);
                $stu_info[0]['class'] = $class_info[0]['name']."班";
                $stu_info[0]['datetime'] = date("Y-m-d H:i:s",time());
                $stu_info[0]['img'] = "http://192.168.1.120/cxg/Public/images/1.jpg";
                $return['status']   = 'success';
                $return['content']  = $stu_info;
            }
            else
            {
                $return['status']   = 'failure';
                $return['content']  = '信息有误！';
            }
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

    //curl请求
    public function curl_request($url,$post='',$cookie='', $returnCookie=0){
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

}



?>