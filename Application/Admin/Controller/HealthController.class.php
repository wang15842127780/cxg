<?php
namespace Admin\Controller;
use Think\Controller;

use Admin\Model\MenuModel;
use Admin\Model\HealthItemModel;

use Home\Model\StudentModel;
use Home\Model\PointsLogModel;
use Home\Model\ClassModel;
use Home\Model\HostelModel;

class HealthController extends Controller{
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
        	case "73":
        	$this->hostelHealth();
        	break;
            case "74":
            $this->healthItem();
            break;
            default:
            break;
        }
	}

    public function hostelHealth()
    {
    	$menu = new MenuModel();
        $menus = $menu->getMenuTree();
        $main_menu = $menus[0]['sub_menu'];
        $this->assign('main_menu',$main_menu);
        $this->display("hostelHealth");
    }

    //获取学生的卫生分数
    public function getStudentsByPointsDesc()
    {
    	$type = @$_POST['typ'];
    	$return = array();
    	if($type == 'json')
    	{
    		$student = new StudentModel();
    		$class = new ClassModel();
    		$hostel = new HostelModel();
    		$cond = array();
            $order = array();
            $order['points'] = "ASC";
    		$student_list = $student->getStudent($cond,$order,1,100,false);
    		$class_list = $class->getAssocClass();
    		$hostel_list = $hostel->getAssocHostel();
    		if(!empty($student_list))
    		{
    			foreach($student_list as $key=>$val)
    			{
    				$student_list[$key]['class_text'] = $class_list[$val['class_id']]['name'];
    				$student_list[$key]['hostel_text'] = $hostel_list[$val['dormitory_id']]['build']." ".$hostel_list[$val['dormitory_id']]['no'];
    				$student_list[$key]['act_text'] = "<a href='javascript:void(0);' class='detail' sign='".$val['id']."'>查看详情</a>";
    			}
    			$return['status']	= 'success';
    			$return['content']	= $student_list;
    		}
    		else
    		{
    			$return['status']	= 'failure';
    			$return['content'] 	= '暂无数据！';
    		}
    	}
    	else
    	{
    		$return['status']	= 'failure';
    		$return['content']	= '协议内容有误！';
    	}
    	$this->ajaxReturn($return);
    }

    //获取学生的卫生分数详情
    public function getDetailByStudentId()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $sid = $_POST['sid'];
            if(empty($sid))
            {
                $return['status']   = 'failure';
                $return['content']  = '传值错误！';
            }
            else
            {
                $points = new PointsLogModel();
                $student = new StudentModel();
                $class = new ClassModel();
                $class_list = $class->getAssocClass();
                $student_info = $student->getStudent(array("id"=>$sid),array(),1,100,false);
                $student_name = $student_info[0]['name'];
                $class_text = $class_list[$student_info[0]['class_id']]['name'];
                $cond = array();
                $cond['student_id'] = $sid;
                $cond['points_date'] = array("gt",date("Y-m-1 00:00:00"));
                $points_list = $points->getPointsLog(array("student_id"=>$sid),array("points_date"=>"desc"));
                $new_list = array();
                $k = 0;
                foreach($points_list as $key=>$val)
                {
                    $ll = explode(",",$val['points_detail']);
                    foreach($ll as $k=>$v)
                    {
                        $kk+=1;
                        $new_list[$kk] = $val;
                        $new_list[$kk]['points_details'] = $v;
                        $new_list[$kk]['student_name'] = $student_name;
                        $new_list[$kk]['class_text'] = $class_text;
                    }
                }
                if(!empty($new_list))
                {
                    $return['status']   = 'success';
                    $return['content']  = $new_list;
                }
                else
                {
                    $return['status']   = 'failure';
                    $return['content']  = '暂无扣分记录！';
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

    //按宿舍查找学生分数
    public function getHostelByGradeAsc()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $hostel_list = array();
            $student = new StudentModel();
            $hostel = new HostelModel();
            $student_list = $student->field('id,name,dormitory_id,points')->order('dormitory_id')->select();
            $hostel_lists = $hostel->getAssocHostel();
            foreach($student_list as $key=>$val)
            {
                if(!empty($val['dormitory_id']))
                {
                    if($hostel_list[$val['dormitory_id']]['min']<=0)
                    {
                        $hostel_list[$val['dormitory_id']]['min'] = 100;
                    }
                    if($hostel_list[$val['dormitory_id']]['min']>$val['points'])
                    {
                        $hostel_list[$val['dormitory_id']]['min'] = $val['points'];
                    }
                    $hostel_list[$val['dormitory_id']][] = $val['points'];
                }
            }

            foreach($hostel_list as $k=>$v)
            {
                if($v['min']>=90)
                {
                    $hostel_list[$k]['grade'] = '优';
                }
                elseif($v['min']>=80)
                {
                    $hostel_list[$k]['grade'] = '良好';
                }
                elseif($v['min']>=70)
                {
                    $hostel_list[$k]['grade'] = '中等';
                }
                elseif($v['min']>=60)
                {
                    $hostel_list[$k]['grade'] = '及格';
                }
                else
                {
                    $hostel_list[$k]['grade'] = '差';
                }
                $hostel_list[$k]['act_text'] = "<a href='javascript:void(0);' class='hostel_details' sign=".$k.">查看详情</a>";
                $hostel_list[$k]['hostel'] = $hostel_lists[$k]['build']." ".$hostel_lists[$k]['no'];
            }
            if(true)
            {
                $return['status']   = 'success';
                $return['content']  = $hostel_list;
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

    //获取每个宿舍的人员分数
    public function getDetailByHostelId()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $hid = $_POST['hid'];
            if(empty($hid))
            {
                $return['status']   = 'failure';
                $return['content']  = '传值错误！';
            }
            else
            {
                $hostel = new HostelModel();
                $hostel_list = $hostel->getAssocHostel();
                $class = new ClassModel();
                $class_list = $class->getAssocClass();
                $student = new StudentModel();
                $cond = array();
                $cond['dormitory_id'] = $hid;
                $student_list = $student->getStudent($cond);
                foreach($student_list as $key=>$val)
                {
                    $student_list[$key]['hostel_text'] = $hostel_list[$val['dormitory_id']]['build']." ".$hostel_list[$val['dormitory_id']]['build'];
                    $student_list[$key]['class_text'] = $class_list[$val['class_id']]['name'];
                }
                if(true)
                {
                    $return['status']   = 'success';
                    $return['content']  = $student_list;
                }
                else
                {
                    $return['status']   = 'failure';
                    $return['content']  = '暂无数据！';
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

    //宿舍扣分项目管理 

    public function healthItem()
    {
        $menu = new MenuModel();
        $menus = $menu->getMenuTree();
        $main_menu = $menus[0]['sub_menu'];
        $this->assign('main_menu',$main_menu);
        $this->display("healthItem");
    }

    public function getHealthItem()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $item = new HealthItemModel();
            $item_list = $item->getHealthItem();
            if(!empty($item_list))
            {
                $return['status']   = 'success';
                $return['content']  = $item_list;
            }
            else
            {
                $return['status']   = 'failure';
                $return['content']  = '暂无扣分项目！';
            }
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

    public function addHealthItem()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $item = new HealthItemModel();
            $cond = array();
            $name = $_POST['item'];
            $score = abs((int)$_POST['score']);
            $cond['item'] = $name;
            $cond['score'] = $score;
            $res = $item->addHealthItem($cond);
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

    public function delHealthItem()
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
                $item = new HealthItemModel();
                $res = $item->delHealthItem($id);
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
	
   
}


?>