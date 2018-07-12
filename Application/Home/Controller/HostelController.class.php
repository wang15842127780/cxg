<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\ManageModel;
use Home\Model\MenuModel;
use Home\Model\ClassModel;
use Home\Model\StudentModel;
use Home\Model\HostelModel;
use Home\Model\HostelRecordModel;
use Admin\Model\StudentLeaveModel;
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
            $cond = array();
            $cond['build'] = $build;
            $lists = $hostel->getAssocHostel($cond,array('name'=>"ASC"));
            $record = new HostelRecordModel();
            $cond = array();
            $cond['time'] = array("gt",date("Y-m-d 00:00:00",time()));
            $record_list = $record->getHostelRecord($cond,array('time'=>"DESC"));
            //去除重复记录
            $new = array();
            $new_id = array();
            foreach($record_list as $k=>$v)
            {
                if(!in_array($v['stu_id'],$new_id))
                {
                    $new[$v['stu_id']] = $v;
                    $new_id[] = $v['stu_id'];
                }
            }
            $student = new StudentModel();
            $stu_list = $student->getAssocStudent();
            //根据学生记录查找学生宿舍，有就加1
            foreach($new as $k=>$v)
            {
                if($v['type'] == "in")
                {
                    $hid = $stu_list[$v['stu_id']]['hostel'];
                    $lists[$hid]['count'] += 1;
                }
            }
            // echo "<pre>";
            // var_dump($lists);
            $shell = array();
            for($i=1;$i<=9;$i++)
            {
                $shell[] = $i;
            }

            foreach($lists as $k=>$v)
            {
                $n = (int)$v['name'];
                if(in_array($n,$shell))
                {
                    $list['l'.$n][] = $v;
                }
            }
            $this->assign("bb",$build);
            $this->assign('state',$build.'号楼');
            $this->assign('hlist',$list);
        }
        $this->display('viewHostel');
    }

    public function hostelRecord()
    {
        $class = new ClassModel();
        $class_list = $class->getAssocClass();
        $this->assign('clist',$class_list);
        $cond = array();
        $str = 1;
        $hostel_id = $_POST['hostel_id'];
        if(!empty($hostel_id))
        {
        	// $str .= " AND hostel=".$hostel_id;
        	$this->getOneHostelInfo();
        	die;
        }
        $croom = $_POST['croom'];
        if($croom != 0)
        {
            $str .= " AND class=".$croom;
        }
        

        $cname = $_POST['cname'];
        if(!empty($cname))
        {
        	$str .= " AND name like '%".$cname."%'";
        }
        $student = new StudentModel();
        $stu_list = $student->getStudent($str);
        $ids = array();
        foreach($stu_list as $k=>$v)
        {
        	$ids[] = $v['id'];
        }

        $str1 = 1;
        $stime = $_POST['stime'] ? $_POST['stime'] : date("Y-m-d 00:00:00",time());
        if(!empty($stime))
        {
            $str1 .= " AND time>'".$stime."'";
        }
        $etime = $_POST['etime'];
        if(!empty($etime))
        {
            $str1 .= " AND time<'".$etime."'";
        }
        if(!empty($ids))
        {
        	$id_row = implode(",",$ids);
        	$str1 .= " AND stu_id in (".$id_row.")";
        }
        else
        {
        	$str1 .= "AND stu_id='0'";
        }
        $hostel = new HostelRecordModel();
        $hostel_list = $hostel->getHostelRecord($str1,array('time'=>'DESC'));
        $hhh = new HostelModel();
        $hhh_list = $hhh->getAssocHostel();
        $stu_lists = $student->getAssocStudent();
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
        }
        // echo "<pre>";
        // var_dump($hostel_list);

        
       
        $this->assign('hostel',$hostel_list);
        $this->assign('croom',$_POST['croom']);
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
        $this->display("video");
    }

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


}
?>