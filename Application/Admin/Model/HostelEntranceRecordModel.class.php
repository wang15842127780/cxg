<?php
namespace Admin\Model;
use Think\Model;

class HostelEntranceRecordModel extends Model{

	public function getHostelEntranceRecord($cond=array(),$order=array(),$page=1,$limit=100)
	{
		return $this->where($cond)->order($order)->page($page,$limit)->select();
	}

	public function addHostelEntranceRecord($cond)
	{
		$res = $this->add($cond);
		return $res; //新增的ID
	}

	public function editHostelEntranceRecord($id,$cond)
	{
		$res = $this->where("id=$id")->save($cond);
		return $res;
	}

	public function delHostelEntranceRecord($id)
	{
		$res = $this->where("id=$id")->delete();
		return $res;
	}
}




?>