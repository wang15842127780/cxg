<?php
namespace Admin\Model;
use Think\Model;

class EntryRecordModel extends Model{

	public function getEntryRecord($cond=array(),$order=array(),$page=1,$limit=100)
	{
		return $this->where($cond)->order($order)->page($page,$limit)->select();
	}

	public function addEntryRecord($cond)
	{
		$res = $this->add($cond);
		return $res; //新增的ID
	}

	public function editEntryRecord($id,$cond)
	{
		$res = $this->where("id=$id")->save($cond);
		return $res;
	}

	public function delEntryRecord($id)
	{
		$res = $this->where("id=$id")->delete();
		return $res;
	}
}




?>