<?php
namespace Admin\Model;
use Think\Model;

class MainEntranceRecordModel extends Model{

	public function getMainEntranceRecord($cond=array(),$order=array(),$page=1,$limit=100)
	{
		return $this->where($cond)->order($order)->page($page,$limit)->select();
	}

	public function addMainEntranceRecord($cond)
	{
		$res = $this->add($cond);
		return $res; //新增的ID
	}

	public function editMainEntranceRecord($id,$cond)
	{
		$res = $this->where("id=$id")->save($cond);
		return $res;
	}

	public function delMainEntranceRecord($id)
	{
		$res = $this->where("id=$id")->delete();
		return $res;
	}
}




?>