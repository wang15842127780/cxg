<?php
namespace Admin\Model;
use Think\Model;

class BuildTypeModel extends Model{

	public function getBuildType($cond=array(),$order=array(),$page=1,$limit=100)
	{
		return $this->where($cond)->order($order)->page($page,$limit)->select();
	}

	public function addBuildType($cond)
	{
		$res = $this->add($cond);
		return $res; //新增的ID
	}

	public function editBuildType($id,$cond)
	{
		$res = $this->where("id=$id")->save($cond);
		return $res;
	}

	public function delBuildType($id)
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