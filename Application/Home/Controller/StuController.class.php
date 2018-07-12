<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\ManageModel;
use Home\Model\MenuModel;
use Home\Model\ClassModel;
use Home\Model\AttendDetailModel;
use Home\Model\AttendRecordModel;
use Home\Model\StudentModel;
use Home\Model\SubjectModel;
use Admin\Model\ClassYearModel;

class StuController extends Controller{
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
            case "43":
            $this->stuAttend();
            break;
            case "44":
            $this->stuAttendDetail();
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
                $return['status']   = 'success';
                $return['content']  = '修改成功，请重新登录！';
            }
            else
            {
                $return['status']   = 'failure';
                $return['content']  = '修改失败！';
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
                $return['status']   = 'success';
                $return['content']  = '';
            }
            else
            {
                $return['status']   = 'failure';
                $return['content']  = '旧密码不正确，请重新输入！';
            }

        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

    public function stuAttend()
    {
        $class = new ClassModel();
        $list = $class->getAssocClass();
        $attend = new AttendDetailModel();
        $cond = array();
        $time = date("Y-m-d 00:00:00",time());
        $cond['time'] = array("gt",$time);
        $cond['type'] = 3;
        $attend_list = $attend->getAttendDetail($cond);

        $year = new ClassYearModel();
        $year_list = $year->getClassYear(array(),array('name'=>"asc"));
        $years = array();
        foreach($year_list as $kk=>$vv)
        {
        	$years[$vv['id']] = $vv;
        }
        foreach($attend_list as $k=>$v)
        {
            $list[$v['room']]['count'] += 1;
        }
        // var_dump($time);
        $lists = array();
        foreach($list as $k=>$v)
        {
        	$years[$v['year_id']]['sub'][] = $list[$k];
        }
        array_multisort($years);
        $this->assign('class',$years);
        $this->display('stuAttend');
    }

    public function getAttendRecord()
    {
    	$type = @$_POST['typ'];
    	$return = array();
    	if($type == 'json')
    	{
    		$time = date('Y-m-d');
    		$cond = array();
    		$cond['date'] = $time;
    		$cond['room'] = $_POST['croom'];
    		$record = new AttendRecordModel();
    		$record_list = $record->getAttendRecord($cond);
    		if(!empty($record_list))
    		{
    			$subject = new SubjectModel();
    			$subject_list = $subject->getAssocSubject();
    			foreach($record_list as $key=>$val)
    			{
    				$record_list[$key]['week_text'] = '星期'.$val['week'];
    				$record_list[$key]['time_text'] = '第'.$val['time']."节";
    				$record_list[$key]['lesson_text'] = $subject_list[$val['lesson']]['name'];
    			}
    			$return['status']	= 'success';
    			$return['content']	= $record_list;
    		}
    		else
    		{
    			$return['status']	= 'failure';
    			$return['content']	= '暂无数据';
    		}
    	}
    	else
    	{
    		$return['status']	= 'success';
    		$return['content']	= '协议内容有误！';
    	}
    	$this->ajaxReturn($return);
    }

    public function stuAttendDetail()
    {
        $class = new ClassModel();
        $class_list = $class->getAssocClass();
        $this->assign('clist',$class_list);
        // var_dump($_POST['croom']);
        // var_dump($_POST['ctime']);
        // var_dump($_POST['ctype']);
        $cond = array();
        $str = 1;
        $croom = $_POST['croom'];
        if($croom != 0)
        {
            // $cond['room'] = $croom;
            $str .= " AND room=".$croom;
        }
        $stime = $_POST['stime'] ? $_POST['stime'] : date("Y-m-d 00:00:00",time());
        if(!empty($stime))
        {
            $str .= " AND time>'".$stime."'";
        }
        $etime = $_POST['etime'];
        if(!empty($etime))
        {
            // $cond['time'] = array('lt',$etime);
            $str .= " AND time<'".$etime."'";
        }
        $ctype = $_POST['ctype'];
        if($ctype == 2)
        {
            // $cond['type'] = array('<>',1);
            $str .= " AND type<>1";
        }
        elseif($ctype == 1)
        {
            // $cond['type'] = 1;
            $str .= " AND type=1";
        }

        $ctime = $_POST['ctime'];
        if(!empty($ctime))
        {
        	$str .= " AND weektime='".$ctime."'";
        }

        $student = new StudentModel();
        $stu_list = $student->getAssocStudent();
        $attend = new AttendDetailModel();
        $attend_list = $attend->where($str)->order(array('id'=>"DESC"))->select();
        $count = $attend->where($str)->count();
        $count_info = '总计'.$count.'条数据';
        $type = array(1=>"正常",2=>"迟到",3=>"旷课");
        foreach($attend_list as $k=>$v)
        {
            $attend_list[$k]['name_text'] = $stu_list[$v['stu_id']]['name'];
            $attend_list[$k]['time_text'] = "第".$v['weektime']."节";
            $attend_list[$k]['type_text'] = $type[$v['type']];
            $attend_list[$k]['class_text'] = $class_list[$v['room']]['name'];
            $attend_list[$k]['date_text'] = date("Y-m-d",strtotime($v['time']));
            // $attend_list[$k]
        }
        $this->assign('attend',$attend_list);
        $this->assign('page_info',$count_info);
        $this->assign('croom',$_POST['croom']);
        $this->display('viewStu');
    }



}
?>