<?php
namespace Admin\Model;
use Think\Model;

class LeaderModel extends Model{

	public function getLeader($cond=array(),$order=array(),$page=1,$limit=100)
	{
		return $this->where($cond)->order($order)->page($page,$limit)->select();
	}

	public function addLeader($cond)
	{
		$res = $this->add($cond);
		return $res; //新增的ID
	}

	public function editLeader($id,$cond)
	{
		$res = $this->where("id=$id")->save($cond);
		return $res;
	}

	public function delLeader($id)
	{
		$res = $this->where("id=$id")->delete();
		return $res;
	}

	public function getAssocList()
	{
		$res = $this->field("id,name,year_id,note,uname")->select();
		$list = array();
		foreach($res as $key=>$val)
		{
			$list[$val['id']] = $val;
		}
		return $list;
	}

}





?>