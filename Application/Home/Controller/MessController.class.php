<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\MenuModel;
use Home\Model\ClassModel;
use Home\Model\StudentModel;
use Home\Model\ManageModel;
use Home\Model\CashLogModel;
use Home\Model\SocketChatModel;
use Home\Model\TeacherAttendRecordModel;
class MessController extends Controller {
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
            case "54":
            $this->message();
            break;
            case "55":
            $this->viewMessage();
            break;
            case "57":
            $this->viewTeacher();
            break;
            case "63":
            $this->consume();
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

    public function viewManage()
    {
    	$manage = new ManageModel();
    	$list = $manage->getManageList();
    	$manage_info = array(1=>'管理员',2=>'教师',3=>'食堂人员',4=>'宿舍管理员',5=>'门卫人员');
    	$class = new ClassModel();
    	$class_list = $class->getAssocClass();
    	foreach($list as $k=>$v)
    	{
    		$list[$k]['type_text'] = $manage_info[$v['type']];
    		if($v['type'] == 2)
    		{
    			$list[$k]['class_text'] = $class_list[$v['room']]['name'];
                $list[$k]['build_text'] = '无';
    		}
    		elseif($v['type'] == 4)
            {
                $list[$k]['class_text'] = '无';
                $list[$k]['build_text'] = $v['build']."号楼";
            }
            else
    		{
    			$list[$k]['class_text'] = '无';
                $list[$k]['build_text'] = '无';
    		}
    	}
        $hostel = new HostelModel();
        $hostel_list = $hostel->getHostelList();
        $this->assign('hlist',$hostel_list);
        $class_array = $class->getClassList();
    	$this->assign('mtype',$manage_info);
    	$this->assign('clist',$class_array);
    	$this->assign('mlist',$list);
    	$this->display('viewManage');
    }

    public function addManage()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $manage = new ManageModel();
            $nick = $_POST['mnick'];
            $res1 = $manage->getManage(array('nick'=>$nick));
            $name = $_POST['mname'];
            $res2 = $manage->getManage(array('name'=>$name));
            if($res1)
            {
                $return['status']   = 'failure';
                $return['content']  = '昵称已存在！';
            }
            elseif($res2)
            {
                $return['status']   = 'failure';
                $return['content']  = '账号已存在！';
            }
            else
            {
                $cond = array();
                $type = $_POST['mtype'];
                $cond['nick'] = $nick;
                $cond['name'] = $name;
                $cond['type'] = $type;
                $cond['password'] = md5(123456);
                if($type == 2)
                {
                    $cond['room'] = $_POST['mroom'];
                }
                if($type == 4)
                {
                    $cond['build'] = $_POST['mbuild'];
                }
                $res = $manage->addManage($cond);
                if($res)
                {
                    $return['status']   = 'success';
                    $return['content']  = '添加成功！';
                }
                else
                {
                    $return['status']   = 'failure';
                    $return['content']  = '添加失败！';
                }
            }
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

    public function delManage()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['id'];
            $manage = new ManageModel();
            $res = $manage->delManage($id);
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
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

    public function resetPassword()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['id'];
            $cond = array();
            $cond['password'] = md5(123456);
            $manage = new manageModel();
            $res = $manage->editManage($id,$cond);
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
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }
//===========================================================================================================
   //人员信息管理
    public function message()
    {
    	$this->display("message");
    }
    public function testaaa()
    {
        if (version_compare(phpversion(), "5.4.0", "lt")) {
            exit('php version must greater than 5.4.0');
        }
        ob_implicit_flush();

        //run server
        $port = 80;
        new SocketChatModel( $port );
    }

    public function viewMessage()
    {
        $log = new CashLogModel();
        $cond = array();
        $sname = $_POST['sname'];
        if(!empty($sname))
        {
            $cond['stu_name'] = array("like",'%'.$sname.'%');
        }
        $stime = $_POST['stime'];
        if(empty($stime))
        {
            $stime = date("Y-m-d H:i:s",time());
        }
        $etime = $_POST['etime'];
        if(!empty($etime))
        {
            $cond['datetime'] = array(array('gt',$stime),array('lt',$etime));
        }
        else
        {
            $cond['datetime'] = array(array('gt',$stime));
        }
        $log_list = $log->getCashLog($cond);
        $this->assign("log",$log_list);
        $this->display('viewMessage');
    }

    //充值
    public function recharge()
    {
    	$type = @$_POST['typ'];
    	$return = array();
    	if($type == 'json')
    	{
    		$id = $_POST['sid'];
    		$num = $_POST['num'];
    		$student = new StudentModel();
    		$student_list = $student->getAssocStudent();
    		$name = $student_list[$id]['name'];
    		//查找余额
    		$money = $student_list[$id]['money'];
    		$now_money = (float)$money + (float)$num;
    		$cond_row = array();
    		$cond_row['money'] = $now_money;
    		$res1 = $student->editStudent($id,$cond_row);
    		if($res1)
    		{
    			$log = new CashLogModel();
	    		$cond = array();
	    		$cond['stu_id']		= $id;
	    		$cond['stu_name']	= $name;
	    		$cond['operate']	= '充值'.$num.'元';
                $cond['cash']       = $num;
                $cond['month']		= date("Y-m",time());
	    		$cond['date']		= date('Y-m-d',time());
	    		$cond['datetime']	= date('Y-m-d H:i:s',time());
	    		$res = $log->addCashLog($cond);
	    		if($res)
	    		{
	    			$return['status']	= 'success';
	    			$return['content']	= '充值成功！';
	    		}
	    		else
	    		{
	    			$return['status']	= 'failure';
	    			$return['content']	= '操作失败，请稍后尝试！';
	    		}
    		}
    		else
    		{
    			$return['status']	= 'failure';
    			$return['content']	= '操作失败，请稍后尝试！';
    		}
	    		
    	}
    	else
    	{
    		$return['status']	= 'failure';
    		$return['content']	= '协议内容有误！';
    	}
    	$this->ajaxReturn($return);
    }

    //获取近几日资金
    public function getTotal()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $did= $_POST['did'];
            if($did == 'today')
            {
                $time = date('Y-m-d 00:00:00',time());
                $cc = '今天的销售总额为：￥';
            }
            elseif($did == 'seven')
            {
                $tt = time()-6*24*3600;
                $time = date('Y-m-d 00:00:00',$tt);
                $cc = '近七天的销售总额为：￥';
            }
            else
            {
                $time = date('Y-m-1 00:00:00');
                $cc = '本月的销售总额为：￥';
            }
            $cond = array();
            $cond['datetime'] = array('gt',$time);
            $cond['cash'] = array('lt',0);
            $log = new CashLogModel();
            $sum =  $log->where($cond)->sum('cash');
            $sum = empty($sum) ? 0 : -$sum;
            if(true)
            {
                $return['status']   = 'success';
                $return['sleft']    = $cc;
                $return['sright']   = $sum;
            }
            else
            {
                $return['status']   = 'failure';
                $return['content']  = '请求错误！';
            }
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

    //获得每个月的销售记录
    public function getAll()
    {
    	$type = @$_POST['typ'];
    	$return = array();
    	if($type == 'json')
    	{
    		$stime = date("Y-01-01 00:00:00",time()-365*24*3600);
    		$log = new CashLogModel();
    		$cond2 = array();
    		$cond2['cash'] = array('gt',0);
    		$cond2['datetime'] = array('gt',$stime);
    		$list2 = $log->field('sum(cash),month')->where($cond2)->group('month')->select();
    		$cond1 = array();
    		$cond1['cash'] = array('lt',0);
    		$cond1['datetime'] = array('gt',$stime);
    		$list1 = $log->field('sum(cash),month')->where($cond1)->group('month')->select();
    		$list = array();

    		//合并两个数据
    		foreach($list1 as $key=>$val)
    		{
    			$list[$val['month']]['consume'] = -$val['sum(cash)'];
    		}

    		foreach($list2 as $key=>$val)
    		{
    			$list[$val['month']]['recharge'] = $val['sum(cash)'];
    		}
    		if(!empty($list))
    		{
    			krsort($list);
    			foreach($list as $key=>$val)
    			{
    				if(empty($val['recharge']))
    				{
    					$list[$key]['recharge'] = "0.00";
    				}
    				if(empty($val['consume']))
    				{
    					$list[$key]['consume'] = "0.00";
    				}
    			}
    			$return['status']	= 'success';
    			$return['content']	= $list;
    		}
    		else
    		{
    			$return['status']	= 'failure';
    			$return['content']	= 'Wrong';
    		}
    	}
    	else
    	{
    		$return['status']	= 'failure';
    		$return['content']	= '协议内容有误！';
    	}
    	$this->ajaxReturn($return);
    }

    public function viewTeacher()
    {
        $this->display('viewTeacher');
    }

    public function getTeacherRecord()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $record = new TeacherAttendRecordModel();
            $tname = $_POST['tname'];
            $stime = $_POST['stime'];
            $etime = $_POST['etime'];
            //姓名采用模糊查询
            $str = 1;
            //姓名为空则取统计，不为空则为详细记录
            if(!empty($tname))
            {
                $str .= " and name like '%".$tname."%'";
                //默认查找本月
                if(!empty($stime))
                {
                    $str .= " and datetime>'$stime'";
                }
                else
                {
                    $time = date("Y-m-01 00:00:00",time());
                    $str .= " and datetime>'$time'";
                }
                if(!empty($etime))
                {
                    $str .= " and datetime<'$etime'";
                }
                $list = $record->where($str)->order(array('datetime'=>'DESC'))->select();
                $act = 'select';
                $state = '注：默认开始查询时间为本月1号';
            }
            else
            {
                //默认查找两年内的统计
                if(!empty($stime))
                {
                    $str .= " and datetime>'$stime'";
                }
                else
                {
                    $stime = date("Y-m-01 00:00:00",time());
                    $str .= " and datetime>'$stime'";
                }
                if(!empty($etime))
                {
                    $str .= " and datetime<'$etime'";
                }
                else
				{
					$etime = '今';
				}
                // $list = $record->where($str)->group('name')->count();
                $list = $record->field('name,count(*)')->where($str)->group('name')->select();
                $state = '注：默认开始查询时间为本月1号';
                $act = 'count';
                foreach($list as $k=>$v)
                {
                	$list[$k]['count'] = $v['count(*)'].'次';
                	$list[$k]['time'] = $stime.'&nbsp;至&nbsp;'.$etime;
                }
            }
            if(!empty($list))
            {
            	$return['status']	= 'success';
            	$return['act']		= $act;
            	$return['state']	= $state;
            	$return['content']	= $list;
            }
            else
            {
            	$return['status']	= 'failure';
            	$return['content']	= '所查条件下无数据';
            }
        }
        else
        {
            $return['status']   = 'success';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }


    //消费界面
    public function consume()
    {
        $this->display('consume');
    }
}