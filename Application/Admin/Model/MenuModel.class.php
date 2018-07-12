<?php
namespace Admin\Model;
use Think\Model;

class MenuModel extends Model{

	public function getMenu($cond=array(),$order=array(),$page=1,$limit=100)
	{
		$cond['type']	= 2;   //后台管理菜单
		return $this->where($cond)->order($order)->page($page,$limit)->select();
	}

	public function addMenu($cond)
	{
		$res = $this->add($cond);
		return $res; //新增的ID
	}

	public function editMenu($id,$cond)
	{
		$res = $this->where("id=$id")->save($cond);
		return $res;
	}

	public function delMenu($id)
	{
		$res = $this->where("id=$id")->delete();
		return $res;
	}


	//将菜单以多层数组形式展示
	public function getMenuTree()
	{
		$main = $this->where(array('parent_id'=>0,'show'=>1,'type'=>2))->order(array('id'=>"ASC"))->select();
		foreach($main as $k=>$v)
		{
			$list = $this->where(array("parent_id"=>$v['id'],'show'=>1))->order(array('id'=>"ASC"))->select();
			if($list)
			{
				$main[$k]['sub_menu'] = $list;
				foreach($list as $kk=>$vv)
				{
					$lists = $this->where(array('parent_id'=>$vv['id'],'show'=>1))->order(array("id"=>"ASC"))->select();
					if($lists)
					{
						$main[$k]['sub_menu'][$kk]['sub_menu'] = $lists;
					}
				}
			}
		}
		// echo "<pre>";
		// var_dump($main);
		// die;
		return $main;
	}

}





?>