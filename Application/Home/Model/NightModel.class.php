<?php
namespace Home\Model;
use Think\Model;

class NightModel extends Model{

	public function getNight($cond=array(),$order=array(),$page=1,$limit=100)
	{
		return $this->where($cond)->order($order)->page($page,$limit)->select();
	}

	public function addNight($cond)
	{
		$res = $this->add($cond);
		return $res; //新增的ID
	}

	public function editNight($id,$cond)
	{
		$res = $this->where("id=$id")->save($cond);
		return $res;
	}

	public function delNight($id)
	{
		$res = $this->where("id=$id")->delete();
		return $res;
	}

}






?>