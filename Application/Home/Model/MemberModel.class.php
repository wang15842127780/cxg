<?php
namespace Home\Model;
use Think\Model;

class MemberModel extends Model{

	public function getMember($cond=array(),$order=array(),$page=1,$limit=100)
	{
		return $this->where($cond)->order($order)->page($page,$limit)->select();
	}

	public function addMember($cond)
	{
		$res = $this->add($cond);
		return $res; //新增的ID
	}

	public function editMember($id,$cond)
	{
		$res = $this->where("id=$id")->save($cond);
		return $res;
	}

	public function delMember($id)
	{
		$res = $this->where("id=$id")->delete();
		return $res;
	}

	public function getAssocMember($cond=array())
	{
		$list = $this->where($cond)->select();
		$lists = array();
		foreach($list as $k=>$v)
		{
			$lists[$v['id']] = $v;
		}
		return $lists;
	}

}






?>