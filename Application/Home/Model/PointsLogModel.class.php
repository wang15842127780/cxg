<?php
namespace Home\Model;
use Think\Model;
class PointsLogModel extends Model{

	public function getPointsLog($cond=array(),$order=array(),$page=1,$limit=100)
	{
		return $this->where($cond)->order($order)->page($page,$limit)->select();
	}

	public function addPointsLog($cond)
	{
		$res = $this->add($cond);
		return $res; //新增的ID
	}

	public function editPointsLog($id,$cond)
	{
		$res = $this->where("id=$id")->save($cond);
		return $res;
	}

	public function delPointsLog($id)
	{
		$res = $this->where("id=$id")->delete();
		return $res;
	}
}





?>