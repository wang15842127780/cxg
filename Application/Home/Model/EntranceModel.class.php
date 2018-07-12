<?php
namespace Home\Model;
use Think\Model;

class EntranceModel extends Model{

	public function getEntrance($cond=array(),$order=array(),$page=1,$limit=100)
	{
		return $this->where($cond)->order($order)->page($page,$limit)->select();
	}

	public function addEntrance($cond)
	{
		$res = $this->add($cond);
		return $res; //新增的ID
	}

	public function editEntrance($id,$cond)
	{
		$res = $this->where("id=$id")->save($cond);
		return $res;
	}

	public function delEntrance($id)
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