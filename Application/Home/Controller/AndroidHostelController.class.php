<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\PointsLogModel;
use Home\Model\StudentModel;
use Home\Model\MemberModel;
use Home\Model\ClassModel;
use Home\Model\HostelModel;

use Admin\Model\HealthItemModel;
/**
* @param author Yongjun Wang
* @param 25/04/2018
*/
class AndroidHostelController extends Controller {

	/**
	* 宿舍扣分并插入日志
	* @param 学生ID		uid
	* @param 内容		con
	* @param 扣除的分数	score
	* @return 			return
	*/
   public function addPointsLog(){
        $type = @$_GET['types'];
        $return = array();
        if($type == 'json')
        {
        	$uid = $_GET['uid'];
        	if(empty($uid))
        	{
        		$return['status']	= 'failure';
        		$return['content']	= '传值错误！';
        	}
        	else
        	{
        		$score = $_GET['score'];
        		$con = $_GET['con'];
            $aid = $_GET['aid'];
            $points = new PointsLogModel();
        		$cond = array();
        		$cond['student_id'] = $uid;
        		$cond['points_date'] = date("Y-m-d");
        		$cond['points_detail'] = $con;
            $cond['points_editor'] = $this->getMemberNameById($aid);
            $cond['points_reduce'] = $score;
        		$points->startTrans();
        		$res = $points->addPointsLog($cond);

                $student = new StudentModel();
        		$student_info = $student->getStudent(array("id"=>$uid));
        		$pnum = $student_info[0]['points'];
        		$enum = $pnum - (int)$score;
        		$cond1 = array();
        		$cond1['points'] = $enum;
        		$res1 = $student->editStudent($uid,$cond1);
                if($res && $res1)
                {
                    $points->commit();
                    $return['status']   = 'success';
                    $return['content']  = '操作成功！';
                }
                else
                {
                    $points->rollBack();
                    $return['status']   = 'failure';
                    $return['content']  = '操作失败！';
                }
        	}
        }
        else
        {
        	$return['status']	= 'failure';
        	$return['content']	= '协议内容有误！';
        }
        echo json_encode($return);
   }

   /**
   * @author Yongjun Wang
   * Created 28/04/2018
   * 获取优秀个人卫生信息
   */
   public function getExcellentPerson()
   {
   		$type = @$_GET['types'];
   		$return = array();
   		if($type == 'json')
   		{
   			$student = new StudentModel();
   			$class = new ClassModel();
   			$hostel = new HostelModel();

   			$sort = @$_GET['sort'];
   			$cond = array();
   			$cond['dormitory_id'] = array("gt",0);
   			$order = array();
   			if(empty($sort))
   			{
   				$order['points'] = "ASC";
   			}
   			$student_list = $student->getStudent($cond,$order,1,100,false);

   			$class_list = $class->getAssocClass();
   			$hostel_list = $hostel->getAssocHostel();

   			if(!empty($student_list))
   			{
   				foreach($student_list as $key=>$val)
   				{
   					$student_list[$key]['class_text'] = $class_list[$val['class_id']]['name'];
   					$student_list[$key]['hostel_text'] = $hostel_list[$val['dormitory_id']]['build']." ".$hostel_list[$val['dormitory_id']]['no'];
   				}
   				$return['status']	= 'success';
   				$return['content']	= $student_list;
   			}
   			else
   			{
   				$return['status']	= 'failure';
   				$return['content']	= '暂无学生数据！';
   			}
   		}
   		else
   		{
   			$return['status']	= 'failure';
   			$return['content']	= '协议内容有误！';
   		}
   		echo json_encode($return);
   }

   /**
   * @author Yongjun Wang
   * Created 07/05/2018
   * 获取优秀个人卫生信息
   */
   public function getExcellentHostel()
   {
   		$type = @$_GET['types'];
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
                $hostel_list[$k]['build'] = $hostel_lists[$k]['build'];
                $hostel_list[$k]['no'] = $hostel_lists[$k]['no'];
                $hostel_list[$k]['ids'] = $k;
            }
            $new_list = array();
            foreach($hostel_list as $kk=>$vv)
            {
            	$new_list[] = $vv;
            }
            if(true)
            {
                $return['status']   = 'success';
                $return['content']  = $new_list;
            }
            else
            {
                $return['status']   = 'failure';
                $return['content']  = '暂无数据！';
            }
   		}
   		else
   		{
   			$return['status']	= 'failure';
   			$return['content']	= '协议内容有误！';
   		}
   		echo json_encode($return);
   }

   //获取学生宿舍评分的详情
   public function getExcellentHostelDetail()
   {
   		$type = @$_GET['types'];
   		$return = array();
   		if($type == 'json')
   		{
   			$hid = $_GET['hid'];
   			if(empty($hid))
   			{
   				$return['status']	= 'failure';
   				$return['content']	= '传值错误！';
   			}
   			else
   			{
   				$hostel = new HostelModel();
   				$student = new StudentModel();
   				$class = new ClassModel();

   				$cond = array();
   				$hostel_list = $hostel->getAssocHostel();
   				$class_list = $class->getAssocClass();
   				$cond['dormitory_id'] = $hid; 
   				$student_list = $student->getStudent($cond);
   				foreach($student_list as $key=>$val)
   				{
   					$student_list[$key]['class_text']	= $class_list[$val['class_id']]['name'];
   					$student_list[$key]['hostel_text']	= $hostel_list[$val['dormitory_id']]['build']." ".$hostel_list[$val['dormitory_id']]['no'];
   				}
   				if(true)
   				{
   					$return['status']	= 'success';
   					$return['content']	= $student_list;
   				}
   				else
   				{
   					$return['status']	= 'failure';
   					$return['content']	= '暂无学生数据！';
   				}
   			}
   		}
   		else
   		{
   			$return['status']	= 'failure';
   			$return['content']	= '协议内容有误！';
   		}
   		echo json_encode($return);
   }

   //扫码后获取学生信息
   public function getStudentInfo()
   {
      $type = @$_GET['types'];
      $return = array();
      if($type == 'json')
      {
        $sid = $_GET['sid'];
        if(empty($sid))
        {
          $return['status']   = 'failure';
          $return['content']  = '传值错误！';
        }
        else
        {
          $student = new StudentModel();
          $student_info = $student->getStudent(array("id"=>$sid));
          if(!empty($student_info))
          {
            //substr($student_assoc_list[$val['student_id']]['photo'],23);把学生照片变成完整 的base64
            $ss = $student_info[0];
            $ss['photo_text'] = substr($ss['photo'],23);
            $return['status']   = 'success';
            $return['content']  = $ss;
          }
          else
          {
            $return['status']   = 'failure';
            $return['content']  = '该床铺暂无学生！';
          }
        }
      }
      else
      {
        $return['status']   = 'failure';
        $return['content']  = '协议内容有误！';
      }
      echo json_encode($return);
   }

   /** 
   * @author  Yongjun Wang
   * Created 31/05/2018
   * Function 获取学生宿舍的扣分项
   */
   public function getHealthItem()
   {
        $type = @$_GET['types'];
        $return = array();
        if($type == 'json')
        {
            $item = new HealthItemModel();
            $list = $item->getHealthItem();
            if(!empty($list))
            {
                $return['status']   = 'success';
                $return['content']  = $list;
            }
            else
            {
                $return['status']   = 'failure';
                $return['content']  = '请先添加扣分项目';
            }
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        echo json_encode($return);

   }

   //公用方法（获取工作人员的姓名）
   public function getMemberNameById($id)
   {
        $member = new MemberModel();
        $member_info = $member->getMember(array("id"=>$id));
        return $member_info[0]['nick'];
   }
}