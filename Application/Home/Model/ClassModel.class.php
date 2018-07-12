<?php
namespace Home\Model;
use Think\Model;

class ClassModel extends Model{

	public function getClass($cond=array(),$order=array(),$page=1,$limit=100)
	{
		return $this->where($cond)->order($order)->page($page,$limit)->select();
	}

	public function addClass($cond)
	{
		$res = $this->add($cond);
		return $res; //新增的ID
	}

	public function editClass($id,$cond)
	{
		$res = $this->where("id=$id")->save($cond);
		return $res;
	}

	public function delClass($id)
	{
		$res = $this->where("id=$id")->delete();
		return $res;
	}


	//获取班级信息
	public function getClassList($cond)
	{
		$list = $this->where($cond)->order(array('name'=>"ASC"))->select();
		$lists = array();
		foreach($list as $k=>$v)
		{
			if((int)$v['name'] != "")
			{
				$lists[] = $v;
			}
		}
		return $lists;
	}

	public function getAssocClass()
	{
		$res = $this->order(array("name"=>"ASC"))->select();
		$list = array();
		foreach($res as $k=>$v)
		{
			$list[$v['id']] = $v;
		}
		return $list;
	}

}






?>