<?php
namespace Home\Model;
use Think\Model;

class CameraModel extends Model{

	public function getCamera($cond=array(),$order=array(),$page=1,$limit=100)
	{
		return $this->where($cond)->order($order)->page($page,$limit)->select();
	}

	public function addCamera($cond)
	{
		$res = $this->add($cond);
		return $res; //新增的ID
	}

	public function editCamera($id,$cond)
	{
		$res = $this->where("id=$id")->save($cond);
		return $res;
	}

	public function delCamera($id)
	{
		$res = $this->where("id=$id")->delete();
		return $res;
	}

}






?>