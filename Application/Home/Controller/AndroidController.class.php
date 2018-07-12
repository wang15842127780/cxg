<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\MemberModel;
use Home\Model\ManageModel;
use Home\Model\ClassModel;
use Home\Model\StudentModel;
use Home\Model\StudentLeaveModel;
use Admin\Model\ClassYearModel;
use Admin\Model\LeaderModel;

class AndroidController extends Controller{

//====================================================================================================================================
	//用户登录
	/*
	*	说明power
	*	0年级主任   权限最高   有添加和审批的权限
	*	1班级主任   能为学生填写假条
	*	2后台人员   不能添加  但是可是审批
	*/
	public static $status_list = array(1=>"待提交",3=>"待签收",4=>"待审核",5=>"已通过",6=>"已完成",7=>"已退回");
	public function doLog()
	{
		$type = @$_GET['types'];
		$ret = "";
		if($type == 'json')
		{
			$member = new MemberModel();
			$name = $_GET['Name'];
			$pass = $_GET['Pass'];
			$cond = array();
			$cond['name'] = $name;
			$cond['password'] = md5($pass);
			$res = $member->getMember($cond);
			if($res)
			{
				//1是否年级主任
				$manage = new ManageModel();
				$manage_info = $manage->getManage(array("name"=>$name));
				$power = $manage_info[0]['power'];
				$power_arr = @explode(",",$power);

				$leader = new LeaderModel();
				$leader_info = $leader->getLeader(array("uname"=>$res[0]['name']));
				$lid = $leader_info[0]['id'];
				$class = new ClassModel();
				$class_info = $class->getClass(array("leader_id"=>$lid));

				$admin_id = $manage_info[0]['id'];
				$year = new ClassYearModel();
				$year_info = $year->getClassYear(array("director_id"=>$admin_id));
				if(!empty($year_info)){
					$power = 0;
				}else if(in_array(6,$power_arr)){
					$power = 2;
				}else if(!empty($class_info)){
					$power = 1;
				}else{
					$power = 10;
				}
				$res = "success".",".$res[0]['id'].",".$power;
			}
			else
			{
				$ret = "failure".","."用户名密码错误！";
			}

		}
		else
		{
			$ret = "failure".","."协议内容有误！";
		}
		echo $res;
	}

//=========================================================================================================
	//学生请假部分
	//获取学生请假的信息
	public function getLeaveInfo()
	{
		$type = $_GET['types'];
		$return = array();
		if($type == 'json')
		{
			$id = @$_GET['userId'];
			if(empty($id))
			{
				$return['status']	= 'failure2';
				$return['content']	= '传值错误！';
			}
			else
			{
				//先判断是否为班主任
				$member = new MemberModel();
				$member_info = $member->getMember(array("id"=>$id));
				$name = $member_info[0]['name'];
				$leader = new LeaderModel();
				$leader_info = $leader->getLeader(array("uname"=>$name));
				$lid = $leader_info[0]['id'];
				$class = new ClassModel();
				$student = new StudentModel();
				$class_info = $class->getClass(array('leader_id'=>$lid));
				$manage = new ManageModel();
				$manage_info = $manage->getManage(array("name"=>$name));
				$mid = $manage_info[0]['id'];
				$year = new ClassYearModel();
				$year_info = $year->getClassYear(array("director_id"=>$mid));
				if(!empty($class_info))
				{
					$class_id = $class_info[0]['id'];
					$student_list = $student->getStudent(array("class_id"=>$class_id));
					$ids = array();
					for($i=0;$i<count($student_list);$i++){
						$ids[] = $student_list[$i]['id'];
					}
					$cond = array();
					$cond['student_id'] = array("IN",$ids);
					$leave = new StudentLeaveModel();
					$leave_list = $leave->getStudentLeave($cond,array("id"=>"desc"));
				}
				elseif(!empty($leader_info) || !empty($year_info))
				{
					$cond = array();
					if(!empty($leader_info))
					{
						$cond['year_id'] = $leader_info[0]['year_id'];
					}
					if(!empty($year_info))
					{
						$cond['year_id'] = $year_info[0]['id'];
					}
					$leave = new StudentLeaveModel();
					$leave_list = $leave->getStudentLeave($cond,array("id"=>"desc"));
				}
				else
				{
					$leave = new StudentLeaveModel();
					$leave_list = $leave->getStudentLeave(array(),array("id"=>"desc"));
				}
				$student = new StudentModel();
				// $student_assoc_list = $student->getAssocStudent();
				$sids = array();
				foreach($leave_list as $kk=>$vv)
				{
					$sids[] = $vv['student_id'];
				}
				$scond = array();
				$scond['id'] = array("IN",$sids);
				$students = $student->getStudent($scond);
				$student_assoc_list = array();
				foreach($students as $k=>$v)
				{
					$student_assoc_list[$v['id']] = $v;
				}
				$class_assoc_list = $class->getAssocClass();
				$status = array(1=>"待提交",3=>"待签收",4=>"待审批",5=>"已批准",6=>"已完成",7=>"已退回");

				foreach($leave_list as $key=>$val)
				{
					$leave_list[$key]['student_name'] = $student_assoc_list[$val['student_id']]['name'];
					$class_id = $student_assoc_list[$val['student_id']]['class_id'];
					$leave_list[$key]['class_text'] = $class_assoc_list[$class_id]['name'];
					$leave_list[$key]['photo_text'] = substr($student_assoc_list[$val['student_id']]['photo'],23);
					$leave_list[$key]['status_text'] = $status[$val['status']];
				}
				if(!empty($leave_list))
				{
					$return['status']	= 'success';
					$return['content']	= $leave_list;
				}
				else
				{
					$return['status']	= 'failure';
					$return['content']	= '暂无学生请假信息！';
				}
			}
		}
		else
		{
			$return['status']	= 'failure1';
			$return['content']	= '协议内容有误！';
		}
		echo json_encode($return);
	}
	//获取待审学生信息
	public function getCheckInfo()
	{
		$type = @$_GET['types'];
		$return = array();
		if($type == 'json')
		{
			$id = @$_GET['userId'];
			if(empty($id))
			{
				$return['status']	= 'failure';
				$return['content']	= '传值错误！';
			}
			else
			{
				$member = new MemberModel();
				$manage = new ManageModel();
				$leave = new StudentLeaveModel();
				$year = new ClassYearModel();
				$class = new ClassModel();
				$student = new StudentModel();
				$cond_row = array();
				$member_info = $member->getMember(array("id"=>$id));
				$user_name = $member_info[0]['name'];
				$manage_info = $manage->getManage(array("name"=>$user_name));
				if(!empty($manage_info))
				{
					$mid = $manage_info[0]['id'];
					$year_info = $year->getClassYear(array("director_id"=>$mid));
					if(!empty($year_info)){
						$cond_row['year_id'] = $year_info[0]['id'];
					}
				}
				$cond_row['status'] = array("IN",array(3,4));
				$leave_list = $leave->getStudentLeave($cond_row,array("id"=>"desc"));
				// $student_assoc_list = $student->getAssocStudent();
				$sids = array();
				foreach($leave_list as $kk=>$vv)
				{
					$sids[] = $vv['student_id'];
				}
				$scond = array();
				$scond['id'] = array("IN",$sids);
				$students = $student->getStudent($scond);
				$student_assoc_list = array();
				foreach($students as $k=>$v)
				{
					$student_assoc_list[$v['id']] = $v;
				}
				$class_assoc_list = $class->getAssocClass();
				$status = array(1=>"待提交",3=>"待签收",4=>"待审批",5=>"已批准",6=>"已完成",7=>"已退回");
				foreach($leave_list as $key=>$val)
				{
					$leave_list[$key]['student_name'] = $student_assoc_list[$val['student_id']]['name'];
					$class_id = $student_assoc_list[$val['student_id']]['class_id'];
					$leave_list[$key]['class_text'] = $class_assoc_list[$class_id]['name'];
					$leave_list[$key]['photo_text'] = substr($student_assoc_list[$val['student_id']]['photo'],23);
					$leave_list[$key]['status_text'] = $status[$val['status']];
				}
				if(!empty($leave_list))
				{
					$return['status']	= 'success';
					$return['content']	= $leave_list;
				}
				else
				{
					$return['status']	= 'failure';
					$return['content']	= '暂无学生请假信息！';
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
	//获取学生请假信息详情
	public function getLeaveInfoById(){
		$type = @$_GET['types'];
		$return = array();
		if($type == 'json')
		{
			$id = @$_GET['leaveId'];
			if(empty($id)){
				$return['status']	= 'failure';
				$return['content']	= '传值错误！';
			}
			else
			{
				$leave = new StudentLeaveModel();
				$leave_info = $leave->getStudentLeave(array("id"=>$id));
				$student = new StudentModel();
				$class = new ClassModel();
				$class_list = $class->getAssocClass();
				$student_info = $student->getStudent(array("id"=>$leave_info[0]['student_id']));
				$student_info[0]['class_text'] = $class_list[$student_info[0]['class_id']]['name'];
				$leave_info[0]['student_name'] = $student_info[0]['name'];
				$leave_info[0]['class_text'] = $student_info[0]['class_text'];
				$leave_info[0]['photo_text'] = substr($student_info[0]['photo'],23);
				$leave_info[0]['status_text'] = self::$status_list[$leave_info[0]['status']];

				$return['status']	= 'success';
				$return['content']	= $leave_info;
			}
		}
		else
		{
			$return['status']	= 'failure';
			$return['content']	= '协议内容有误！';
		}
		echo json_encode($return);
	}

	//同意学生请假
	public function agreeLeave()
	{
		$type = @$_GET['types'];
		$return = array();
		if($type == 'json')
		{
			$id = @$_GET['userId'];
			$uid = @$_GET['uid'];
			if(empty($id) || empty($uid))
			{
				$return['status']	= 'failure';
				$return['content']	= '传值错误！';
			}
			else
			{
				$reason = $_GET['reason'];
				if(empty($reason))
				{
					$reason = "准许请假";
				}
				$cond = array();
				$cond['leader_note'] = $reason;
				$cond['status']	= 5;
				$cond['auditby'] = $this->getNameByMid($uid);
				$leave = new StudentLeaveModel();
				$res = $leave->editStudentLeave($id,$cond);
				if($res)
				{
					$return['status']	= 'success';
					$return['content']	= '审批通过！';
				}
				else
				{
					$return['status']	= 'failure';
					$return['content']	= '审批失败！';
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
	//退回学生请假
	public function disagreeLeave()
	{
		$type = @$_GET['types'];
		$return = array();
		if($type == 'json')
		{
			$id = @$_GET['leaveId'];
			$uid = @$_GET['uid'];
			if(empty($id) || empty($uid))
			{
				$return['status']	= 'failure';
				$return['content']	= '传值错误！';
			}
			else
			{
				$reason = $_GET['reason'];
				if(empty($reason))
				{
					$reason = "退回请假";
				}
				$cond = array();
				$cond['leader_note']	= $reason;
				$cond['status']	= 7;
				$cond['auditby'] = $this->getNameByMid($uid);
				$leave = new StudentLeaveModel();
				$res = $leave->editStudentLeave($id,$cond);
				if($res)
				{
					$return['status']	= 'success';
					$return['content']	= '审核成功！';
				}
				else
				{
					$return['status']	= 'failure';
					$return['content']	= '审核失败！';
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

	//根据mid来查找姓名
	public function getNameByMid($mid)
	{
		$member = new MemberModel();
		$member_info = $member->getMember(array("id"=>$mid));
		$name = $member_info[0]['name'];
		$manage = new ManageModel();
		$manage_info = $manage->getManage(array("name"=>$name));
		$nick = $manage_info[0]['nick'];
		return $nick;
	}

	//==========================================================================
	//添加请假信息
	public function getSelectItem()
	{
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
				$member = new MemberModel();
				$member_info = $member->getMember(array("id"=>$uid));
				$name = $member_info[0]['name'];
				$manage = new ManageModel();
				$manage_info = $manage->getManage(array("name"=>$name));
				if(!empty($manage_info))
				{
					//获取所管的年组
					$lid = $manage_info[0]['id'];
					$year = new ClassYearModel();
					$year_info = $year->getClassYear(array("director_id"=>$lid));
					if(!empty($year_info))
					{
						$return_list = array();
						$year_id = $year_info[0]['id'];
						$class = new ClassModel();
						$year_list = $class->getClass(array("year_id"=>$year_id));
						$year_lists = array();
						$year_ids = array();
						foreach($year_list as $key=>$val)
						{
							$year_lists[$val['id']] = $val;
							$year_lists[$val['id']]['sub_list'] = array();
							$year_ids[] = $val['id'];
						}
						$cond = array();
						$cond['class_id'] = array("IN",$year_ids);
						$student = new StudentModel();
						$student_list = $student->field("id,name,class_id")->where($cond)->select();
						foreach($student_list as $k=>$v)
						{
							$year_lists[$v['class_id']]['sub_list'][] = $v;
						}
						$newlist = array();
						foreach ($year_lists as $key => $value) {
							$newlist[] = $value;
						}
						
						$return_list['main_list'] = $newlist;
						// echo "<pre>";
						// var_dump($return_list);
						if(true)
						{
							$return['status']	= 'success';
							$return['content']	= $return_list;
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
						$return['content']	= '您没有这项权限！';
					}
				}
				else
				{
					//查找自己班级的学生
					$leader = new LeaderModel();
					$leader_info = $leader->getLeader(array("uname"=>$name));
					$cid = $leader_info[0]['id'];
					$class = new ClassModel();
					$class_info = $class->getClass(array("leader_id"=>$cid));
					if(!empty($class_info))
					{
						$class_id = $class_info[0]['id'];
						$student = new StudentModel();
						$student_list = $student->getStudent(array("class_id"=>$class_id));
						if(!empty($student_list))
						{
							$return['status']	= 'success';
							$return['content']['main_list'] = array();
							$return['content']['sub_list']	= $student_list;
						}
						else
						{
							$return['status']	= 'failure';
							$return['content']	= '该班级暂无学生信息！';
						}
					}
					else
					{
						$return['status']	= 'failure';
						$return['content']	= '您没有这项权限！';
					}
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

	public function getStudentById(){
		$type = @$_GET['types'];
		$return = array();
		if($type == 'json')
		{
			$uid = $_GET['uid'];
			if(empty($uid)){
				$return['status']	='failure';
				$return['content']	= '传值错误！';
			}
			else
			{
				$student = new StudentModel();
				$student_info = $student->getStudent(array("id"=>$uid));
				$student_info[0]['photo_text'] = substr($student_info[0]['photo'],23);
				if(true)
				{
					$return['status']	= 'success';
					$return['content']	= $student_info[0];
				}
				else
				{
					$return['status']	= 'failure';
					$return['content']	= '暂无数据！';
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

	public function addLeaveInfo()
	{
		$type = @$_GET['types'];
		$return = array();
		if($type == 'json')
		{
			// $return['status']	= 'success';
			$sid = $_GET['sid'];
			$uid = $_GET['userId'];
			if(empty($sid) || empty($uid))
			{
				$return['status']	= 'failure';
				$return['content']	= '传值错误！';
			}
			else
			{
				$leave = new StudentLeaveModel();
				$cond = array();
				$cond['student_id'] = $sid;
				$cond['reason']		= $_GET['reason'];
				$cond['begin_date']	= $_GET['stime'];
				$cond['end_date']	= $_GET['etime'];
				$cond['director_note'] = $_GET['leaderNote'];
				$cond['createby']	= $this->getLeaderNameByLeaderId($uid);
				$cond['status']		= 3;
				$cond['leader']		= $this->getTeacherNameByStudentId($sid);
				$cond['year_id']	= $this->getClassIdByStudentId($sid);
				$res = $leave->addStudentLeave($cond);
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
		echo json_encode($return);
	}
	public function getTeacherNameByStudentId($id)
	{
		$student = new StudentModel();
		$student_info = $student->getStudent(array("id"=>$id));
		$class_id = $student_info[0]['class_id'];
		$class = new ClassModel();
		$class_info = $class->getClass(array("id"=>$class_id));
		$leader_id = $class_info[0]['leader_id'];
		$leader = new LeaderModel();
		$leader_info = $leader->getLeader(array("id"=>$leader_id));
		$name = $leader_info[0]['name'];
		return $name;
	}
	public function getClassIdByStudentId($id)
	{
		$student = new StudentModel();
		$student_info = $student->getStudent(array("id"=>$id));
		$class_id = $student_info[0]['class_id'];
		$class = new ClassModel();
		$class_info = $class->getClass(array("id"=>$class_id));
		$year_id = $class_info[0]['year_id'];
		return $year_id;
	}
	public function getLeaderNameByLeaderId($id)
	{
		$member = new MemberModel();
		$member_info = $member->getMember(array("id"=>$id));
		$name = $member_info[0]['nick'];
		return $name;
	}

}

?>