<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\MenuModel;
use Home\Model\ClassModel;
use Home\Model\StudentModel;
use Home\Model\ManageModel;
use Home\Model\WarningModel;
class SafeController extends Controller {
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
            case "42":
            $this->record();
            break;
            case "51":
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
    //报警记录
    public function record()
    {
        $student = new StudentModel();
        $stu_list = $student->getAssocStudent();
        $class = new ClassModel();
        $class_list = $class->getAssocClass();
        $warning = new WarningModel();
        $p = @$_POST['page'] ? $_POST['page'] : 1;
        $time = date("Y-m-d H:i:s",time()-30*24*3600);
        $str = "time>'".$time."'";
        $warning_list = $warning->getWarning($str,array('time'=>"DESC"),$p,30);
        $status = array('未读','已读');
        foreach($warning_list as $k=>$v)
        {
            $warning_list[$k]['stu_name'] = $stu_list[$v['stu_id']]['name'];
            $warning_list[$k]['stu_class'] = $class_list[$stu_list[$v['stu_id']]['class']]['name'];
            $warning_list[$k]['read_text'] = $status[$v['read']];
        }
        $count = $warning->getCount($str);
        $page = ceil((int)$count/30);
        if($page > 1)
        {
            for($i=1;$i<=$page;$i++)
            {
                $page_info .= "<a href='javascript:void(0);' class='page'>".$i."</a>";
            }
        }
        else
        {
            $page_info = "";
        }
        $this->assign('page',$page_info);
        $this->assign("warning",$warning_list);
        $this->display('record');
    }

    public function read()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['id'];
            $cond = array();
            $cond['read'] = 1;
            $warning = new WarningModel();
            $res = $warning->editWarning($id,$cond);
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
            $return['status']   = 'success';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

    public function video()
    {
        $this->display('video');
    }


}