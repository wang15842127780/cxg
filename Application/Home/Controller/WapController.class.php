<?php
namespace Home\Controller;
use Think\Controller;
use Admin\Model\StudentLeaveModel;
use Admin\Model\ClassYearModel;
use Home\Model\StudentModel;
use Home\Model\ClassModel;
use Admin\Model\LeaderModel;
use Home\Model\MemberModel;
use Home\Model\ManageModel;


class WapController extends Controller{

//====================================================================================================================================
	//请假管理 
	public function getInfo()
	{
		$type = @$_POST['typ'];
		$return = array();
		if($type == 'json')
		{
			$id = $_COOKIE['id'];
			$aid = $_COOKIE['aid'];
			$info = array();   //返回值的数组
			
			//获取学生请假信息(数据指的是需要审批的)
			if(empty($aid))
			{
				$info['leave'] = 0;
			}
			else
			{
				$leave = new StudentLeaveModel();
				$year = new ClassYearModel();
				$leave_cond = array();
				//判断是否为年级主任
				$year_info = $year->getClassYear(array('director_id'=>$aid));
				if(!empty($year_info))
				{
					$leave_cond['year_id'] = $year_info[0]['id'];
				}
				$leave_cond['status'] = array("IN",array(3,4));
				$count = $leave->where($leave_cond)->count();
				$info['leave'] = $count;
				$manage = new ManageModel();
				$manage_info = $manage->getManage(array("id"=>$aid));
				$power = $manage_info[0]['power'];
				$power_arr = @explode(",",$power);
				if(!($power==="0" || in_array(6,$power_arr)))
				{
					$info['leave'] = 0;
				}

			}

			if(true)
			{
				$return['status']	= 'success';
				$return['content']	= $info;
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

	public function getLeaveInfo()
	{
		$type = @$_POST['typ'];
		$return = array();
		if($type == 'json')
		{
			//请假记录   可以获取所有的记录
			$cond = array();
			$cond['status']	= array("IN",array(1,2,3,4,5,6,7));
			//判断是否为后台用户
			$aid = $_COOKIE['aid'];
			 $id = $_COOKIE['id'];
			if(!empty($aid))
			{
				//查看是否为年级主任
				$year = new ClassYearModel();
				$year_info = $year->getClassYear(array('director_id'=>$aid));
				if(!empty($year_info))
				{
					$cond['year_id'] = $year_info[0]['id'];
				}
			}
			else
			{
				//查看是否为班主任
	            $member = new MemberModel();
	            $member_info = $member->getMember(array('id'=>$id));
	            $uname = $member_info[0]['name'];
	            $leader = new LeaderModel();
	            $leader_info = $leader->getLeader(array('uname'=>$uname));
	            if(!empty($leader_info))
	            {
	                $lid = $leader_info[0]['id'];
	                $class = new ClassModel();
	                $class_info = $class->getClass(array('leader_id'=>$lid));
	                if(!empty($class_info))
	                {
	                    $class_id = $class_info[0]['id'];
	                    $student = new StudentModel();
	                    $student_list = $student->getStudent(array('class_id'=>$class_id));
	                    $ids = array();
	                    foreach($student_list as $key=>$val)
	                    {
	                        $ids[] = $val['id'];
	                    }
	                    $cond['student_id'] = array('IN',$ids);
	                }
	                else
	                {
	                	$cond['student_id'] = array('lt',0);
	                }
	            }
			}
			$status = array(
				1=>'待提交',
				3=>'待签收',
				4=>'待审核',
				5=>'已批准',
				6=>'已完成',
				7=>'已退回'
			);
			$leave = new StudentLeaveModel();
			$leave_list = $leave->getStudentLeave($cond,array('id'=>'desc'));
            $student = new StudentModel();
            $student_list = $student->getAssocStudent();
            $class = new ClassModel();
            $class_list = $class->getAssocClass();
            foreach($student_list as $k=>$v)
            {
                $student_list[$k]['class_text'] = $class_list[$v['class_id']]['name'];
            }
            if(!empty($aid))
            {
            	$manage = new ManageModel();
            	$manage_info = $manage->getManage(array("id"=>$aid));
            	$power = $manage_info[0]['power'];
            	$power_arr = @explode(",",$power);
            	if($power==="0" || in_array(6,$power_arr))
            	{
            		$cond['status']	= array('IN',array(3,4));
	            	$count = $leave->where($cond)->count();
	            	$return['content']['leader'] = 1;
	            	$return['content']['count'] = $count;
            	}
	            else
	            {
	            	$return['content']['leader'] = 0;
	            }	
            }
            else
            {
            	$return['content']['leader'] = 0;
            }
            if(!empty($leave_list))
            {
                foreach($leave_list as $key=>$val)
                {
                    $leave_list[$key]['status_text'] = $status[$val['status']];
                    $leave_list[$key]['student_text'] = $student_list[$val['student_id']]['name'];
                    $leave_list[$key]['class_text'] = $student_list[$val['student_id']]['class_text'];
                    $leave_list[$key]['photo'] = $student_list[$val['student_id']]['photo'];
                }
                $return['status']   = 'success';
                $return['content']['list']  = $leave_list;
            }
            else
            {
                $return['status']   = 'failure';
                $return['content']['info']  = '暂无数据！';
            }

		}
		else
		{
			$return['status']	= 'failure';
			$return['content']	= '协议内容有误！';
		}
		$this->ajaxReturn($return);
	}


	//查询待审批的假条
	public function getCheckInfo()
	{
		$type = @$_POST['typ'];
		$return = array();
		if($type == 'json')
		{
			//请假记录   获取除了3，4的记录
			$cond = array();
			$cond['status'] = array("IN",array(3,4));
			//判断是否为后台用户
			$aid = $_COOKIE['aid'];
			 $id = $_COOKIE['id'];
			if(!empty($aid))
			{
				//查看是否为年级主任
				$year = new ClassYearModel();
				$year_info = $year->getClassYear(array('director_id'=>$aid));
				if(!empty($year_info))
				{
					$cond['year_id'] = $year_info[0]['id'];
				}

			}
			$status = array(
				1=>'待提交',
				3=>'待签收',
				4=>'待审核',
				5=>'已批准',
				6=>'已完成',
				7=>'已退回'
			);
			$leave = new StudentLeaveModel();
			$leave_list = $leave->getStudentLeave($cond,array('id'=>'desc'));
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
                    $leave_list[$key]['photo'] = $student_list[$val['student_id']]['photo'];
                }
                $return['status']   = 'success';
                $return['content']['list']  = $leave_list;
            }
            else
            {
                $return['status']   = 'failure';
                $return['content']['info']  = '暂无数据！';
            }

		}
		else
		{
			$return['status']	= 'failure';
			$return['content']	= '协议内容有误！';
		}
		$this->ajaxReturn($return);
	}

	public function checkLeave()
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
				$leave = new StudentLeaveModel();
				$cond = array();
				$cond['status']	= $_POST['status'];
				$cond['leader_note'] = $_POST['note'];
				$cond['auditby'] = $_COOKIE['user'];
				$res = $leave->editStudentLeave($id,$cond);
				if($res)
				{
					$return['status']	= 'success';
					$return['content']	= '操作成功！';
				}
				else
				{
					$return['status']	= 'failure';
					$return['content']	= '操作失败！';
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

	public function getLeaveById()
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
				$student = new StudentModel();
				$student_list = $student->getAssocStudent();
				$class = new ClassModel();
				$class_list = $class->getAssocClass();
				if(!empty($student_list))
				{
					foreach($student_list as $k=>$v)
					{
						$student_list[$k]['class_text'] = $class_list[$v['class_id']]['name'];
					}
				}
				$leave = new StudentLeaveModel();
				$leave_info = $leave->getStudentLeave(array('id'=>$id));
				$info = $leave_info[0];
				$status = array(
					1=>'待提交',
					3=>'待签收',
					4=>'待审批',
					5=>'已批准',
					6=>'已完成',
					7=>'已退回'
				);
				$aid = $_COOKIE['aid'];
				if(!empty($aid))
				{
					$manage = new ManageModel();
					$manage_info = $manage->getManage(array("id"=>$aid));
					$power = $manage_info[0]['power'];
					$power_arr = @explode(",",$power);
					if($power==="0" || in_array(6,$power_arr))
					{
						$info['power'] = 1;
					}
					else
					{
						$info['power'] = 0;
					}
				}
				else
				{
					$info['power'] = 0;
				}
				if(!empty($info))
				{
					$info['student_text'] = $student_list[$info['student_id']]['name'];
					$info['class_text'] = $student_list[$info['student_id']]['class_text'];
					$info['photo_text'] = $student_list[$info['student_id']]['photo'];
					$info['status_text'] = $status[$info['status']];
					$return['status']	= 'success';
					$return['content']	= $info;
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

	public function addStudentInfo()
	{
		$type = @$_POST['typ'];
		$return = array();
		if($type == 'json')
		{
			$id = $_COOKIE['id'];
			$aid = $_COOKIE['aid'];
			if(!empty($aid))
			{
				$return['content']['types'] = 1;
				//获取年组
				$year = new ClassYearModel();
				$year_info = $year->getClassYear(array('director_id'=>$aid));
				if(!empty($year_info))
				{
					$return['content']['list'] = $year_info;
				}
				else
				{
					$lists = $year->getClassYear();
					$return['content']['list'] = $lists;
				}
			}
			else
			{
				$return['content']['types'] = 2;
				$member = new MemberModel();
				$member_info = $member->getMember(array('id'=>$id));
				$uname = $member_info[0]['name'];
				//根据用户名查找leader表。看是否为班主任
				$leader = new LeaderModel();
				$leader_info = $leader->getLeader(array('uname'=>$uname));
				if(!empty($leader_info))
				{
					$lid = $leader_info[0]['id'];
					$class = new ClassModel();
					$class_info = $class->getClass(array('leader_id'=>$lid));
					$cid = $class_info[0]['id'];
					$student = new StudentModel();
					$student_list = $student->getStudent(array('class_id'=>$cid));
					$return['content']['list'] = $student_list;
				}
				else
				{
					$return['content']['list'] = '';
				}
			}

			if(!empty($return['content']['list']))
			{
				$return['status']	= 'success';
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
		$this->ajaxReturn($return);
	}
}

?>