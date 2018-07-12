<?php
namespace Home\Model;
use Think\Model;

class StudentModel extends Model{

	public function getStudent($cond=array(),$order=array(),$page=1,$limit=100,$flag=true)
	{
		if($flag)
		{
			return $this->where($cond)->order($order)->page($page,$limit)->select();
		}
		else
		{
			return $this->field('id,name,sex,iden,class_id,dormitory_id,note,contact,contact_phone,points,bed_no')->where($cond)->order($order)->page($page,$limit)->select();
		}
	}

	public function addStudent($cond)
	{
		$res = $this->add($cond);
		return $res; //新增的ID
	}

	public function editStudent($id,$cond)
	{
		$res = $this->where("id=$id")->save($cond);
		return $res;
	}

	public function delStudent($id)
	{
		$res = $this->where("id=$id")->delete();
		return $res;
	}

	public function getAssocStudent()
	{
		$list = $this->field("id,name,iden,sex,class_id,dormitory_id,note,contact,contact_phone,bed_no")->select();
		$lists = array();
		foreach($list as $k=>$v)
		{
			$lists[$v['id']] = $v;
		}
		return $lists;
	}

}






?>