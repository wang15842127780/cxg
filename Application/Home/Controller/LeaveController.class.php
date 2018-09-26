<?php
namespace Home\Controller;
use Think\Controller;
use Think\Cache\Driver\Redis;
use Home\Model\MenuModel;
use Home\Model\ClassModel;
use Home\Model\NightDetailModel;
use Home\Model\StudentModel;
use Home\Model\NightRecordModel;
use Home\Model\SubjectModel;
use Home\Model\MemberModel;
use Home\Model\ManageModel;
use Home\Model\StudentLeaveModel;
use Home\Model\TeacherLeaveModel;
use Admin\Model\ConfigModel;
use Admin\Model\ClassYearModel;
use Admin\Model\LeaderModel;
require("/home/wwwroot/cxg/Public/broadMessage.php");


class LeaveController extends Controller{
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
            case "66":
            $this->myself();
            break;
            case "67":
            $this->stuRecord();
            break;
            case "68";
            $this->addMyLeave();
            break;
            case "69":
            $this->addStu();
            break;
            case "72":
            $this->editStu();
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



//============================================================================================================
    //学生记录
    public function stuRecord()
    {
        //权限判断
        //先判断是不是后台人员
        $cond = array();
        $type = $_COOKIE['type'];
        $year = new ClassYearModel();
        if($type == 1 || $type==2)
        {
            //后台人员  判断是不是年级主任
            //1、根据id查用户名
            $id = $_COOKIE['id'];
            $member = new MemberModel();
            $member_info = $member->getMember(array('id'=>$id));
            $user_name = $member_info[0]['name'];
            //2、根据用户名查找后台id
            $manage = new ManageModel();
            $manage_info = $manage->getManage(array('name'=>$user_name));
            $year_list = $year->getClassYear();
            $this->assign('yearList',$year_list);
            $this->assign('userType',1);
            $this->assign('yearLists',json_encode($year_list));
        }
        else
        {
            $this->assign('userType',3);
        }
        if(!empty($_POST['year']))
        {
            $cond['year_id'] = $_POST['year'];
        }
        if(!empty($_POST['uname']))
        {
            $uname = $_POST['uname'];
            $student = new StudentModel();
            $student_list = $student->getStudent(array('name'=>$uname));
            $ids = array();
            foreach($student_list as $kk=>$vv)
            {
                $ids[] = $vv['id'];
            }
            $cond['student_id'] = array('IN',$ids);
        }
        if(!empty($_POST['stime']))
        {
            $cond['begin_date'] = array('gt',$_POST['stime']);
        }
        if(!empty($_POST['etime']))
        {
            $cond['end_date'] = array('lt',$_POST['etime']);
        }
        $cond['status'] = 5;
        $status = array(
            "1"=>'<a href="javascript:void(0);" class="commit">待提交</a>',
            "3"=>"已提交",
            "4"=>"待审核",
            "5"=>"已批准",
            "6"=>"完成",
            "7"=>"已拒绝"
        );
        $typ = @$_POST['typ'];
        if($typ == 'json')
        {
            $leave = new StudentLeaveModel();
            $leave_list = $leave->getStudentLeave($cond,array('id'=>"desc"));
            $student = new StudentModel();
            $student_list = $student->getAssocStudent();
            $class = new ClassModel();
            $class_list = $class->getAssocClass();
            foreach($student_list as $k=>$v)
            {
                $student_list[$k]['class_text'] = $class_list[$v['class_id']]['name'];
            }
            if(!empty($leave_list))
            {
                foreach($leave_list as $key=>$val)
                {
                    $leave_list[$key]['status_text'] = $status[$val['status']];
                    $leave_list[$key]['student_text'] = $student_list[$val['student_id']]['name'];
                    $leave_list[$key]['class_text'] = $student_list[$val['student_id']]['class_text'];
                    $leave_list[$key]['detail_text'] = "<a href='javascirpt:void(0);' class='detail'>查看详情</a>";
                    if($val['type']==1)
                    {
                    	$leave_list[$key]['leave_date'] = $val['begins_date']." — ".$val['ends_date']."<br>每天<br>".$val['begins_time']." — ".$val['ends_time'];
                    }
                    else
                    {
                    	$leave_list[$key]['leave_date'] = $val['begin_date']."至".$val['end_date'];
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
            $this->ajaxReturn($return);
        }
        else
        {
            $this->display('stuRecord');
        }
            
    }

    public function addStu()
    {
    	$typ = @$_POST['typ'];
    	if($typ == 'json')
    	{
            //根据学生ID查班主任ID
            $student = new StudentModel();
            $student_info = $student->getStudent(array('id'=>$_POST['student']));
            $class_id = $student_info[0]['class_id'];
            $class = new ClassModel();
            $class_info = $class->getClass(array('id'=>$class_id));
            $class_list = $class->getAssocClass();
            $leader_id = $class_info[0]['leader_id'];
            $leader = new LeaderModel();
            $leader_info = $leader->getLeader(array("id"=>$leader_id));

        	$tt = $_POST['type'];
            if($tt==1)
            {
                $cond = array();
                $cond['student_id'] = $_POST['student'];
                $cond['reason'] = $_POST['reason'];
                $cond['leader'] = $leader_info[0]['name'];
                $cond['begins_date'] = $_POST['begins_date'];
                $cond['ends_date'] = $_POST['ends_date'];
                $cond['begins_time'] = $_POST['begins_time'];
                $cond['ends_time'] = $_POST['ends_time'];
                $cond['director_note'] = $_POST['reason'];
                $cond['year_id'] = $class_info[0]['year_id'];
                $cond['createby'] = $_COOKIE['user'];
                $cond['status'] = $_POST['status'];
                $cond['type'] = 1;
                $cond['auditby'] = $_COOKIE['user'];
                if($_POST['ends_date'] < $_POST['begins_date'])
                {
                    $return['status']   = 'failure';
                    $return['content']  = '结束日期不能小于开始日期！';
                }
                elseif($_POST['begins_time']>=$_POST['ends_time'])
                {
                    $return['status']   = 'failure';
                    $return['content']  = '结束时间不能小于开始时间！';
                }
                else
                {
                    $leave = new StudentLeaveModel();
                    $leave->startTrans();
                    $res = $leave->addStudentLeave($cond);
                    if($res)
                    {
                        //拼接返回的数据
                        $date = $_POST['begins_date']."至".$_POST['ends_date'].'每天'.$_POST['begins_time']."至".$_POST['ends_time'];
                        $sex = array('female','male');
                        $photo = $student_info[0]['photo'];
                        $img = explode(",",$photo)[1];
                        $img1 = str_replace(array("\r\n", "\r", "\n"), "", $img);
                        $a = $student_info[0]['sex'];
                        $cid = $student_info[0]['class_id'];
                        $xingbie = $sex[$a];
                        $person_name = $student_info[0]['name'];
                        $imgs = str_split($img1,32768); // 将图片按照32M分段传
                        $aa = array();
                        $aa['img'] = $imgs;
                        $aa['name'] = $person_name;
                        $aa['sex'] = $xingbie;
                        $aa['len'] = strlen($img1);
                        $aa['dates'] = $date;
                        $aa['classes'] = $class_list[$cid]['name'];

                        $fff = array();
                        $fff['content']['name'] = $person_name;
                        $fff['fin'] = 1;
                        $fff['action'] = "person_add";
                        $fff['content']['classes'] = $class_list[$cid]['name'];
                        $fff['content']['bdate'] = $date;
                        $fff['content']['img'] = $img1;
                        $ddd = json_encode($fff);

                        $config = new ConfigModel();
                        $config_info = $config->getConfig(array("name"=>"host_ip"));
                        $host_ip = $config_info[0]['value'];
                        $redis = new \Redis();
                        $redis->connect($host_ip,6379);
                        $res1 = $redis->publish("face_door",$ddd);
                        if($res1 && $res)
                        {
                            $leave->commit();
                            $return['status']   = 'success';
                            $return['content']  = '创建成功！';
                        }
                        else
                        {
                            $leave->rollBack();
                            $return['status']   = 'failure';
                            $return['content']  = '网络服务错误！';
                        }
                    }
                    else
                    {
                        $return['status']   = 'failure';
                        $return['content']  = '创建失败！';
                    }
                }
            }
            else
            {
                $cond = array();
                $cond['student_id'] = $_POST['student'];
                $cond['reason'] = $_POST['reasons'];
                $cond['leader'] = $leader_info[0]['name'];
                $cond['begin_date'] = $_POST['stime'];
                $cond['end_date'] = $_POST['etime'];
                $cond['director_note'] = $_POST['reason'];
                $cond['year_id'] = $class_info[0]['year_id'];
                $cond['createby'] = $_COOKIE['user'];
                $cond['status'] = $_POST['status'];
                $cond['type'] = 0;
                $cond['auditby'] = $_COOKIE['user'];
                if($_POST['stime'] >= $_POST['etime']){
                    $return['status']   = 'failure';
                    $return['content']  = '结束时间不能小于开始时间！';
                }else{
                    $leave = new StudentLeaveModel();
                    $leave->startTrans();
                    $res = $leave->addStudentLeave($cond);
                    $return = array();
                    if(true)
                    {
                        //拼接返回的数据
                        $date = $_POST['stime'].'至'.$_POST['etime'];
                        $sex = array('female','male');
                        $photo = $student_info[0]['photo'];
                        $img = explode(",",$photo)[1];
                        $img1 = str_replace(array("\r\n", "\r", "\n"), "", $img);
                        $a = $student_info[0]['sex'];
                        $cid = $student_info[0]['class_id'];
                        $xingbie = $sex[$a];
                        $person_name = $student_info[0]['name'];
                        $imgs = str_split($img1,32768); // 将图片按照100M分段传
                        $aa = array();
                        $aa['img'] = $img1;
                        $aa['name'] = $person_name;
                        $aa['sex'] = $xingbie;
                        $aa['len'] = strlen($img1);
                        $aa['dates'] = $date;
                        $aa['classes'] = $class_list[$cid]['name'];

                        $fff = array();
                        $fff['content']['name'] = $person_name;
                        $fff['fin'] = 1;
                        $fff['action'] = "person_add";
                        $fff['content']['classes'] = $class_list[$cid]['name'];
                        $fff['content']['bdate'] = $date;
                        $fff['content']['img'] = $img1;
                        $ddd = json_encode($fff);

                        //redis发送数据
                        // var_dump(111);
                        $config = new ConfigModel();
                        $config_info = $config->getConfig(array("name"=>"host_ip"));
                        $host_ip = $config_info[0]['value'];
                        $redis = new \Redis();
                        $res0 = $redis->connect($host_ip,6379);
                        $res1 = $redis->publish("face_door",$ddd);
                        if($res1 && $res)
                        {
                            $leave->commit();
                            $return['status']   = 'success';
                            $return['content']  = '创建成功！';
                        }
                        else
                        {
                            $leave->rollBack();
                            $return['status']   = 'failure';
                            $return['content']  = '网络服务错误！';
                        }

                            
                    }
                    else
                    {
                        $return['status']   = 'failure';
                        $return['content']  = '创建失败！';
                    }
                }
            }
            $this->ajaxReturn($return);

    	}
    	else
    	{
    		$cond = array();
            $type = $_COOKIE['type'];
            $year = new ClassYearModel();
            if($type == 1)
            {
                //后台人员  判断是不是年级主任
                //1、根据id查用户名
                $year_list = $year->getClassYear();
                $this->assign('yearList',$year_list);
                $this->assign('classId',0);
            }
            elseif($type == 2)
            {
                //查看是否为班主任
                $year_list = $year->getClassYear();
                $this->assign('yearList',$year_list);
                $this->assign('classId',0);
            }
            else
            {
                Header("Location:/cxg/index.php");
            }

            $this->display('addStu');
    	}
    }

    //编辑信息
    public function editStu()
    {
        $type = @$_POST['typ'];
        if($type == 'json')
        {
            $id = $_POST['id'];
            $cond = array();
            if(!empty($_POST['stime']))
            {
                $cond['begin_date'] = $_POST['stime'];
            }
            if(!empty($_POST['etime']))
            {
                $cond['end_date'] = $_POST['etime'];
            }
            $cond['createby'] = $_COOKIE['user'];
            $cond['status'] = $_POST['status'];
            $cond['reason'] = $_POST['reasons'];
            $cond['director_note'] = $_POST['reason'];
            if(empty($id))
            {
                $return['status']   = 'failure';
                $return['content']  = '传值错误！';
            }
            else
            {
                $leave = new StudentLeaveModel();
                $res = $leave->editStudentLeave($id,$cond);
                if($res)
                {
                    $return['status']   = 'success';
                    $return['content']  = '修改成功！';
                }
                else
                {
                    $return['status']   = 'failure';
                    $return['content']  = '修改失败！';
                }
            }

            $this->ajaxReturn($return);
        }
        else
        {
            //请假单id
            $id = $_GET['lid'];
            $leave = new StudentLeaveModel();
            $leave_info = $leave->getStudentLeave(array('id'=>$id));
            if($leave_info[0]['status'] == 1)
            {
                $student = new StudentModel();
                $student_list = $student->getAssocStudent();
                $info = $leave_info[0];
                $info['student_text'] = $student_list[$info['student_id']]['name'];
                $this->assign('info',$info);
                $this->display('editStu');
            }
            else
            {
                Header("Location:/cxg/index.php?m=Home&c=Leave&a=index&id=64.67");
            }
        }
    }

    public function delStu()
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
                $res = $leave->delStudentLeave($id);
                if($res)
                {
                    $return['status']   = 'success';
                    $return['content']  = '删除成功！';
                }
                else
                {
                    $return['status']   = 'failure';
                    $return['content']  = '删除失败！';
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

    //根据年组 获取班级
    public function getClassByYear()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['year'];
            if(empty($id))
            {
                $return['status']   = 'failure';
                $return['content']  = '传值错误！';
            }
            else
            {
                $class = new ClassModel();
                $class_list = $class->getClass(array("year_id"=>$id));
                if(!empty($class_list))
                {
                    $return['status']   = 'success';
                    $return['content']  = $class_list;
                }
                else
                {
                    $return['status']   = 'failure';
                    $return['content']  = '此年组暂时无班级';
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

    //根据班级获取学生
    public function getStudentByClass()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $class_id = $_POST['class'];
            if(empty($class_id))
            {
                $return['status']   = 'failure';
                $return['content']  = '传值错误！';
            }
            else
            {
                $student = new StudentModel();
                $student_list = $student->getStudent(array('class_id'=>$class_id),array(),1,100,false);
                if(!empty($student_list))
                {
                    $return['status']   = 'success';
                    $return['content']  = $student_list;
                }
                else
                {
                    $return['status']   = 'failure';
                    $return['content']  = '此班级暂时无学生！';
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

    //根据年级获取年级主任的ID
    public function getDirectorByYearId($year_id)
    {
        $year = new ClassYearModel();
        $year_info = $year->getClassYear(array("id"=>$year_id));
        $director_id = $year_info[0]['director_id'];
        $manage = new ManageModel();
        $manage_info = $manage->getManage(array('id'=>$director_id));
        $name = $manage_info[0]['name'];
        $member = new MemberModel();
        $member_info = $member->getMember(array('name'=>$name));
        return $member_info[0]['id'];
    }

//===========================================================================================================================
    //提交功能
    public function commitLeave()
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
                $cond['status'] = 3;
                $res = $leave->editStudentLeave($id,$cond);
                if($res)
                {
                    $return['status']   = 'success';
                    $return['content']  = '已提交给主任！';
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
                    1=>"待提交",
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
                    if($info['type']==1)
                    {
                    	$info['leave_date'] = $info['begins_date']." — ".$info['ends_date']."<br>每天<br>".$info['begins_time']." — ".$info['ends_time'];
                    }
                    else
                    {
                    	$info['leave_date'] = $info['begin_date']."<br>至<br>".$info['end_date'];
                    }
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

    //===================================================
    //本人请假（教师请教部分）
    public function myself()
    {
    	$user_type = $_COOKIE['type'];
    	$this->assign("user_type",$user_type);
    	$this->display("myself");
    }

    public function getMyselfLeaveRecord()
    {
    	$type = @$_POST['typ'];
    	$return = array();
    	if($type == 'json')
    	{
    		$tleave = new TeacherLeaveModel();
    		$tcond = array();
    		$user_type = $_COOKIE['type']; //1为后台人员
    		$mid = $_COOKIE['id'];
    		if($user_type != 1)
    		{
    			$tcond['teacher_id'] = $this->getLidByMid($mid);
    		}
    		$tleave_list = $tleave->getTeacherLeave($tcond,array("id"=>"DESC"));

    		$leader = new LeaderModel();
    		$leader_list = $leader->getAssocList();

    		$status_array = array(
    				"1"=>"待提交",
    				"3"=>"待签收",
    				"4"=>"待审核",
    				"5"=>"<span style='color:green;'>已通过</span>",
    				"7"=>"<span style='color:red'>已退回</span>"
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
    			$return['status']	= 'success';
    			$return['content']	= $tleave_list;
    		}
    		else
    		{
    			$return['status']	= 'failure';
    			$return['content']	= '暂无数据！';
    		}
    	}
    	else
    	{
    		$return['status']	= 'failure';
    		$return['content']	= '协议内容错误！';
    	}
    	$this->ajaxReturn($return);
    }

    public function addMyLeave()
    {
    	$this->display("addMyLeave");
    }
    public function addMyselfLeave()
    {
    	$type = @$_POST['typ'];
    	$return = array();
    	if($type == 'json')
    	{
    		$mid = $_COOKIE['id'];
    		$add_row = array();
    		$add_row['teacher_id']	= $this->getLidByMid($mid);
    		$add_row['begin_date']	= $_POST['stime'];
    		$add_row['end_date']	= $_POST['etime'];
    		$add_row['reason']		= $_POST['reason'];
    		$add_row['status']		= 4;
    		$tleave = new TeacherLeaveModel();
    		$res = $tleave->addTeacherLeave($add_row);
    		if($res)
    		{
    			$return['status']	= 'success';
    			$return['content']	= '创建成功！';
    		}
    		else
    		{
    			$return['status']	= 'failure';
    			$return['content']	= '创建失败！';
    		}
    	}
    	else
    	{
    		$return['status']	= 'failure';
    		$return['content']	= '协议内容错误！';
    	}
    	$this->ajaxReturn($return);
    }

    //根据member_id获取leader_id
    public function getLidByMid($id)
    {
        $member = new MemberModel();
        $leader = new LeaderModel();
        $member_info = $member->getMember(array("id"=>$id));
        $uname = $member_info[0]['name'];
        $leader_info = $leader->getLeader(array("uname"=>$uname));
        $lid = $leader_info[0]['id'];
        return $lid;
    }

}
?>
