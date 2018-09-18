<?php
namespace Home\Model;
use Think\Model;

class TeacherLeaveModel extends Model{

	public function getTeacherLeave($cond=array(),$order=array(),$page=1,$limit=100)
	{
		return $this->where($cond)->order($order)->page($page,$limit)->select();
	}

	public function addTeacherLeave($cond)
	{
		$res = $this->add($cond);
		return $res; //新增的ID
	}

	public function editTeacherLeave($id,$cond)
	{
		$res = $this->where("id=$id")->save($cond);
		return $res;
	}

	public function delTeacherLeave($id)
	{
		$res = $this->where("id=$id")->delete();
		return $res;
	}

	public function getCount($cond=array())
	{
		$count = $this->where($cond)->count();
		return $count;
	}

}






?>