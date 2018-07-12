<?php
namespace Admin\Controller;
use Think\Controller;
use Home\Model\ManageModel;

class LogController extends Controller{
	public function dolog()
	{
		$uname = $_POST['uname'];
		$upass = $_POST['upass'];
		$manage = new ManageModel();
		$cond = array();
		$cond['name'] = $uname;
		$cond['password'] = md5($upass);

		$res = $manage->getManage($cond);
		if($res)
		{
			$res = array_values($res);
			setcookie('auser',$res[0]['nick'],time()+36000,"/");
			setcookie('aid',$res[0]['id'],time()+36000,"/");
			$this->ajaxReturn("true");
		}
		else
		{
			$this->ajaxReturn("false");
		}

	}


	public function logout()
	{
		setcookie('auser',"",time()-3600,"/");
		setcookie('aid','',time()-3600,"/");
		if(true)
		{
			$this->success('退出登录', header("Location:/cxg/index.php?m=Admin"));
		}
		else
		{
			$this->ajaxReturn("false");
		}
	}
}





?>