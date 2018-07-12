<?php
namespace Admin\Controller;
use Think\Controller;
use Home\Model\ManageModel;
use Home\Model\MemberModel;

use Admin\Model\MenuModel;
use Admin\Model\ConfigModel;

class TeacherController extends Controller{
	public function index()
	{
		//身份判断
    	if(empty($_COOKIE['auser']))
    	{
    		header("Location:/cxg/index.php?m=Admin");
    		die;
    	}
        $menu = new MenuModel();
        $act = @$_GET['id'];
        $this->assign("typ",$act);
        $type = explode(".",$act)[1];
        switch($type)
        {

        	case "76":
        	$this->teacherIndex();
        	break;
            default:
            header("Location:/cxg/index.php?m=Admin");
            break;
        }
        // $menu = new MenuModel();
        // // $main_menu = $menu->getMenu(array('parent_id'=>7));
        // $menus = $menu->getMenuTree();
        // $main_menu = $menus[0]['sub_menu'];
        // $this->assign('main_menu',$main_menu);
        // // $this->assign("menu",$menus);
        // $this->display('index');
	}

    public function teacherIndex()
    {
        $menu = new MenuModel();
        $menus = $menu->getMenuTree();
        $main_menu = $menus[0]['sub_menu'];
        $this->assign('main_menu',$main_menu);
        $this->display("teacher");
    }

    public function todayAttend()
    {
        $menu = new MenuModel();
        $menus = $menu->getMenuTree();
        $main_menu = $menus[0]['sub_menu'];
        $this->assign('main_menu',$main_menu);
        $this->display("todayAttend");
    }
    //获取今日出勤
    public function getTodayAttend()
    {
        $type = @$_POST['typ'];
        $return = array();
        if($type == 'json')
        {
            $config = new ConfigModel();
            $config_info = $config->getConfig(array('name'=>'teacher_attendance_ip'));
            $teacher_ip_row = $config_info[0]['value'];
            $teacher_ip_arr = @explode(",",$teacher_ip_row);

            $member = new MemberModel();
            $member_list = $member->getMember(array(),array(),1,1000);

            var_dump($teacher_ip_arr);
            $time_start = date("Y-m-d 00:00:00",time()-3600*24);
            $time_end = date("Y-m-d H:i:s",time());
            foreach($teacher_ip_arr as $key=>$val)
            {
                $url = $val."/rtmonitor/alarm?alarm_type=1&time_start=".$time_start."&time_end=".$time_end;
                $return1 = $this->curl_request($url);
                $return2 = json_decode($return1);
                var_dump($return2);
            }
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

    //curl请求
    public function curl_request($url,$post='',$cookie='', $returnCookie=0){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_REFERER, "http://XXX");
        if($post) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
        }
        if($cookie) {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
        curl_setopt($curl, CURLOPT_TIMEOUT, 20);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_BINARYTRANSFER, true); 
        $data = curl_exec($curl);
        if (curl_errno($curl)) {
            return curl_error($curl);
        }
        curl_close($curl);
        if($returnCookie){
            list($header, $body) = explode("\r\n\r\n", $data, 2);
            preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
            $info['cookie']  = substr($matches[1][0], 1);
            $info['content'] = $body;
            return $info;
        }else{
            return $data;
        }
}

}





?>