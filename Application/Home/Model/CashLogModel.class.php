<?php
namespace Home\Model;
use Think\Model;
class CashLogModel extends Model{

	public function getCashLog($cond=array(),$order=array(),$page=1,$limit=100)
	{
		return $this->where($cond)->order($order)->page($page,$limit)->select();
	}

	public function addCashLog($cond)
	{
		$res = $this->add($cond);
		return $res; //新增的ID
	}

	public function editCashLog($id,$cond)
	{
		$res = $this->where("id=$id")->save($cond);
		return $res;
	}

	public function delCashLog($id)
	{
		$res = $this->where("id=$id")->delete();
		return $res;
	}
	
}





?>