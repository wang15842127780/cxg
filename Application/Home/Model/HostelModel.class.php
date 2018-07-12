<?php
namespace Home\Model;
use Think\Model;
class HostelModel extends Model{

	public function getHostel($cond=array(),$order=array(),$page=1,$limit=100)
	{
		return $this->where($cond)->order($order)->page($page,$limit)->select();
	}

	public function addHostel($cond)
	{
		$res = $this->add($cond);
		return $res; //新增的ID
	}

	public function editHostel($id,$cond)
	{
		$res = $this->where("id=$id")->save($cond);
		return $res;
	}

	public function delHostel($id)
	{
		$res = $this->where("id=$id")->delete();
		return $res;
	}


	public function getHostelList($cond=array())
	{
		$res = $this->where($cond)->order(array('build'=>"ASC"))->select();
		$list = array();
		foreach($res as $k=>$v)
		{
			if(!in_array($v['build'],$list))
			{
				$list[$v['build']] = $v['build'];
			}
		}

		return $list;
	}

	public function getHostelTree($cond=array())
	{
		$list = $this->where($cond)->order(array('name'=>"ASC"))->select();
		if(!empty($list))
		{
			$lists = array();
			$shell = array();
			for($i=1;$i<=9;$i++)
			{
				$shell[] = $i;
			}

			foreach($list as $k=>$v)
			{
				$n = (int)$v['name'];
				if(in_array($n,$shell))
				{
					$lists['l'.$n][] = $v;
				}
			}
		}
		else
		{
			$lists = array();
		}
		$listss = array();
		if(!empty($lists))
		{
			foreach($lists as $k=>$v)
			{
				$listss[$v['id']] = $v;
			}
		}
		return $lists;
	}

	public function getAssocHostel($cond=array())
	{
		$res = $this->where($cond)->order(array('name'=>"ASC"))->select();
		$list = array();
		foreach($res as $k=>$v)
		{
			$list[$v['id']] = $v;
		}
		return $list;
	}

}





?>