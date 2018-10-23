<?php
namespace Home\Controller;
use Think\Controller;
use Think\Cache\Driver\Redis;

use Home\Model\StudentModel;
use Home\Model\MemberModel;
use Home\Model\ClassModel;
use Home\Model\CashLogModel;

/**
* @param author Yongjun Wang
* @param 07/09/2018
*/

class AndroidMessController extends Controller{
    //获取打饭学生信息
    public function getStudentInfoById(){
    	$type = @$_GET['types'];
    	$return = array();
    	if($type == 'json')
    	{
    		$uid = @$_GET['uid'];
            if(!empty($uid))
            {
                $student = new StudentModel();
                $class = new ClassModel();
                $stu_cond = array();
                $stu_cond['id'] = $uid;
                $stu_info = $student->getStudent($stu_cond);
                if(!empty($stu_info))
                {
                    $class_list = $class->getAssocClass();
                    $return_array = array();
                    $class_id = $stu_info[0]['class_id'];
                    $stu_info[0]['class_text'] = $class_list[$class_id]['name'];
                    $return_array['name'] = $stu_info[0]['name'];
                    $return_array['class_text'] = $stu_info[0]['class_text'];
                    $return_array['money'] = $stu_info[0]['money'];
                    $return_array['person_id'] = $stu_info[0]['id'];

                    if((int)$return_array['money'] > 0)
                    {
                        $return['status']   = 'success';
                        $return['content']  = $return_array;
                    }
                    else
                    {
                        $return['status']   = 'failure';
                        $return['content']  = '用户余额不足，请充值后再操作！';
                    }
                        
                }
                else
                {
                    $return['status']   = 'failure';
                    $return['content']  = '学生信息不正确，需要重新导入！';
                }
            }
            else
            {
                $return['status']   = 'failure';
                $return['content']  = '学生信息不正确，需要重新导入！';
            }
    	}	
    	else
    	{
    		$return['status']	= 'failure';
    		$return['content']	= '协议内容有误！';
    	}
    	echo json_encode($return);
    }

    //学生消费
    public function studentConsumeInMess()
    {
        $type = @$_GET['types'];
        $return = array();
        if($type == 'json')
        {
            $id = $_GET['uid'];
            $cost = $_GET['cost'];
            $student = new StudentModel();
            $student->startTrans();
            $student_info = $student->getStudent(array("id"=>$id));
            $money = $student_info[0]['money'];
            $left = (float)$money - (float)$cost;
            $cond = array();
            $cond['money'] = $left;
            $res1 = $student->editStudent($id,$cond);

            //插入消费记录
            $log = new CashLogModel();
            $add_row = array();
            $add_row['stu_id'] = $id;
            $add_row['stu_name'] = $student_info[0]['name'];
            $add_row['operate'] = "食堂消费".$cost."元";
            $add_row['cash'] = "-".$cost;
            $add_row['month'] = date("Y-m",time());
            $add_row['date'] = date("Y-m-d",time());
            $add_row['datetime'] = date("Y-m-d H:i:s",time());
            $add_row['device_name'] = $_GET['deviceName'];
            $add_row['remain'] = $left;
            $res2 = $log->addCashLog($add_row);
            if($res1 && $res2)
            {
                $student->commit();
                $return['status']   = 'success';
                $return['content']	= '';
            }
            else
            {
                $student->rollBack();
                $return['status']   = 'failure';
                $return['content']	= '';
            }
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        echo json_encode($return);
    }

    //学生充值信息
    public function setStudentInfoByRedis()
    {
        $type = @$_GET['types'];
        $return = array();
        if($type == 'json')
        {
            $redis = new \Redis();
            $redis->connect("127.0.0.1",6379);
            $id = $_GET['studentId'];
            if(!empty($id))
            {
                $res = $redis->set("messStudentId",$id);
                if($res)
                {
                    $return['status']   = 'success';
                    $return['content']  = '成功！';
                }
                else
                {
                    $return['status']   = 'failure';
                    $return['content']  = 'Redis服务错误！';
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

	
}
?>