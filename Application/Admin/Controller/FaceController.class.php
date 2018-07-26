<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Cache\Driver\Redis;
use Home\Model\ManageModel;
use Home\Model\MemberModel;

use Admin\Model\MenuModel;
use Admin\Model\FaceModel;
use Admin\Model\LeaderModel;
use Admin\Model\ClassYearModel;

class FaceController extends Controller{
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

        	case "78":
        	$this->faceIndex();
        	break;
            default:
            header("Location:/cxg/index.php?m=Admin");
            break;
        }
        // $menu = new MenuModel();
        // // $main_menu = $menu->getMenu(array('parent_id'=>7));
        // $menus = $menu->getMenuTree();
        // $main_menu = $menus[0]['sub_menu'];
        // $this->assign('main_menu',$main_menu);
        // // $this->assign("menu",$menus);
        // $this->display('index');
	}

	public function faceIndex()
	{
        $menu = new MenuModel();
        // $main_menu = $menu->getMenu(array('parent_id'=>7));
        $menus = $menu->getMenuTree();
        $main_menu = $menus[0]['sub_menu'];
        $this->assign('main_menu',$main_menu);
        // $this->assign("menu",$menus);
        $this->display("face");
	}

	//获取人脸信息
    public function getFace()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $face = new FaceModel();
            $cond = array();
            if(!empty($_POST['sname']))
            {
            	$cond['name'] = $_POST['sname'];
            }
            $face_list = $face->getFace($cond,array(),1,1000);
            if(!empty($face_list))
            {
            	foreach($face_list as $key=>$val)
            	{
            		if($val['bind_id']==0 || empty($val['bind_id']))
            		{
            			$face_list[$key]['teacher'] = '否';
            		}
            		else
            		{
            			$face_list[$key]['teacher'] = '是';
            		}
            		$face_list[$key]['image'] = "<a href='javascript:void(0);' class='photo' sign='".$val['id']."'>查看图片</a>";
            	}
                $return['status']   = 'success';
                $return['content']  = $face_list;
            }   
            else
            {
                $return['status']   = 'failure';
                $return['content']  = '暂无人脸信息！';
            }
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

    //获取人脸照片
    public function getFaceById()
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
    			$face = new FaceModel();
    			$face_info = $face->getFace(array("id"=>$id));
    			$photo = $face_info[0]['image'];
    			if(!empty($photo))
    			{
    				$return['status']	= 'success';
    				$return['content']	= $photo;
    			}
    			else
    			{
    				$return['status']	= 'failure';
    				$return['content']	= '照片信息错误！';
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

    //删除人脸信息
    public function delFace()
    {
    	$type = @$_POST['typ'];
    	$return = array();
    	if($type == 'json')
    	{
    		$face = new FaceModel();
    		$id = @$_POST['id'];
    		if(empty($id))
    		{
    			$return['status']	= 'failure';
    			$return['content']	= '传值错误！';
    		}
    		else
    		{
    			$face_info = $face->getFace(array("id"=>$id));

    			$ddd = array();
	    		$ddd['act'] = 'delPersonFace';
	    		$ddd['name'] = $face_info[0]['name'];
	    		$ddd['id'] = $id;
	    		$photo = $face_info[0]['image'];
	            $img = explode(",",$photo)[1];
	            $img1 = str_replace(array("\r\n", "\r", "\n"), "", $img);
	            $ddd['photo'] = $img1;
	    		$fff = json_encode($ddd);
	    		$redis = new \Redis();

	    		$face->startTrans();
	            $res0 = $redis->connect("192.168.1.234",6379);
	            $res1 = $redis->publish("entry_door",$fff);

    			$res = $face->delFace($id);
    			if($res && $res1)
    			{
    				$face->commit();
    				$return['status']	= 'success';
    				$return['content']	= '删除成功！';
    			}
    			else
    			{
    				$face->rollBack();
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

    //新增人脸信息
    public function addFace()
    {
    	$type = @$_POST['typ'];
    	$return = array();
    	if($type == 'json')
    	{
    		$add_row = array();
    		$add_row['name'] = $_POST['name'];
    		$add_row['note'] = $_POST['note'];
    		$add_row['image'] = $_POST['photo'];
    		$add_row['id'] = $this->getLastFaceId();
    		if($_POST['teacher'] != '否')
    		{
    			$add_row['bind_id'] = $_POST['teacher'];
    		}
    		$ddd = array();
    		$ddd['act'] = 'addPersonFace';
    		$ddd['name'] = $_POST['name'];
    		$ddd['id'] = $this->getLastFaceId();
    		$photo = $_POST['photo'];
            $img = explode(",",$photo)[1];
            $img1 = str_replace(array("\r\n", "\r", "\n"), "", $img);
            $ddd['photo'] = $img1;
    		$fff = json_encode($ddd);
    		$redis = new \Redis();
            $res0 = $redis->connect("192.168.1.234",6379);
            $res1 = $redis->publish("entry_door",$fff);
    		$face = new FaceModel();
    		$face->startTrans();
    		$res = $face->addFace($add_row);
    		if($res && $res1>=0)
    		{
    			$face->commit();
    			$return['status']	= 'success';
    			$return['content']	= '添加成功！';
    		}
    		else
    		{
    			$commit->rollBack();
    			$return['status']	= 'failure';
    			$return['content']	= '添加失败！';
    		}
    	}
    	else
    	{
    		$return['status']	= 'failure';
    		$return['content']	= '协议内容有误！';
    	}
    	$this->ajaxReturn($return);
    }

    //获取教师信息
    public function getTeacherList()
    {
    	$type = @$_POST['typ'];
    	$return = array();
    	if($type == 'json')
    	{
    		$class = new ClassYearModel();
    		$leader = new LeaderModel();
    		$class_list = $class->getAssocList();
    		$leader_list = $leader->getLeader(array(),array(),1,500);
    		$new_list = array();
    		if(!empty($leader_list))
    		{
    			foreach($leader_list as $key=>$val)
    			{
    				$new_list[$val['year_id']]['class_name'] = $class_list[$val['year_id']]['name'];
    				$new_list[$val['year_id']]['list'][$key]['id']	= $val['id'];
    				$new_list[$val['year_id']]['list'][$key]['name']	= $val['name'];
    			}
    			$return['status']	= 'success';
    			$return['content']	= $new_list;
    		}
    		else
    		{
    			$return['status']	= 'failure';
    			$return['content']	= '暂无教师信息！';
    		}
    	}
    	else
    	{
    		$return['status']	= 'failure';
    		$return['content']	= '协议内容有误！';
    	}
    	$this->ajaxReturn($return);
    }
    //获取人脸库最新的ID
    public function getLastFaceId()
    {
    	$face = new FaceModel();
    	$face_list = $face->getFace(array(),array("id"=>"desc"));
    	$id = $face_list[0]['id'];
    	$new_id = (int)$id+1;
    	return $new_id;
    }
}





?>