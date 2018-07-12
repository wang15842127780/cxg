<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Model\MenuModel;
use Admin\Model\StudentLeaveModel;
use Admin\Model\ClassYearModel;
use Home\Model\ManageModel;

class IndexController extends Controller{
	public function index()
	{
		if(empty($_COOKIE['auser']))
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
    			case "7":
    			header("Location:/cxg/index.php?m=Admin&c=Setting&a=index&id=".$act);
                break;
                default:
                header("Location:/cxg/index.php?m=Admin");
                break;
    		}
    	}
    	$menu = new MenuModel();
    	// $main_menu = $menu->getMenu(array('parent_id'=>7));
    	$menus = $menu->getMenuTree();
    	$main_menu = $menus[0]['sub_menu'];
    	$this->assign('main_menu',$main_menu);
    	// $this->assign("menu",$menus);
    	$this->display('index');
	}
    public function login()
    {
        $this->display("login");
    }

    public function getInfo()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $list = array();  //返回的数组
            $id = $_COOKIE['aid'];
            $manage = new ManageModel();
            $manage_info = $manage->getManage(array("id"=>$id));
            $power = $manage_info[0]['power'];
            $power_arr = @explode(",",$power);
            //1、获取请假数据
            $year_cond = array();
            $year = new ClassYearModel();
            $year_info = $year->getClassYear(array('director_id'=>$id));
            if($power==="0" || in_array(6,$power_arr))
            {
                if(!empty($year_info))
                {
                    $year_cond['year_id'] = $year_info[0]['id'];
                }
            }
            else
            {
                $year_cond['year_id'] = -1;
            }
            
            $year_cond['status'] = array("IN",array(3,4));
            $leave = new StudentLeaveModel();
            $leave_count = $leave->where($year_cond)->count();
            if(!empty($leave_count))
            {
                $list['leave'] = $leave_count;
            }
            else
            {
                $list['leave'] = 0;
            }


            if(true)
            {
                $return['status']   = 'success';
                $return['content']  = $list;
            }
            else
            {
                $return['status']   = 'failure';
                $return['content']  = '数据错误！';
            }
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容错误！';
        }
        $this->ajaxReturn($return);
    }
}


?>