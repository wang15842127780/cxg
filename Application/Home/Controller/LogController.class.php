<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\MemberModel;
use Home\Model\ManageModel;

class LogController extends Controller{
	public function dolog()
	{
		$uname = $_POST['uname'];
		$upass = $_POST['upass'];
		$manage = new MemberModel();
		$cond = array();
		$cond['name'] = $uname;
		$cond['password'] = md5($upass);

		$res = $manage->getMember($cond);
		if($res)
		{
			$res = array_values($res);
			setcookie('user',$res[0]['nick'],time()+18000,"/");
			setcookie('type',$res[0]['type'],time()+18000,"/");
			setcookie('id',$res[0]['id'],time()+18000,"/");
			$this->ajaxReturn("true");
		}
		else
		{
			$this->ajaxReturn("false");
		}

	}


	public function logout()
	{
		setcookie('user',"",time()-18000,"/");
		setcookie('type','',time()-18000,"/");
		setcookie('id',"",time()-18000,"/");
		if(true)
		{
			$this->success('退出登录', header("Location:/cxg"));
		}
		else
		{
			$this->ajaxReturn("false");
		}
	}

	public function wapLog()
	{
		$type = @$_POST['typ'];
		$return = array();
		if($type == 'json')
		{
			$name = $_POST['name'];
			$pass = $_POST['pass'];
			$cond = array();
			$cond['name'] = $name;
			$cond['password'] = md5($pass);
			$member = new MemberModel();
			$res = $member->getMember($cond);
			if($res)
			{
				//根据姓名来查找   是否为后台用户  
				$manage = new ManageModel();
				$manage_info = $manage->getManage(array('name'=>$name));
				if(!empty($manage_info))
				{
					$aid = $manage_info[0]['id'];
					setcookie('aid',$aid);
				}
				setcookie('user',$res[0]['nick']);
				setcookie('type',$res[0]['type']);
				setcookie('id',$res[0]['id']);
				$return['status']	= 'success';
				$return['content']	= '登录成功！';
			}
			else
			{
				$return['status']	= 'failure';
				$return['content']	= '用户名或密码错误！';
			}
		}
		else
		{
			$return['status']	= 'failure';
			$return['content']	= '协议内容有误！';
		}
		$this->ajaxReturn($return);
	}
}





?>