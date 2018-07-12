<?php
namespace Home\Model;
use Think\Model;

class TeacherAttendRecordModel extends Model{

	public function getAttendRecord($cond=array(),$order=array(),$page=1,$limit=100)
	{
		return $this->where($cond)->order($order)->page($page,$limit)->select();
	}

	public function addAttendRecord($cond)
	{
		$res = $this->add($cond);
		return $res; //新增的ID
	}

	public function editAttendRecord($id,$cond)
	{
		$res = $this->where("id=$id")->save($cond);
		return $res;
	}

	public function delAttendRecord($id)
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