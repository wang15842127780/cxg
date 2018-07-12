<?php
namespace Home\Model;
use Think\Model;

class ManageModel extends Model{

	public function getManage($cond=array(),$order=array(),$page=1,$limit=100)
	{
		return $this->where($cond)->order($order)->page($page,$limit)->select();
	}

	public function addManage($cond)
	{
		$res = $this->add($cond);
		return $res; //新增的ID
	}

	public function editManage($id,$cond)
	{
		$res = $this->where("id=$id")->save($cond);
		return $res;
	}

	public function delManage($id)
	{
		$res = $this->where("id=$id")->delete();
		return $res;
	}

	public function getManageList()
	{
		$res = $this->select();
		$list = array();
		foreach($res as $k=>$v)
		{
			if($v['id'] != 1)
			{
				$list[] = $v;
			}
		}
		$list = array_values($list);
		return $list;
	}

	public function getAssocManage()
	{
		$res = $this->select();
		$list = array();
		if(!empty($res))
		{
			foreach($res as $key=>$val)
			{
				$list[$val['id']] = $val;
			}
		}
			
		return $list;
	}

}






?>