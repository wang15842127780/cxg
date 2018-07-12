<?php
namespace Admin\Model;
use Think\Model;

class ConfigModel extends Model{

	public function getConfig($cond=array(),$order=array(),$page=1,$limit=100)
	{
		$cond['type']	= 2;   //后台管理菜单
		return $this->where($cond)->order($order)->page($page,$limit)->select();
	}

	public function addConfig($cond)
	{
		$res = $this->add($cond);
		return $res; //新增的ID
	}

	public function editConfig($id,$cond)
	{
		$res = $this->where("id=$id")->save($cond);
		return $res;
	}

	public function delConfig($id)
	{
		$res = $this->where("id=$id")->delete();
		return $res;
	}

	public function getAssocGroup()
	{
		$list = $this->select();
		$res = array();
		foreach($list as $key=>$val)
		{
			$res[$val['id']] = $val['name'];
		}
		return $res;
	}

}





?>