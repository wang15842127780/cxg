<?php
namespace Admin\Model;
use Think\Model;

class RoleModel extends Model{

	public function getRole($cond=array(),$order=array(),$page=1,$limit=100)
	{
		return $this->where($cond)->order($order)->page($page,$limit)->select();
	}

	public function addRole($cond)
	{
		$res = $this->add($cond);
		return $res; //新增的ID
	}

	public function editRole($id,$cond)
	{
		$res = $this->where("id=$id")->save($cond);
		return $res;
	}

	public function delRole($id)
	{
		$res = $this->where("id=$id")->delete();
		return $res;
	}

	public function getAssocList()
	{
		$res = $this->select();
		$list = array();
		foreach($res as $key=>$val)
		{
			$list[$val['id']] = $val;
		}
		return $list;
	}

}





?>