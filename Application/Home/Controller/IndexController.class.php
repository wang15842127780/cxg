<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\MenuModel;
use Home\Model\WarningModel;
use Home\Model\MemberModel;
use Home\Model\ManageModel;
class IndexController extends Controller {
    public function index(){
    	//身份判断
    	if(empty($_COOKIE['user']))
    	{
    		$this->login();
    		die;
    	}

    	//判断功能
    	$act = $_GET['act'];
    	if(!empty($act))
    	{
    		$type = explode(".",$act)[0];
    		$id = explode(".",$act)[0];
    		switch($type)
    		{
                case "1":
                header("Location:/cxg/index.php?m=Home&c=Stu&a=index&id=".$act);
                break;
                case "2":
                header("Location:/cxg/index.php?m=Home&c=Hostel&a=index&id=".$act);
                break;
                case "3":
                header("Location:/cxg/index.php?m=Home&c=Night&a=index&id=".$act);
                break;
                case "4":
                header("Location:/cxg/index.php?m=Home&c=Enter&a=index&id=".$act);
                break;
                case "5":
                header("Location:/cxg/index.php?m=Home&c=Mess&a=index&id=".$act);
                break;
                case "6":
                header("Location:/cxg/index.php?m=Home&c=Safe&a=index&id=".$act);
                break;
    			case "64":
    			header("Location:/cxg/index.php?m=Home&c=Leave&a=index&id=".$act);
                break;
                
    		}
    	}

    	if($_COOKIE['type'] == 1)
    	{
            $this->getWarningInfo();
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

    	$this->display("index");

    }

    public function login()
    {
    	$this->display('login');
    }

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

    public function getWarningInfo()
    {
        $warning = new WarningModel();
        $warning_list = $warning->getWarning(array('read'=>0));
        if(!empty($warning_list))
        {
            $this->assign('warning',1);
        }
    }

    public function editPass()
    {
    	if($_COOKIE['type'] == 1)
    	{
            $this->getWarningInfo();
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
    	$this->display("editPass");
    }

    public function checkPass()
    {
    	$type = @$_POST['typ'];
    	$return['status'] = array();
    	if($type == 'json')
    	{
    		$old = $_POST['old'];
    		$member = new MemberModel();
    		$id = $_COOKIE['id'];
    		$member_info = $member->getMember(array("id"=>$id));
    		$password = $member_info[0]['password'];
    		if(md5($old) == $password)
    		{
    			$return['status']	= 'success';
    			$return['content']	= '密码相同！';
    		}
    		else
    		{
    			$return['status']	= 'failure';
    			$return['content']	= '原密码不正确！';
    		}
    	}
    	else
    	{
    		$return['status']	= 'failure';
    		$return['content']	= '协议内容有误！';
    	}
    	$this->ajaxReturn($return);
    }

    public function editPassword()
    {
    	$type = @$_POST['typ'];
    	$return = array();
    	if($type == 'json')
    	{
    		$new = $_POST['new_pass'];
    		$id = $_COOKIE['id'];
    		if($_COOKIE['type'] == 1)
    		{
    			$member = new MemberModel();
    			$member_info = $member->getMember(array("id"=>$id));
    			$name = $member_info[0]['name'];

    			$manage = new ManageModel();
    			$manage_info = $manage->getManage(array("name"=>$name));
    			$aid = $manage_info[0]['id'];
    			$cond = array();
    			$manage->startTrans();
    			$cond['password'] = md5($new);
    			$res = $manage->editManage($aid,$cond);
    			
    			
    			$res1 = $member->editMember($id,$cond);
    			if($res && $res1)
    			{
    				$manage->commit();
    				$return['status']	= 'success';
    				$return['content']	= '修改成功！';
    			}
    			else
    			{
    				$manage->rollBack();
    				$return['status']	= 'failure';
    				$return['content']	= '修改失败！';
    			}

    		}
    		else
    		{
    			$member = new MemberModel();
    			$cond = array();
    			$cond['password'] = md5($new);
    			$res2 = $member->editMember($id,$cond);
    			if($res2)
    			{
    				$return['status']	= 'success';
    				$return['content']	= '修改成功！';
    			}
    			else
    			{
    				$return['status']	= 'failure';
    				$return['content']	= '修改失败！';
    			}
    		}
    	}
    	else
    	{
    		$return['status']	= 'failure';
    		$return['content']	= '协议内容有误！';
    	}
    	$this->ajaxReturn($return);
    }
}