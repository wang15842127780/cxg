<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Model\MenuModel;
use Home\Model\NightModel;
use Home\Model\ClassModel;
use Home\Model\HostelModel;
use Home\Model\StudentModel;
use Home\Model\ManageModel;
use Home\Model\MemberModel;
use Home\Model\SubjectModel;
use Home\Model\SyllabusModel;
use Home\Model\CameraModel;

use Admin\Model\BuildTypeModel;
use Admin\Model\RoleModel;
use Admin\Model\ClassYearModel;
use Admin\Model\LeaderModel;
use Admin\Model\EntryRecordModel;
use Admin\Model\MainEntranceRecordModel;
class SettingController extends Controller {
    public function index(){
        //身份判断
        if(empty($_COOKIE['auser']))
        {
            $this->login();
            die;
        }
        $menu = new MenuModel();
        $act = @$_GET['id'];
        $res = $this->yanzheng($act);
        if(!$res)
        {
            $this->error('URL有误',header("Location:/cxg/index.php?m=Admin"));
        }
        //身份判断
        $this->manage();
        $this->assign("typ",$act);
        $type = explode(".",$act)[1];
        switch($type)
        {
            case "21":
            $this->editPass();
            break;
            case "22":
            $this->viewRole();
            break;
            case "23":
            $this->viewClassYear();
            break;
            case "24":
            $this->viewClass();
            break;
            case "25":
            $this->stuInfo();
            break;
            case "26":
            $this->viewStu();
            break;
            case "27":
            // $this->addHostel();
            $this->buildType();
            break;
            case "28":
            $this->viewHostel();
            break;
            case "29":
            // $this->womanHostel();
            $this->ruzhu();
            break;
            case "30":
            $this->teacherGroup();
            break;
            case "31":
            $this->addTeacher();
            break;
            case "58":
            $this->viewTeacher();
            break;
            case "32":
            $this->editStu();
            break;
            case "33":
            $this->editTeacher();
            break;
            case "34":
            $this->addSubject();
            break;
            case "35":
            $this->viewSubject();
            break;
            case "36":
            $this->syllabus();
            break;
            case "37":
            $this->todaySyllabus();
            break;
            case "41":
            $this->viewCamera();
            break;
            case "48":
            $this->removeClass();
            break;
            case "52":
            $this->arrangeStu();
            break;
            case "53":
            $this->arrangeNight();
            break;
            case "70":
            $this->viewManage();
            break;
            case "71":
            $this->viewMember();
            break;
            case "78":
            $this->viewEntryRecord();
            break;
            case "79":
            $this->viewInsideRecord();
            break;
            default:;
        }
        
    }

    public function login()
    {
        header("Location:/cxg/index.php?m=Admin");
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
        $menus = $menu->getMenuTree();
        $main_menu = $menus[0]['sub_menu'];
        $this->assign('main_menu',$main_menu);
    }
//权限判断
    public function getPower()
    {
    	$ccid = $_COOKIE['aid'];
    	$manage = new ManageModel();
        $manage_info = $manage->getManage(array("id"=>$ccid));
        $power = $manage_info[0]['power'];
        $power_arr = @explode(",",$power);
        return $power_arr;
    }

//===============================================================================================
    //修改密码
    public function editPass()
    {
        $type = @$_POST['typ'];
        if($type == 'json')
        {
            $new = $_POST['new_pass'];
            $user = $_COOKIE['auser'];
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
                setcookie('auser','',time()-3600,"/");
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
            $user = $_COOKIE['auser'];
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


//===================================================================================================
    //人员管理

    public function viewManage()
    {
        $role = new RoleModel();
        $role_list = $role->getAssocList();
        $this->assign('roleList',json_encode($role_list));
        $this->display('viewManage');
    }


    public function getManageList()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $manage = new ManageModel();
            $cond = array();
            $cond['id'] = array('gt',1);
            if(!empty($_POST['snick']))
            {
                $cond['nick'] = $_POST['snick'];
            }
            if(!empty($_POST['sname']))
            {
                $cond['name'] = $_POST['sname'];
            }
            $manage_list = $manage->getManage($cond);
            $role = new RoleModel();
            $role_list = $role->getAssocList();
            $power = $this->getPower();
            if($power[0]==="0" || in_array(8,$power))
            {
            	$return['leader'] = 1;
            }
            else
            {
            	$return['leader'] = 0;
            }
            if(!empty($manage_list))
            {
            	if($return['leader'] == 1)
            	{
            		foreach($manage_list as $key=>$val)
	                {
	                    $manage_list[$key]['role_text'] = $role_list[$val['role_id']]['role_name'];
	                    $manage_list[$key]['reset_pass'] = "<a href='javascript:void(0);' sign='".$val['id']."' class='reset'>重置密码</a>";
	                    $manage_list[$key]['set_power'] = "<a href='javascript:void(0);' sign='".$val['id']."' class='power_set'>权限管理</a>";
	                }
            	}
	            else
	            {
	            	foreach($manage_list as $key=>$val)
	                {
	                    $manage_list[$key]['role_text'] = $role_list[$val['role_id']]['role_name'];
	                    $manage_list[$key]['reset_pass'] = "无";
	                    $manage_list[$key]['set_power'] = "无";
	                    $manage_list[$key]['act_text'] = "无";
	                }
	            }
                $return['status']   = 'success';
                $return['content']  = $manage_list;
            }
            else
            {
                $return['status']   = 'failure';
                $return['content']  = '暂无数据';
            }
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

    public function addManage()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $cond = array();
            $manage = new ManageModel();
            $member = new MemberModel();
            //判断  登录名不能存在
            $cond['name'] = $_POST['name'];
            $re1 = $manage->getManage($cond);
            $re2 = $member->getMember($cond);
            if($re1 || $re2)
            {
                $return['status']   = 'failure';
                $return['content']  = '用户名已存在！';
            }
            else
            {
                //添加操作
                $cond['nick'] = $_POST['nick'];
                $cond['password'] = md5($_POST['pass']);
                //开启事务
                $member->startTrans();
                $res1 = $member->addMember($cond);
                $cond['role_id'] = $_POST['role'];
                $res2 = $manage->addManage($cond);
                if($res1 && $res2)
                {
                    //都成功则提交
                    $member->commit();
                    $return['status']   = 'success';
                    $return['content']  = '添加成功！';
                }
                else
                {
                    //失败则回滚
                    $member->rollback();
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
            $manage_info = $manage1->getManage(array('id'=>$id));
            $cond = array();
            $cond['name'] = $manage_info[0]['name'];
            $member = new MemberModel();
            $member_info = $member->getMember($cond);
            $member_id = $member_info[0]['id'];
            $manage->startTrans();
            $res1 = $manage->delManage($id);
            $res2 = $member->delMember($member_id);
            if($res1 && $res2)
            {
                $manage->commit();
                $return['status']   = 'success';
                $return['content']  = '删除成功！';
            }
            else
            {
                $manage->rollback();
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

    public function resetPass()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $cond = array();
            $id = $_POST['id'];
            $member = new MemberModel();
            $manage = new ManageModel();
            $manage_info = $manage->getManage(array('id'=>$id));
            $name = $manage_info[0]['name'];
            $member_info = $member->getMember(array('name'=>$name));
            $member_id = $member_info[0]['id'];
            $manage->startTrans();
            $cond['password'] = md5("123456");
            $res1 = $manage->editManage($id,$cond);
            $res2 = $member->editMember($member_id,$cond);
            if($res1 && $res2)
            {
                $manage->commit();
                $return['status']   = 'success';
                $return['content']  = '操作成功！';
            }
            else
            {
                $manage->rollback();
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
    //权限管理
    public function getPowerById()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['pid'];
            if(empty($id))
            {
                $return['status']   = 'failure';
                $return['content']  = '传值错误！';
            }
            else
            {
                $manage = new ManageModel();
                $manage_info = $manage->getManage(array('id'=>$id));
                $power = $manage_info[0]['power'];
                $arr = @explode(",",$power);
                if(true)
                {
                    $return['status']   = 'success';
                    $return['content']  = $arr;
                }
                else
                {
                    $return['status']   = 'failure';
                    $return['content']  = '错误！';
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
    public function setPower()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['pid'];
            if(empty($id))
            {
                $return['status']   = 'failure';
                $return['content']  = '传值错误！';
            }
            else
            {
                $power = $_POST['power'];
                $manage = new ManageModel();
                $cond = array();
                $cond['power'] = $power;
                $res = $manage->editManage($id,$cond);
                if($res)
                {
                    $return['status']   = 'success';
                    $return['content']  = '操作成功！';
                }
                else
                {
                    $return['status']   = 'failure';
                    $return['content']  = '暂无修改的数据！';
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

//=========================================================================================
    //其他人员管理
    public function viewMember()
    {
        $hostel = new HostelModel();
        $hostel_list = $hostel->Distinct(true)->field('build')->select();
        $build_ids = array();
        foreach($hostel_list as $key=>$val)
        {
            $build_ids[] = $val['build'];
        }
        $this->assign('build_ids',json_encode($build_ids));
        $this->display('viewMember');
    }

    public function getMemberList()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $member = new MemberModel();
            $cond = array();
            if(!empty($_POST['snick']))
            {
                $cond['nick'] = $_POST['snick'];
            }
            if(!empty($_POST['sname']))
            {
                $cond['name'] = $_POST['sname'];
            }
            if(!empty($_POST['stype']))
            {
                $cond['type'] = $_POST['stype'];
            }
            else
            {
                $cond['type'] = array('gt',2);
            }
            $res = $member->getMember($cond);
            if(!empty($res))
            {
                $type_list = array(3=>'食堂人员',4=>'宿舍管理员',5=>'门卫人员');
	            $power = $this->getPower();
	            if($power[0]==="0" || in_array(8,$power))
	            {
	            	$return['leader'] = 1;
	            	foreach($res as $key=>$val)
	                {
	                    $res[$key]['type_text'] = $type_list[$val['type']];
	                    $res[$key]['reset_pass'] = "<a href='javascript:void(0);' sign='".$val['id']."' class='reset'>重置密码</a>";
	                }
	            }
	            else
	            {
	            	$return['leader'] = 0;
	            	foreach($res as $key=>$val)
	                {
	                    $res[$key]['type_text'] = $type_list[$val['type']];
	                    $res[$key]['reset_pass'] = "无";
	                    $res[$key]['act_text'] = '无';
	                }
	            }
                $return['status']   = 'success';
                $return['content']  = $res;
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

    public function addMember()
    {
        $typ = $_POST['typ'];
        $return = array();
        if($typ == 'json')
        {
            $member = new MemberModel();
            $cond = array();
            $cond['name'] = $_POST['name'];
            $re = $member->getMember($cond);
            if(!empty($re))
            {
                $return['status']   = 'failure';
                $return['content']  = '用户名已存在！';
            }
            else
            {
                $cond['nick'] = $_POST['nick'];
                $cond['money'] = 0;
                $cond['password'] = md5($_POST['pass']);
                $cond['type'] = $_POST['type'];
                if(!empty($_POST['hostel']))
                {
                    $cond['hostel_id'] = $_POST['hostel'];
                }
                $res = $member->addMember($cond);
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

    public function delMember()
    {
        $type = $_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $member = new MemberModel();
            $id = $_POST['id'];
            $res = $member->delMember($id);
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

    public function resetMemberPass()
    {
        $type = $_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $member = new MemberModel();
            $id = $_POST['id'];
            $cond['password'] = md5(123456);
            $res = $member->editMember($id,$cond);
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
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

//=========================================================================================
    //角色管理
    public function viewRole()
    {
        $this->display('viewRole');
    }

    public function getRoleList()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $role = new RoleModel();
            $cond = array();
            if(!empty($_POST['name']))
            {
                $cond['role_name'] = $_POST['name'];
            }
            $role_list = $role->getRole($cond);
            $power = $this->getPower();
            if($power[0]==="0" || in_array(8,$power))
            {
            	$return['leader'] = 1;
            }
            else
            {
            	$return['leader'] = 0;
            }
            if(!empty($role_list))
            {
            	foreach($role_list as $key=>$val)
            	{
            		$role_list[$key]['act_text'] = "无";
            	}
                $return['status']   = 'success';
                $return['content']  = $role_list;
            }
            else
            {
                $return['status']   = 'failure';
                $return['content']  = '暂无数据！';
            }
        }
        else
        {
            $return['status']   = 'success';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

    public function addRole()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $role = new RoleModel();
            $cond = array();
            $cond['role_name']  = $_POST['name'];
            $re = $role->getRole($cond);
            if(!empty($re))
            {
                $return['status']   = 'failure';
                $return['content']  = '角色名称已存在！';
            }
            else
            {
                $res = $role->addRole($cond);
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

    public function editRole()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $role = new RoleModel();
            $id = $_POST['id'];
            $name = $_POST['name'];
            $cond = array();
            $cond['role_name'] = $name;
            $re = $role->getRole($cond);
            if(!empty($re))
            {
                $return['status']   = 'failure';
                $return['content']  = '角色名称已存在！';
            }
            else
            {
                $res = $role->editRole($id,$cond);
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
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

    public function delRole()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['id'];
            $role = new RoleModel();
            $res = $role->delRole($id);
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


//=======================================================================
    //年组设置
    public function viewClassYear()
    {
        $manage = new ManageModel();
        $cond = array();
        $cond['id'] = array('gt',1);
        $manage_list = $manage->getManage($cond);
        $this->assign('manageList',json_encode($manage_list));
        $this->display('classYear');
    }

    public function getClassYearList()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $year = new ClassYearModel();
            $cond = array();
            if(!empty($_POST['sname']))
            {
                $cond['name'] = $_POST['sname'];
            }
            $year_list = $year->getClassYear($cond);
            $manage = new ManageModel();
            $manage_list = $manage->getAssocManage();
            $power = $this->getPower();
            if($power[0]==="0" || in_array(1,$power))
            {
            	$return['leader'] = 1;
            }
            else
            {
            	$return['leader'] = 0;
            }
            if(!empty($year_list))
            {
                foreach($year_list as $key=>$val)
                {
                    $year_list[$key]['director_name'] = $manage_list[$val['director_id']]['nick'];
                    $year_list[$key]['act_text'] = "无";
                }
                $return['status']   = 'success';
                $return['content']  = $year_list;
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

    public function addClassYear()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $year = new ClassYearModel();
            $cond = array();
            $cond['name'] = $_POST['name'];
            $re = $year->getClassYear($cond);
            if(!empty($re))
            {
                $return['status']   = 'failure';
                $return['content']  = '年组名已存在';
            }
            else
            {
                $cond['director_id'] = $_POST['director'];
                $res = $year->addClassYear($cond);
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

    public function delClassYear()
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
                $year = new ClassYearModel();
                $res = $year->delClassYear($id);
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
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

    public function editClassYear()
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
                $year = new ClassYearModel();
                $year->startTrans();
                $cond = array();
                $cond['name'] = $_POST['name'];
                $did = $_POST['director'];
                $cond['director_id'] = $did;
                $res = $year->editClassYear($id,$cond);

                $manage = new ManageModel();
                $manage_info = $manage->getManage(array("id"=>$did));
                $power = $manage_info[0]['power'];
                $power_arr = explode(",",$power);
                if(!in_array(6,$power_arr))
                {
                    if(!empty($power))
                    {
                        $power_arr[] = 6;
                        sort($power_arr);
                        $pp = implode(",",$power_arr);
                    }
                    else
                    {
                        $pp = 6;
                    }
                    $cond_row = array();
                    $cond_row['power'] = $pp;
                    $res1 = $manage->editManage($did,$cond_row);
                }
                else
                {
                    $res1 = true;
                }      
                if($res && $res1)
                {
                    $year->commit();
                    $return['status']   = 'success';
                    $return['content']  = '修改成功！';
                }
                else
                {
                    $year->rollback();
                    $return['status']   = 'failure';
                    $return['content']  = '修改失败！';
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

    public function getClassYearById()
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
                $year = new ClassYearModel();
                $year_list = $year->getClassYear(array("id"=>$id));
                if(!empty($year_list))
                {
                    $return['status']   = 'success';
                    $return['content']  = $year_list[0];
                }
                else
                {
                    $return['status']   = 'failure';
                    $return['content']  = '请求错误！';
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
        


//=======================================================================
   
    public function viewClass()
    {
    	$year = new ClassYearModel();
    	$year_list = $year->getClassYear();
    	$this->assign('yearList',$year_list);
    	$this->assign('yearLists',json_encode($year_list));
    	$leader = new LeaderModel();
    	$leader_list = $leader->getLeader();
    	$this->assign('leaderList',$leader_list);
    	$this->assign('leaderLists',json_encode($leader_list));
        $this->display('viewClass');
    }
   
	public function getClassList()
	{
		$type = @$_POST['typ'];
		$return = array();
		if($type == 'json')
		{
			$leader = new LeaderModel();
			$leader_list = $leader->getAssocList();
			$class = new ClassModel();
			$year = new ClassYearModel();
			$year_list = $year->getAssocList();
			$cond = array();
			if(!empty($_POST['syear']))
			{
				$cond['year_id'] = $_POST['syear'];
			}
			if(!empty($_POST['sname']))
			{
				$cond['name'] = $_POST['sname'];
			}
			$power = $this->getPower();
			if($power[0]==="0" || in_array(1,$power))
			{
				$return['leader'] = 1;
			}
			else
			{
				$return['leader'] = 0;
			}
			$class_list = $class->getClass($cond,array("year_id"=>"asc","name"=>"asc"));
			if(!empty($class_list))
			{
				foreach($class_list as $key=>$val)
				{
					$class_list[$key]['leader_text'] = $leader_list[$val['leader_id']]['name'];
					$class_list[$key]['year_text'] = $year_list[$val['year_id']]['name'];
					$class_list[$key]['act_text'] = '无';
				}
				$return['status']	= 'success';
				$return['content']	= $class_list;
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
			$return['content']	= '协议内容有误！';
		}
		$this->ajaxReturn($return);
	}

	public function addClass()
	{
		$type = @$_POST['typ'];
		$return = array();
		if($type == 'json')
		{
			$year = new ClassYearModel();
			$year_list = $year->getAssocList();
			$class = new ClassModel();
			$cond = array();
			$cond['name'] = $_POST['name'];
			$year_id = $_POST['year'];
			$cond['year_id'] = $year_id;
			$re = $class->getClass($cond);
			if(!empty($re))
			{
				$return['status']	= 'failure';
				$return['content']	= '班级名已存在！';
			}
			else
			{
				$cond['leader_id'] = $_POST['leader'];
				$cond['num'] = $_POST['num'];
				$res = $class->addClass($cond);
				if($res)
				{
					$return['status']	= 'success';
					$return['content']	= '添加成功！';
				}
				else
				{
					$return['status']	= 'failure';
					$return['content']	= '添加失败！';
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

	public function editClass()
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
				$year = new ClassYearModel();
				$year_list = $year->getAssocList();
				$class = new ClassModel();
				$cond = array();
				$cond['name'] = $_POST['name'];
				$year_id = $_POST['year'];
				$cond['year_id'] = $year_id;
				$cond['leader_id'] = $_POST['leader'];
				$cond['num'] = $_POST['num'];
				$res = $class->editClass($id,$cond);
				if($res)
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

	public function getClassById()
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
				$class = new ClassModel();
				$class_info = $class->getClass(array("id"=>$id));
				if(!empty($class_info))
				{
					$return['status']	= 'success';
					$return['content']	= $class_info[0];
				}
				else
				{
					$return['status']	= 'failure';
					$return['content']	= '数据错误！';
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

	public function delClass()
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
				$class = new ClassModel();
				$res = $class->delClass($id);
				if($res)
				{
					$return['status']	= "success";
					$return['content']	= '删除成功！';
				}
				else
				{
					$return['status']	= 'failure';
					$return['content']	= '删除失败！';
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

	public function getTeacherByYear()
	{
		$type = @$_POST['typ'];
		$return = array();
		if($type == 'json')
		{
			$id = $_POST['id'];
			if(empty($id))
			{
				$year = new ClassYearModel();
				$year_list = $year->getClassYear();
				$id = $year_list[0]['id'];
			}
			$leader = new LeaderModel();
			$leader_list = $leader->getLeader(array("year_id"=>$id));
			if(!empty($leader_list))
			{
				$return['status']	= 'success';
				$return['content']	= $leader_list;
			}
			else
			{
				$return['status']	= 'failure';
				$return['content']	= '请先设置教师信息！';
			}
		}
		else
		{
			$return['status']	= 'failure';
			$return['content']	= '协议内容有误！';
		}
		$this->ajaxReturn($return);
	}
	public function getTeacher()
	{
		$type = @$_POST['typ'];
		$return = array();
		if($type == 'json')
		{
			$leader = new LeaderModel();
			$leader_list = $leader->getLeader();
			if(!empty($leader_list))
			{
				$return['status']	= 'success';
				$return['content']	= $leader_list;
			}
			else
			{
				$return['status']	= 'failure';
				$return['content']	= '暂无教师数据！';
			}
		}
		else
		{
			$return['status']	= 'failure';
			$return['content']	= '协议内容有误！';
		}
		$this->ajaxReturn($return);
	}

//=========================================================================================
    //房间类型管理
    public function buildType()
    {
        $this->display('buildType');
    }

    public function getBuildType()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['id'];
            $cond = array();
            $cond['id'] = $id;
            $build = new BuildTypeModel();
            $res = $build->getBuildType($cond);
            if($res)
            {
                $return['status']   = 'success';
                $return['content']  = $res;
            }
            else
            {
                $return['status']   = 'failure';
                $return['content']  = '操作失败!';
            }
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

    public function buildTypeList()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $build = new BuildTypeModel();
            $list = $build->getBuildType();
            $power = $this->getPower();
            if($power[0]==="0" || in_array(2,$power))
            {
            	$return['leader'] = 1;
            }
            else
            {
            	$return['leader'] = 0;
            }
            if(!empty($list))
            {
            	foreach($list as $key=>$val)
            	{
            		$list[$key]['act_text'] = '无';
            	}
                $return['status']   = 'success';
                $return['content']  = $list;
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


    public function addBuildType()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $cond = array();
            $cond['name'] = $_POST['bname'];
            $build = new BuildTypeModel();
            $re = $build->getBuildType($cond);
            if($re)
            {
                $return['status']   = 'failure';
                $return['content']  = '类型名称已存在！';
            }
            else
            {
                $cond['number'] = $_POST['bnum'];
                $cond['addtime'] = date('Y-m-d H:i:s',time());
                $res = $build->addBuildType($cond);
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

    public function delBuildType()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['bid'];
            $build = new BuildTypeModel();
            $res = $build->delBuildType($id);
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

    public function editBuildType()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['bid'];
            $cond = array();
            $name = $_POST['bname'];
            $cond['name'] = $_POST['bname'];
            $build = new BuildTypeModel();
            $model = D('buildType');
            $model->startTrans();
            $cond['number'] = $_POST['bnum'];
            $res = $build->editBuildType($id,$cond);
            if($res)
            {
                $cond1 = array();
                $cond1['name'] = $name;
                $re = $build->getBuildType($cond1);
                if(count($re)>1)
                {
                    $model->rollback();
                    $return['status']   = 'failure';
                    $return['content']  = '类型名称已存在！';
                }
                else
                {
                    $model->commit();
                    $return['status']   = 'success';
                    $return['content']  = '修改成功！';
                }
            }
            else
            {
                $return['status']   = 'failure';
                $return['content']  = '修改失败！';
            }

        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

//=========================================================================================
    //宿舍管理
    public function addHostel()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $cond = array();
            $build = new BuildTypeModel();
            $htype = $_POST['htype'];
            $build_type = $build->getBuildType(array('id'=>$htype));
            $cond['name'] = $build_type[0]['name'];
            $cond['contain'] = $build_type[0]['number'];
            $cond['sex'] = $_POST['sex'];
            $cond['floor'] = $_POST['floor'];
            $cond['build'] = $_POST['build'];
            $cond['no'] = $_POST['no'];
            $cond['type'] = $htype;
            $hostel = new HostelModel();
            $res = $hostel->addHostel($cond);
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
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

    public function editHostel()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['id'];
            $cond = array();
            $build = new BuildTypeModel();
            $htype = $_POST['htype'];
            $build_type = $build->getBuildType(array('id'=>$htype));
            $cond['name'] = $build_type[0]['name'];
            $cond['contain'] = $build_type[0]['number'];
            $cond['sex'] = $_POST['sex'];
            $cond['floor'] = $_POST['floor'];
            $cond['build'] = $_POST['build'];
            $cond['no'] = $_POST['no'];
            $cond['type'] = $htype;
            $hostel = new HostelModel();
            $res = $hostel->editHostel($id,$cond);
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
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

    public function getHostelById()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['id'];
            $hostel = new HostelModel();
            $hostel_list = $hostel->getHostel(array('id'=>$id));
            if(!empty($hostel_list))
            {
                $return['status']   = 'success';
                $return['content']  = $hostel_list[0];
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

    public function viewHostel()
    {
        $build = new BuildTypeModel();
        $build_list = $build->getAssocList();
        $build_list = json_encode($build_list);
        $this->assign('typeList',$build_list);
        $this->display('viewHostel');
    }

    public function delHostel()
    {
        $id = $_POST['id'];
        $return = array();
        $student = new StudentModel();
        $re = $student->getStudent(array('dormitory_id'=>$id));
        if(!$re)
        {
            $hostel = new HostelModel();
            $res = $hostel->delHostel($id);
            
            if($res)
            {
                $return['status'] = 'success';
                $return['content'] = '删除成功！';
            }
            else
            {
                $return['status'] = 'failure';
                $return['content'] = '删除失败！';
            }
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '此宿舍还有学生信息，不能删除！';
        }
        $this->ajaxReturn($return);
    }

    public function getHostelList()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $hostel = new HostelModel();
            $cond = array();
            if(!empty($_POST['build']))
            {
                $cond['build'] = $_POST['build'];
            }
            if(!empty($_POST['no']))
            {
                $cond['no'] = array('LIKE',"%".$_POST['no']."%");
            }
            $order = array();
            $order['build'] = 'ASC';
            $order['floor'] = 'ASC';
            $order['no'] = 'ASC';
            $hostel_list = $hostel->getHostel($cond,$order);
            $sex = array('女','男','无');
            $power = $this->getPower();
            if($power[0]==="0" || in_array(2,$power))
            {
            	$return['leader'] = 1;
            }
            else
            {
            	$return['leader'] = 0;
            }
            if(!empty($hostel_list))
            {
                foreach($hostel_list as $key=>$val)
                {
                    $hostel_list[$key]['sex_text'] = $sex[$val['sex']];
                    $hostel_list[$key]['act_text'] = '无';
                }
                $return['status']   = 'success';
                $return['content']  = $hostel_list;
            }
            else
            {
                $return['status']   = 'failure';
                $return['content']  = '暂无宿舍数据';
            }

        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }


//====================================================================================
    //入住信息
    public function ruzhu()
    {
        $hostel = new HostelModel();
        $order = array();
        $order['build'] = 'asc';
        $order['floor'] = 'asc';
        $order['no'] = 'asc';
        $hostel_list = $hostel->getHostel(array(),$order);

        //获取房间类型
        $type = new BuildTypeModel();
        $type_list = $type->getAssocList();

        if(!empty($hostel_list))
        {
            foreach($hostel_list as $k=>$v)
            {
                $hostel_list[$k]['type_text'] = $type_list[$v['type']]['name'];
            }
        }

        $hostel_list1 = array();
        foreach($hostel_list as $kk=>$vv)
        {
        	$hostel_list1[$vv['id']] = $vv;
        }

        $student = new StudentModel();
        $student_info = $student->field('dormitory_id,count(*) as num')->group('dormitory_id')->select();
        foreach($student_info as $kk=>$vv)
        {
        	if($vv['dormitory_id'] != 0)
        	{
        		$hostel_list1[$vv['dormitory_id']]['num'] = $vv['num'];
        	}
        }

        $newlist = array();
        if(!empty($hostel_list1))
        {
            foreach($hostel_list1 as $key=>$val)
            {
                $newlist[$val['build']][$val['floor']][] = $val;
            }
        }
        $this->assign('hostelList',$newlist);
        $this->display('ruzhu');
    }

    //入住联动
    public function getBuildInfo()
    {
    	$type = @$_POST['typ'];
    	$return = array();
    	if($type == 'json')
    	{
    		$hostel = new HostelModel();
    		$build_ids = $hostel->distinct(true)->field("build")->select();
    		$ids = array();
    		if(!empty($build_ids))
    		{
    			foreach($build_ids as $key=>$val)
    			{
    				$ids[] = $val['build'];
    			}
    			$return['status']	= 'success';
    			$return['content']	= $ids;
    		}
    		else
    		{
    			$return['status']	= 'failure';
    			$return['content']	= '请先设置宿舍信息！';
    		}
    	}
    	else
    	{
    		$return['status']	= 'failure';
    		$return['content']	= '协议内容有误！';
    	}
    	$this->ajaxReturn($return);
    }

    public function getFloorByBuild()
    {
    	$type = @$_POST['typ'];
    	$return = array();
    	if($type == 'json')
    	{
    		$build = $_POST['build'];
    		if(empty($build))
    		{
    			//给出默认的build
    			$hostel = new HostelModel();
    			$hostel_list = $hostel->getHostel();
    			$build = $hostel_list[0]['build'];
    		}
    		$cond = array();
    		$cond['build'] = $build;
    		$floor_ids = $hostel->where($cond)->order(array("floor"=>"asc"))->distinct(true)->field('floor')->select();
    		$ids = array();
    		if(!empty($floor_ids))
    		{
    			foreach($floor_ids as $key=>$val)
    			{
    				$ids[] = $val['floor'];
    			}
    			$return['status']	= 'success';
    			$return['content']	= $ids;
    		}
    		else
    		{
    			$return['status']	= 'failure';
    			$return['content']	= '请先设置楼层信息';
    		}
    	}
    	else
    	{
    		$return['status']	= 'failure';
    		$return['content']	= '协议内容有误！';
    	}
    	$this->ajaxReturn($return);
    }

    public function getFloorByBuild1()
    {
    	$type = @$_POST['typ'];
    	$return = array();
    	if($type == 'json')
    	{
    		$build = $_POST['build'];
    		if(empty($build))
    		{
    			$return['status']	= 'failure';
    			$return['content']	= '数据错误！';
    		}
    		else
    		{
    			$hostel = new HostelModel();
    			$floor_ids = $hostel->where(array('build'=>$build))->order(array('floor'=>'asc'))->distinct(true)->field('floor')->select();
    			$ids = array();
    			if(!empty($floor_ids))
    			{
    				foreach($floor_ids as $key=>$val)
    				{
    					$ids[] = $val['floor'];
    				}
    				$return['status']	= 'success';
    				$return['content']	= $ids;
    			}
    			else
    			{
    				$return['status']	= 'failure';
    				$return['content']	= '请先设置楼层信息！';
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

    public function getNoByFloor()
    {
    	$type = @$_POST['typ'];
    	$return = array();
    	if($type == 'json')
    	{
    		$hostel = new HostelModel();
    		$hostel_list = $hostel->getHostel();
    		$cond = array();
    		if(empty($_POST['build']))
    		{
    			//给出默认的floor
    			$cond['build'] = $hostel_list[0]['build'];
    		}
    		else
    		{
    			$cond['build'] = $_POST['build'];
    		}
    		$hostel_list1 = $hostel->getHostel(array('build'=>$cond['build']),array('floor'=>"asc"));
    		if(empty($_POST['floor']))
    		{
    			$cond['floor'] = $hostel_list1[0]['floor'];
    		}
    		else
    		{
    			$cond['floor'] = $_POST['floor'];
    		}
    		$no_ids = $hostel->where($cond)->order(array('floor'=>"asc",'no'=>"asc"))->select();
    		$ids = array();
    		if(!empty($no_ids))
    		{
    			foreach($no_ids as $key=>$val)
    			{
    				$ids[$key]['id'] = $val['id'];
    				$ids[$key]['no'] = $val['no'];
    			}
    			$return['status']	= 'success';
    			$return['content']	= $ids;
    		}
    		else
    		{
    			$return['status']	= 'failure';
    			$return['content']	= '请先设置房间信息！';
    		}
    	}
    	else
    	{
    		$return['status']	= 'failure';
    		$return['content']	= '协议内容有误！';
    	}
    	$this->ajaxReturn($return);
    }

    public function getInfoByNo()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $hid = @$_POST['hid'];
            if(empty($hid))
            {
                $return['status']   = 'failure';
                $return['content']  = '传值错误！';
            }
            else
            {
                $hostel = new HostelModel();
                $hostel_info = $hostel->getHostel(array("id"=>$hid));
                $contain = $hostel_info[0]['contain'];
                if($contain == 0)
                {
                    $return['status']   = 'success';
                    $return['content']  = '此房间不能入住！';
                }
                else
                {
                    $student = new StudentModel();
                    $cond = array();
                    $cond['dormitory_id'] = $hid;
                    $student_list = $student->getStudent($cond);
                    $beds = array();
                    $bed_ids = array();
                    foreach($student_list as $key=>$val)
                    {
                        $bed_ids[] = $val['bed_no'];
                    }
                    for($i=1;$i<=$contain;$i++)
                    {
                        if(in_array($i,$bed_ids))
                        {
                            $beds[$i] = $i.'号床（已住）';
                        }
                        else
                        {
                            $beds[$i] = $i."号床";
                        }
                    }
                    $return['status']   = 'success';
                    $return['content']  = $beds;
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

//=========================================================================================
    //学生管理
    public function stuInfo()
    {
        $class = new ClassModel();
        $class_list = $class->getClass();
        $this->assign('classList',$class_list);
        $this->assign('classLists',json_encode($class_list));
        $this->display('stuInfo');
    }


    public function addStudent()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $student = new StudentModel();
            $cond = array();
            $cond['name'] = $_POST['name'];
            $cond['class_id'] = $_POST['class'];
            $cond['contact'] = $_POST['contact'];
            $cond['contact_phone'] = $_POST['phone'];
            $cond['sex'] = $_POST['sex'];
            $cond['iden'] = $_POST['iden'];
            $cond['number'] = $_POST['number'];
            $cond['note'] = $_POST['note'];
            if(!empty($_POST['photo']))
            {
                $cond['photo'] = $_POST['photo'];
            }
            $res = $student->addStudent($cond);
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
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

    public function editStudent()
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
    			$cond['name'] = $_POST['name'];
    			$cond['class_id'] = $_POST['class'];
    			$cond['contact'] = $_POST['contact'];
    			$cond['contact_phone'] = $_POST['phone'];
                $cond['sex'] = $_POST['sex'];
                $cond['iden'] = $_POST['iden'];
                $cond['number'] =  $_POST['number'];
    			$cond['note'] = $_POST['note'];
    			if(!empty($_POST['photo']))
    			{
    				$cond['photo'] = $_POST['photo'];
    			}
    			$student = new StudentModel();
    			$res = $student->editStudent($id,$cond);
    			if($res)
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

    public function getStudentList()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $class = new CLassModel();
            $class_list = $class->getAssocClass();

            $hostel = new HostelModel();
            $hostel_list = $hostel->getAssocHostel();

            $student = new StudentModel();
            $cond = array();
            if(!empty($_POST['sname']))
            {
                $cond['name'] = $_POST['sname'];
            }
            if(!empty($_POST['sclass']))
            {
                $cond['class_id'] = $_POST['sclass'];
            }
            $student_list = $student->getStudent($cond,array("class_id"=>"asc"),1,2000,false);
            $sex = array('女','男');
            $power = $this->getPower();
            if($power[0]==="0" || in_array(3,$power))
            {
            	$return['leader'] = 1;
            }
            else
            {
            	$return['leader'] = 0;
            }
            if(!empty($student_list))
            {
                foreach($student_list as $key=>$val)
                {
                    $student_list[$key]['class_text'] = $class_list[$val['class_id']]['name'];
                    if($return['leader'] == 1)
                    {
                    	$student_list[$key]['hostel'] = !empty($val['dormitory_id']) ? $hostel_list[$val['dormitory_id']]['build']."&nbsp;&nbsp;&nbsp;".$hostel_list[$val['dormitory_id']]['no']."&nbsp;&nbsp;&nbsp;".$val['bed_no'].'号床' : "<a href='javascript:void(0);' class='ruzhu' sign='".$val['id']."'>入住</a>";
                    }
                    else
                    {
                    	$student_list[$key]['hostel'] = !empty($val['dormitory_id']) ? $hostel_list[$val['dormitory_id']]['build']."&nbsp;&nbsp;&nbsp;".$hostel_list[$val['dormitory_id']]['no'] : "无";
                    }
                    $student_list[$key]['sex_text'] = $sex[$val['sex']];
                    $student_list[$key]['act_text'] = '无';
                }
                $return['status']   = 'success';
                $return['content']  = $student_list;
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

    public function delStudent()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['id'];
            if(!empty($id))
            {
                $student = new StudentModel();
                $res = $student->delStudent($id);
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
                $return['content']  = '传值错误！';
            }
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

    public function getStudentById()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['id'];
            if(!empty($id))
            {
                $student = new StudentModel();
                $student_info = $student->getStudent(array("id"=>$id));
                if(!empty($student_info))
                {
                    $return['status']   = 'success';
                    $return['content']  = $student_info[0];
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
                $return['content']  = '传值错误！';
            }
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

    //学生入住
    public function stuRuzhu()
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
    			$hid = $_POST['bid'];
    			$bno = $_POST['bno'];
    			$hostel = new HostelModel();
    			$hostel_info = $hostel->getHostel(array('id'=>$hid));
    			$contain = $hostel_info[0]['contain'];
    			if($contain == 0)
    			{
    				$return['status']	= 'failure';
    				$return['content']	= '此房间不能入住！';
    			}
    			else
    			{
    				$student = new StudentModel();
    				$num = $student->where(array('dormitory_id'=>$hid))->count();
    				if((int)$num >= (int)$contain)
    				{
    					$return['status']	= 'failure';
    					$return['content']	= '此房间人数已满，不能入住';
    				}
    				else
    				{
    					$cond = array();
    					$cond['dormitory_id'] = $hid;
    					$cond['bed_no'] = $bno;
    					$res = $student->editStudent($id,$cond);
    					if($res)
    					{
    						$return['status']	= 'success';
    						$return['content']	= '操作成功！';
    					}
    					else
    					{
    						$rturn['status']	= 'failure';
    						$return['content']	= '操作失败！';
    					}
    				}
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

   

//=========================================================================================
    //上课学生管理
    public function arrangeStu()
    {
    	$week = $_POST['week'];
    	if(empty($week))
    	{
    		$w = date("w");
    		$_POST['week'] = $w;
    	}
    	else
    	{
    		$w = $week;
    	}
        $syllabus = new SyllabusModel();
        $cond = array();
        if($w == 0)
        {
            $w = 7;
        }
        $cond['week'] = $w;
        $syllabus_list = $syllabus->getSyllabus($cond);
        foreach($syllabus_list as $k=>$v)
        {
            $list = explode(",",$v['student']);
            $syllabus_list[$k]['number'] = count($list);
        }
        $class = new ClassModel();
        $class_list = $class->getAssocClass();
        foreach($syllabus_list as $k=>$v)
        {
            $list = explode(",",$v['student']);
            if(!empty($v['student']))
            {
                $class_list[$v['room']][$v['time']]['count'] = count($list)."人";
            }
            else
            {
                $class_list[$v['room']][$v['time']]['count'] = "0人";
            }
            $class_list[$v['room']][$v['time']]['sid']   = $v['id'];
        }
        // echo "<pre>";
        // var_dump($class_list);die;
        $this->assign("syllabus",$syllabus_list);
        $this->assign("clist",$class_list);
        $this->display('arrange');
    }

    public function getStuByClass()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['id'];
            $syllabus = new SyllabusModel();
            $syllabus_list = $syllabus->getSyllabus(array('id'=>$id));
            $syllabus_list = array_values($syllabus_list);
            $stu_list = explode(",",$syllabus_list[0]['student']);

            $student = new StudentModel();
            $student_list = $student->getStudent(array(),array('class_id'=>"ASC"));

            $class = new ClassModel();
            $class_list = $class->getAssocClass();

            $left = array();
            $right = array();
            $ii = 0;
            foreach($student_list as $k=>$v)
            {
                if(in_array($v['id'],$stu_list))
                {
                    $left[$k]['id'] = $v['id'];
                    $left[$k]['name'] = $v['name'];
                }
                else
                {
                    $name = $class_list[$v['class']]['name'];
                    $right[$ii]['id'] = $v['id'];
                    $right[$ii]['name'] = $v['name'];
                    $right[$ii]['room'] = $class_list[$v['class_id']]['name'];
                    $ii++;
                }
            }
            $return['status']   = 'success';
            $return['content']['tleft'] = $left;
            $return['content']['tright'] = $right;
            $return['content']['ttitle'] = $class_list[$syllabus_list[0]['room']]['name']."教室  周".$syllabus_list[0]['week']."  第".$syllabus_list[0]['time']."节";
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

    //添加上课的学生
    public function addLessonStu()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['id'];
            $sid = $_POST['sid'];
            $syllabus = new SyllabusModel();
            $syllabus_list = $syllabus->getSyllabus(array('id'=>$id));
            $syllabus_list = array_values($syllabus_list);
            if(!empty($syllabus_list[0]['student']))
            {
                $stu_list = explode(",",$syllabus_list[0]['student']);
                $stu_list[] = $sid;
                $stu_row = implode(",",$stu_list);
            }
            else
            {
                $stu_row = $sid;
            }
            $cond = array();
            $cond['student'] = $stu_row;
            $res = $syllabus->editSyllabus($id,$cond);
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

    //减少上课的学生
    public function delLessonStu()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['id'];
            $sid = $_POST['sid'];
            $syllabus = new SyllabusModel();
            $syllabus_list = $syllabus->getSyllabus(array('id'=>$id));
            $syllabus_list = array_values($syllabus_list);
            $stu_list = explode(",",$syllabus_list[0]['student']);
            foreach($stu_list as $k=>$v)
            {
                if($v == $sid)
                {
                    unset($stu_list[$k]);
                }
            }
            $stu_row = implode(",",$stu_list);
            $cond = array();
            $cond['student'] = $stu_row;
            $res = $syllabus->editSyllabus($id,$cond);
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
//=============================================================================================================
    //晚自习学生设置
    public function arrangeNight()
    {
        $w = date('w');
        $night = new NightModel();
        $cond = array();
        if($w == 0)
        {
            $w = 7;
        }
        $cond['week'] = $w;
        $night_list = $night->getNight($cond);
        $class = new ClassModel();
        $class_list = $class->getAssocClass();
        foreach($night_list as $k=>$v)
        {
            $list = explode(",",$v['student']);
            if(!empty($v['student']))
            {
                $class_list[$v['room']][$v['time']]['count'] = count($list)."人";
            }
            else
            {
                $class_list[$v['room']][$v['time']]['count'] = "0人";
            }
            $class_list[$v['room']][$v['time']]['sid']   = $v['id'];
        }
        // echo "<pre>";
        // var_dump($class_list);die;
        $this->assign("night",$night_list);
        $this->assign("clist",$class_list);
        $this->display('arrangeNight');
    }

    public function getNightStu()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['id'];
            $night = new NightModel();
            $conds = array();
            $conds['week'] = date('w');
            $conds['room'] = $_POST['room'];
            $conds['time'] = $_POST['time'];
            $night_list = $night->getNight($conds);
            $night_list = array_values($night_list);
            $stu_list = explode(",",$night_list[0]['student']);

            $student = new StudentModel();
            $student_list = $student->getStudent(array(),array('class_id'=>"ASC"));

            $class = new ClassModel();
            $class_list = $class->getAssocClass();

            $left = array();
            $right = array();
            $ii = 0;
            foreach($student_list as $k=>$v)
            {
                if(in_array($v['id'],$stu_list))
                {
                    $left[$k]['id'] = $v['id'];
                    $left[$k]['name'] = $v['name'];
                }
                else
                {
                    $name = $class_list[$v['class']]['name'];
                    $right[$ii]['id'] = $v['id'];
                    $right[$ii]['name'] = $v['name'];
                    $right[$ii]['room'] = $class_list[$v['class_id']]['name'];
                    $ii++;
                }
            }
            $return['status']   = 'success';
            $return['content']['tleft'] = $left;
            $return['content']['tright'] = $right;
            $return['content']['ttitle'] = $class_list[$_POST['room']]['name']."教室 周".date('w')." 第".$_POST['time']."节";
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

    public function addNightStu()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $conds = array();
            $conds['time'] = $_POST['time'];
            $conds['week'] = date('w');
            $conds['room'] = $_POST['room'];
            $sid = $_POST['sid'];
            $night = new NightModel();
            $night_list = $night->getNight($conds);
            $night_list = array_values($night_list);
            if(!empty($night_list) && !empty($night_list[0]['student']))
            {
                $stu_list = explode(",",$night_list[0]['student']);
                $stu_list[] = $sid;
                $stu_row = implode(",",$stu_list);
            }
            else
            {
                $stu_row = $sid;
            }
            $cond = array();
            $cond['student'] = $stu_row;
            if(!empty($night_list))
            {
                $id = $night_list[0]['id'];
                $res = $night->editNight($id,$cond);
            }
            else
            {
                $conds['student'] = $stu_row;
                $res = $night->addNight($conds);
            }
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

    public function delNightStu()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $conds = array();
            $conds['room'] = $_POST['room'];
            $conds['time'] = $_POST['time'];
            $conds['week'] = date('w');
            $sid = $_POST['sid'];
            $night = new NightModel();
            $night_list = $night->getNight($conds);
            $night_list = array_values($night_list);
            $stu_list = explode(",",$night_list[0]['student']);
            foreach($stu_list as $k=>$v)
            {
                if($v == $sid)
                {
                    unset($stu_list[$k]);
                }
            }
            $stu_row = implode(",",$stu_list);
            $cond = array();
            $cond['student'] = $stu_row;
            $id = $night_list[0]['id'];
            $res = $night->editNight($id,$cond);
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


//============================================================================================================
    //教师管理
    public function viewTeacher()
    {
    	$year = new ClassYearModel();
    	$year_list = $year->getClassYear();
    	$this->assign('yearList',$year_list);
    	$this->assign('yearLists',json_encode($year_list));
    	$this->display('viewTeacher');
    }

    public function getTeacherList()
    {
    	$type = @$_POST['typ'];
    	$return = array();
    	if($type == 'json')
    	{
    		$year = new ClassYearModel();
    		$year_list = $year->getAssocList();
    		$leader = new LeaderModel();
    		$cond = array();
    		if(!empty($_POST['sname']))
    		{
    			$cond['name'] = $_POST['sname'];
    		}
    		if(!empty($_POST['syear']))
    		{
    			$cond['year_id'] = $_POST['syear'];
    		}
    		$leader_list = $leader->getLeader($cond,array('year_id'=>"asc"));
    		if(!empty($leader_list))
    		{
    			$power = $this->getPower();
    			if($power[0]==="0" || in_array(4,$power))
    			{
    				$return['leader'] = 1;
    				foreach($leader_list as $key=>$val)
	    			{
	    				$leader_list[$key]['year_text'] = $year_list[$val['year_id']]['name'];
	                    $leader_list[$key]['reset_text'] = "<a href='javascript:void(0);' class='reset' sign='".$val['id']."' title='重置后密码为：123456'>重置密码</a>";
	    			}
    			}
    			else
    			{
    				foreach($leader_list as $key=>$val)
	    			{
	    				$leader_list[$key]['year_text'] = $year_list[$val['year_id']]['name'];
	                    $leader_list[$key]['reset_text'] = "无";
	                    $leader_list[$key]['act_text'] = "无";
	    			}
	    			$return['leader'] = 0;
	    		}
    			$return['status']	= 'success';
    			$return['content']	= $leader_list;
    			
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
    		$return['content']	= '协议内容有误！';
    	}
    	$this->ajaxReturn($return);
    }

    public function addTeacher()
    {
    	$type = @$_POST['typ'];
    	$return = array();
    	if($type == 'json')
    	{
    		$leader = new LeaderModel();
    		$cond = array();
    		$cond['name'] = $_POST['name'];
    		$cond['year_id'] = $_POST['year'];
    		$cond['note'] = $_POST['note'];
            $cond['uname'] = $_POST['uname'];
            $cond['photo'] = $_POST['photo'];
            $leader->startTrans();
    		$res = $leader->addLeader($cond);
    		$cond1 = array();
            $cond1['nick'] = $_POST['name'];
            $cond1['name'] = $_POST['uname'];
            $cond1['type'] = 2;
            $pass = $_POST['pass'];
            $cond1['password'] = md5($pass);
            $member = new MemberModel();
            $cond2 = array();
            $cond2['name'] = $_POST['uname'];
            $re = $member->getMember($cond2);
            $res1 = $member->addMember($cond1);
            if(!$re)
            {
                if($res1 && $res)
                {
                    $leader->commit();
                    $return['status']   = 'success';
                    $return['content']  = '添加成功！';
                }
                else
                {
                    $leader->rollback();
                    $return['status']   = 'failure';
                    $return['content']  = '添加失败！';
                }
            }
            else
            {
                $leader->rollback();
                $return['status']   = 'failure';
                $return['content']  = '用户名已存在！';
            }
                
    	}
    	else
    	{
    		$return['status']	= 'failure';
    		$return['content']	= '协议内容有误！';
    	}
    	$this->ajaxReturn($return);
            
    }

    public function getTeacherById()
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
    			$leader = new LeaderModel();
    			$leader_info = $leader->getLeader(array("id"=>$id));
    			if(!empty($leader_info))
    			{
    				$return['status']	= 'success';
    				$return['content']	= $leader_info[0];
    			}
    			else
    			{
    				$return['status']	= 'failure';
    				$return['content']	= '数据错误！';
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

    public function editTeacher()
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
    			$cond = array();
    			$leader = new LeaderModel();
    			$cond['name'] = $_POST['name'];
    			$cond['year_id'] = $_POST['year'];
    			$cond['note'] = $_POST['note'];
    			if(!empty($_POST['photo']))
    			{
    				$cond['photo'] = $_POST['photo'];
    			}
    			$res = $leader->editLeader($id,$cond);
    			if($res)
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

    public function delTeacher()
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
    			$leader = new LeaderModel();
                $leader_info = $leader->getLeader(array("id"=>$id));
                $uname = $leader_info[0]['uname'];
                $member = new MemberModel();
                $member_info = $member->getMember(array('name'=>$uname));
                $mid = $member_info[0]['id'];
                $leader->startTrans();
    			$res = $leader->delLeader($id);
                $res2 = $member->delMember($mid);
    			if($res && $res2)
    			{
                    $leader->commit();
    				$return['status']	= 'success';
    				$return['content']	= '删除成功！';
    			}
    			else
    			{
                    $leader->rollback();
    				$return['status']	= 'failure';
    				$return['content']	= '删除失败！';
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

    public function resetTeacherPass()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['id'];
            if(empty($id))
            {
                $return['stauts']   = 'failure';
                $return['content']  = '传值错误！';
            }
            else
            {
                $leader = new LeaderModel();
                $leader_info = $leader->getLeader(array("id"=>$id));
                $uname = $leader_info[0]['uname'];
                $member = new MemberModel();
                $member_info = $member->getMember(array('name'=>$uname));
                $mid = $member_info[0]['id'];
                if(empty($mid))
                {
                    $return['status']   = 'failure';
                    $return['content']  = '数据错误！';
                }
                else
                {
                    $cond = array();
                    $cond['password'] = md5(123456);
                    $res = $member->editMember($mid,$cond);
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
            }
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }
    
 //=======================================================================================================================
    //学科管理
    public function addSubject()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
        	$name = $_POST['name'];
        	if(empty($name))
        	{
        		$return['status']	= 'failure';
        		$return['content']	= '传值错误！';
        	}
        	else
        	{
        		$subject = new SubjectModel();
        		$cond = array();
        		$cond['name'] = $name;
        		$re = $subject->getSubject($cond);
        		if($re)
        		{
        			$return['status']	= 'failure';
        			$return['content']	= '学科名称已存在！';
        		}
        		else
        		{
        			$res = $subject->addSubject($cond);
        			if($res)
        			{
        				$return['status']	= 'success';
        				$return['content']	= '添加成功！';
        			}
        			else
        			{
        				$return['status']	= 'failure';
        				$return['content']	= '添加失败！';
        			}
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

    public function viewSubject()
    {
        $this->display('viewSub');
    }

    public function getSubjectList()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $subject = new SubjectModel();
            $subject_list = $subject->getSubject();
            $power = $this->getPower();
            if($power[0]==="0" || in_array(5,$power))
            {
            	$return['leader'] = 1;
            }
            else
            {
            	$return['leader'] = 0;
            }
            if(!empty($subject_list))
            {
            	foreach($subject_list as $key=>$val)
            	{
            		$subject_list[$key]['act_text'] = "无";
            	}
                $return['status']   = 'success';
                $return['content']  = $subject_list;
            }
            else
            {
                $return['status']   = 'failure';
                $return['content']  = '暂无学科数据！';
            }
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

    public function delSubject()
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
                $subject = new SubjectModel();
                $res = $subject->delSubject($id);
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
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }


//================================================================================================================================
    //课表管理
    public function syllabus()
    {
        // var_dump($_POST['sclass']);
        $sclass = @$_POST['sclass'];
        if(!empty($sclass))
        {
            $this->assign('class_id',$sclass);
            $cond = array();
            $cond['room'] = $sclass;
            $syllabus = new SyllabusModel();
            $syllabus_list = $syllabus->getSyllabus($cond);

            $subject = new SubjectModel();
            $subject_list = $subject->getAssocSubject();

            // $teacher = new MemberModel();
            // $teacher_list = $teacher->getAssocMember(array('type'=>2))
            $leader = new LeaderModel();
            $teacher_list = $leader->getAssocList();

            foreach($syllabus_list as $k=>$v)
            {
                $syllabus_list[$k]['subject_text'] = $subject_list[$v['subject']]['name'];
                $syllabus_list[$k]['teacher_text'] = $teacher_list[$v['teacher']]['name'];
            }

            $this->assign('klist',$syllabus_list);
        }
        $class = new ClassModel();
        $class_list = $class->getAssocClass();
        $this->assign('class_name',$class_list[$sclass]['name']);
        $lists = $class->getClass(array(),array('name'=>"ASC"));
        $this->assign('clist',$lists);

        
        $this->display('syllabus');
    }

    public function updateSyllabus()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $cond = array();
            $cond['room'] = $_POST['room'];
            $cond['week'] = $_POST['week'];
            $cond['time'] = $_POST['time'];
            $syllabus = new SyllabusModel();
            $re = $syllabus->getSyllabus($cond);
            if($re)
            {
                $re = array_values($re);
                $id = $re[0]['id'];
                $edit_field = array();
                $edit_field['teacher'] = $_POST['teacher'];
                $edit_field['subject'] = $_POST['subject'];
                $res = $syllabus->editSyllabus($id,$edit_field);
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
            else
            {
                $cond['teacher'] = $_POST['teacher'];
                $cond['subject'] = $_POST['subject'];
                $res = $syllabus->addSyllabus($cond);
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

    public function todaySyllabus()
    {
    	$www = $_POST['week'];
    	if(empty($www))
    	{
    		$w = date('w');
        	$ww = (int)$w+1;
        	$_POST['week'] = $w;
    	}
        else
        {
        	$w = $www;
        }
        $syllabus = new SyllabusModel();
        $cond = array();
        $cond['week'] = $w;
        $syllabus_list = $syllabus->getSyllabus($cond);

        $subject = new SubjectModel();
        $subject_list = $subject->getAssocSubject();

        // $teacher = new MemberModel();
        // $teacher_list = $teacher->getAssocMember(array('type'=>2));
        $leader = new LeaderModel();
        $teacher_list = $leader->getAssocList();

        $newlist = array();
        foreach($syllabus_list as $k=>$v)
        {
            $newlist[$v['room']][$v['time']]['subject_text'] = $subject_list[$v['subject']]['name'];
            $newlist[$v['room']][$v['time']]['teacher_text'] = $teacher_list[$v['teacher']]['name'];
            $newlist[$v['room']]['length'] = 5;
        }

        $class = new ClassModel();
        $class_list = $class->getAssocClass();

        $this->assign("syllabus",$newlist);
        $this->assign("clist",$class_list);
        $this->display('todaySyllabus');
    }

//==============================================================================================================================
    //相机管理
    public function viewCamera()
    {
        $camera = new CameraModel();
        $camera_list = $camera->getCamera();
        $class = new ClassModel();
        $class_list =$class->getAssocClass();
        if(!empty($camera_list))
        {
            foreach($camera_list as $k=>$v)
            {
                if(!empty($v['room']))
                {
                    $camera_list[$k]['room_text'] = $class_list[$v['room']]['name'];
                }
                else
                {
                    $camera_list[$k]['room_text'] = '无';
                }

                if($v['status'] == 2)
                {
                    $camera_list[$k]['status_text'] = '开启';
                }
                else
                {
                    $camera_list[$k]['status_text'] = '关闭';
                }
                $start = strpos($v['url'],"192.168");
                $end = strrpos($v['url'],":");
                $len = $end-$start;
                $str = substr($v['url'],$start,$len);
                $camera_list[$k]['url_text'] = "http://".$str;
            }
        }
        $this->assign('clist',$class_list);
        $this->assign('camera',$camera_list);
        $this->display('viewCamera');
    }

    public function editCamera()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $id = $_POST['cid'];
            $room = $_POST['room'];
            $camera = new CameraModel();
            $cond = array();
            $cond['room'] = $room;
            $res = $camera->editCamera($id,$cond);
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


//================================================================
    //访客记录
    public function viewEntryRecord()
    {
    	$this->display("viewEntryRecord");
    }

    public function getEntryRecordList()
    {
    	$type = @$_POST['typ'];
    	$return = array();
    	if($type == 'json')
    	{
    		$record = new EntryRecordModel();
    		$cond = array();
    		$member = new MemberModel();
    		$member_list = $member->getAssocMember();
    		if(!empty($_POST['sphone']))
    		{
    			$cond['phone'] = $_POST['sphone'];
    		}
    		if(!empty($_POST['sname']))
    		{
    			$member_info = $member->getMember(array("name"=>$_POST['sname']));
    			$ids = array();
    			foreach($member_info as $k=>$v)
    			{
    				$ids[] = $v['id'];
    			}
    			$cond['creator_id'] = array("IN",$ids);
    		}
    		$order = array();
    		$order['id'] = 'DESC';
    		$record_list = $record->getEntryRecord($cond,$order);

    		if(!empty($record_list))
    		{
    			foreach($record_list as $key=>$val)
    			{
    				$record_list[$key]['creator'] = $member_list[$val['creator_id']]['name'];
    				$aa = @explode(",",$val['true_time']);
    				$record_list[$key]['true_time'] = implode("<br>", $aa);
    				if($val['phone'] !== '微信好友')
    				{
    					$record_list[$key]['way'] = "电话邀请：".$val['phone'];
    				}
    				else
    				{
    					$record_list[$key]['way'] = "微信好友";
    				}
    			}
    			$return['status']	= 'success';
    			$return['content']	= $record_list;
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
    		$return['content']	= '协议内容有误！';
    	}
    	$this->ajaxReturn($return);
    }

    //校内人员通行记录
    public function viewInsideRecord()
    {
    	$this->display("viewInsideRecord");
    }

    public function getMainEntranceRecordList()
    {
    	$type = @$_POST['typ'];
    	$return = array();
    	if($type == 'json')
    	{
    		$cond = array();
    		$member = new MemberModel();
    		$member_list = $member->getAssocMember();
    		if(!empty($_POST['sname']))
    		{
    			$cond_row = array();
    			$cond_row['nick'] = $_POST['name'];
    			$member_info = $member->getMember($cond_row);
    			$ids = array();
    			foreach($member_info as $k=>$v)
    			{
    				$ids[] = $v['id'];
    			}
    			$cond['alarm_id'] = array("IN",$ids);
    		}

    		$main_record = new MainEntranceRecordModel();
    		$main_record_list = $main_record->getMainEntranceRecord($cond,array("id"=>"DESC"));
    		if(!empty($main_record_list))
    		{
    			foreach($main_record_list as $key=>$val)
    			{
    				$main_record_list[$key]['person_name'] = $member_list[$val['alarm_id']]['nick'];
    				if($val['type'] == 'in')
    				{
    					$main_record_list[$key]['way'] = '进入';
    				}
    				else
    				{
    					$main_record_list[$key]['way'] = '离开';
    				}
    			}

    			$return['status']	= 'success';
    			$return['content']	= $main_record_list;
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
    		$return['content']	= '协议内容有误！';
    	}
    	$this->ajaxReturn($return);
    }

}