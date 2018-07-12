<?php
namespace Admin\Model;
use Think\Model;

class LeaveRecordModel extends Model{

	public function getLeaveRecord($cond=array(),$order=array(),$page=1,$limit=100)
	{
		$cond['type']	= 2;   //后台管理菜单
		return $this->where($cond)->order($order)->page($page,$limit)->select();
	}

	public function addLeaveRecord($cond)
	{
		$res = $this->add($cond);
		return $res; //新增的ID
	}

	public function editLeaveRecord($id,$cond)
	{
		$res = $this->where("id=$id")->save($cond);
		return $res;
	}

	public function delLeaveRecord($id)
	{
		$res = $this->where("id=$id")->delete();
		return $res;
	}

}





?>