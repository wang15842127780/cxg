<?php
namespace Home\Model;
use Think\Model;

class SubjectModel extends Model{

	public function getSubject($cond=array(),$order=array(),$page=1,$limit=100)
	{
		return $this->where($cond)->order($order)->page($page,$limit)->select();
	}

	public function addSubject($cond)
	{
		$res = $this->add($cond);
		return $res; //新增的ID
	}

	public function editSubject($id,$cond)
	{
		$res = $this->where("id=$id")->save($cond);
		return $res;
	}

	public function delSubject($id)
	{
		$res = $this->where("id=$id")->delete();
		return $res;
	}

	public function getAssocSubject()
	{
		$list = $this->select();
		$lists = array();
		foreach($list as $k=>$v)
		{
			$lists[$v['id']] = $v;
		}
		return $lists;
	}

}






?>