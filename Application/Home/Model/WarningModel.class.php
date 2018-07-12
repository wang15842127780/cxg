<?php
namespace Home\Model;
use Think\Model;

class WarningModel extends Model{

	public function getWarning($cond=array(),$order=array(),$page=1,$limit=50)
	{
		return $this->where($cond)->order($order)->page($page,$limit)->select();
	}

	public function addWarning($cond)
	{
		$res = $this->add($cond);
		return $res; //新增的ID
	}

	public function editWarning($id,$cond)
	{
		$res = $this->where("id=$id")->save($cond);
		return $res;
	}

	public function delWarning($id)
	{
		$res = $this->where("id=$id")->delete();
		return $res;
	}

	public function getCount($cond=array())
	{
		$res = $this->where($cond)->count();
		return $res;
	}

}






?>