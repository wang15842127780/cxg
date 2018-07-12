<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\MemberModel;
use Home\Model\ManageModel;


class AndroidSettingController extends Controller{
    public function index(){
        var_dump("这里是AndroidSetting控制器");
    }
    public function editPassWord(){
    	$type = @$_GET['types'];
    	$return = array();
    	if($type == 'json')
    	{
    		$id = $_GET['uid'];
    		$old = $_GET['oldPass'];
    		$new = $_GET['newPass'];
    		if(empty($id) || empty($old) || empty($new))
    		{
    			$return['status']	= 'failure';
    			$return['content']	= '传值错误！';
    		}
    		else
    		{
    			$member = new MemberModel();
    			$member_info = $member->getMember(array("id"=>$id));
    			$password = $member_info[0]['password'];
    			if($password == md5($old))
    			{
    				$cond = array();
    				$cond['password'] = md5($new);
    				//查看是否为后台人员
    				$manage = new ManageModel();
    				$name = $member_info[0]['name'];
    				$manage_info = $manage->getManage(array("name"=>$name));
    				if(!empty($manage_info))
    				{
    					$mid = $manage_info[0]['id'];
    					$member->startTrans();
    					$res1 = $member->editMember($id,$cond);
    					$res2 = $manage->editManage($mid,$cond);
    					if($res1 && $res2)
    					{
    						$member->commit();
    						$return['status']	= 'success';
    						$return['content']	= '修改成功，请重新登录！';
    					}
    					else
    					{
    						$member->rollBack();
    						$return['status']	= 'failure';
    						$return['content']	= '修改失败!';
    					}
    				}
    				else
    				{
    					$res = $member->editMember($id,$cond);
    					if($res)
    					{
    						$return['status']	= 'success';
    						$return['content']	= '修改成功，请重新登录！';
    					}
    					else
    					{
    						$return['status']	= 'failure';
    						$return['content']	= '新密码不能与旧密码相同！';
    					}
    				}
    			}
    			else
    			{
    				$return['status']	= 'failure';
    				$return['content']	= '原密码不正确！';
    			}
    		}
    	}	
    	else
    	{
    		$return['status']	= 'failure';
    		$return['content']	= '协议内容有误！';
    	}
    	echo json_encode($return);
    }
	
}
?>