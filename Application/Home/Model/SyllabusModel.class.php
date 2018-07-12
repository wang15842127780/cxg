<?php
namespace Home\Model;
use Think\Model;

class SyllabusModel extends Model{

	public function getSyllabus($cond=array(),$order=array(),$page=1,$limit=100)
	{
		return $this->where($cond)->order($order)->page($page,$limit)->select();
	}

	public function addSyllabus($cond)
	{
		$res = $this->add($cond);
		return $res; //新增的ID
	}

	public function editSyllabus($id,$cond)
	{
		$res = $this->where("id=$id")->save($cond);
		return $res;
	}

	public function delSyllabus($id)
	{
		$res = $this->where("id=$id")->delete();
		return $res;
	}

}






?>