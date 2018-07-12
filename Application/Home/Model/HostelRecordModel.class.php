<?php
namespace Home\Model;
use Think\Model;
class HostelRecordModel extends Model{

	public function getHostelRecord($cond=array(),$order=array(),$page=1,$limit=100)
	{
		return $this->where($cond)->order($order)->page($page,$limit)->select();
	}

	public function addHostelRecord($cond)
	{
		$res = $this->add($cond);
		return $res; //新增的ID
	}

	public function editHostelRecord($id,$cond)
	{
		$res = $this->where("id=$id")->save($cond);
		return $res;
	}

	public function delHostelRecord($id)
	{
		$res = $this->where("id=$id")->delete();
		return $res;
	}
	
}





?>