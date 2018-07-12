<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\ManageModel;
use Home\Model\MenuModel;
use Home\Model\EntranceModel;
use Home\Model\StudentModel;
use Admin\Model\StudentLeaveModel;
use Home\Model\ClassModel;

class EnterController extends Controller{
	public function index(){
    	//身份判断
    	if(empty($_COOKIE['user']))
    	{
    		$this->login();
    		die;
    	}
        $menu = new MenuModel();
        $act = @$_GET['id'];
        $res = $this->yanzheng($act);
        if(!$res)
        {
            $this->error('URL有误',header("Location:/cxg"));
        }
        
        // $main_menu = $menu->getMenu(array('parent_id'=>0));
        // $menus = $menu->getMenuTree();
        // $this->assign('main_menu',$main_menu);
        // $this->assign("menu",$menus);

        //身份判断
        if($_COOKIE['type'] == 1)
        {
            // $this->getWarningInfo();
            $this->manage();
        }
        elseif($_COOKIE['type'] == 2)
        {
            $this->teacher();
        }
        elseif($_COOKIE['type'] == 3)
        {
            $this->shitang();
        }
        elseif($_COOKIE['type'] == 4)
        {
            $this->sushe();
        }
        elseif($_COOKIE['type'] == 5)
        {
            $this->menwei();
        }

        $this->assign("typ",$act);
        $type = explode(".",$act)[1];
        switch($type)
        {
            case "47":
            // $this->viewEntrance();
            $this->leaveDetail();
            break;
            case "48":
            $this->leaveRecord();
            break;
            default:;
        }
        
    }

    public function login()
    {
    	header("Location:/cxg/index.php");
    }

    //验证路径
    public function yanzheng($type)
    {
        $menu = new MenuModel();
        $a = explode(".",$type)[0];
        $b = explode(".",$type)[1];
        $array1 = $menu->getMenu(array('parent_id'=>$a));
        $array2 = $menu->getMenu(array('id'=>$b));
        $c = array();
        if(!empty($array1))
        {
            foreach($array1 as $k=>$v)
            {
                $c[] = $v['id'];
            }
        }
        else
        {
            return false;
            die;
        }
        $id = $array2[0]['parent_id'];
        if(!in_array($id,$c))
        {
            return false;
            die;
        }
        else
        {
            return true;
            die;
        }
    }

//身份判断
    public function manage()
    {
        $menu = new MenuModel();
        $main_menu = $menu->getMenu(array('parent_id'=>0));
        $menus = $menu->getMenuTree();
        $this->assign('main_menu',$main_menu);
        $this->assign("menu",$menus);
    }

    public function teacher()
    {
        $menu = new MenuModel();
        $main_menu = $menu->getMenu(array('parent_id'=>0));
        $menus = $menu->getMenuTree();
        $shell = array(1,2,3,64);
        foreach($main_menu as $k=>$v)
        {
            if(in_array($v['id'],$shell))
            {

            }
            else
            {
                unset($main_menu[$k]);
            }
        }

        $this->assign('main_menu',$main_menu);
        $this->assign("menu",$menus);
    }
    public function shitang()
    {
        $menu = new MenuModel();
        $main_menu = $menu->getMenu(array('parent_id'=>0));
        $menus = $menu->getMenuTree();
        $shell = array(5,64);
        foreach($main_menu as $k=>$v)
        {
            if(in_array($v['id'],$shell))
            {

            }
            else
            {
                unset($main_menu[$k]);
            }
        }

        $this->assign('main_menu',$main_menu);
        $this->assign("menu",$menus);
    }

    public function sushe()
    {
        $menu = new MenuModel();
        $main_menu = $menu->getMenu(array('parent_id'=>0));
        $menus = $menu->getMenuTree();
        $shell = array(2,64);
        foreach($main_menu as $k=>$v)
        {
            if(in_array($v['id'],$shell))
            {

            }
            else
            {
                unset($main_menu[$k]);
            }
        }

        $this->assign('main_menu',$main_menu);
        $this->assign("menu",$menus);
    }

    public function menwei()
    {
        $menu = new MenuModel();
        $main_menu = $menu->getMenu(array('parent_id'=>0));
        $menus = $menu->getMenuTree();
        $shell = array(4,64);
        foreach($main_menu as $k=>$v)
        {
            if(in_array($v['id'],$shell))
            {

            }
            else
            {
                unset($main_menu[$k]);
            }
        }

        $this->assign('main_menu',$main_menu);
        $this->assign("menu",$menus);
    }


//===============================================================================================
    //人员管理
    public function editPass()
    {
    	$type = @$_POST['typ'];
    	if($type == 'json')
    	{
    		$new = $_POST['new_pass'];
    		$user = $_COOKIE['user'];
    		$manage = new ManageModel();
    		$info = $manage->getManage(array('nick'=>$user));
    		$info = array_values($info);
    		$id = $info[0]['id'];
    		$cond = array();
    		$cond['password'] = md5($new);
    		$res = $manage->editManage($id,$cond);
    		$return = array();
    		if($res)
    		{
    			setcookie('user','',time()-3600,"/");
				setcookie('type','',time()-3600,"/");
    			$return['status']	= 'success';
    			$return['content']	= '修改成功，请重新登录！';
    		}
    		else
    		{
    			$return['status']	= 'failure';
    			$return['content']	= '修改失败！';
    		}
    		$this->ajaxReturn($return);
    	}
    	else
    	{
    		$this->display('editPass');
    	}
    }


    public function checkPass()
    {
    	$type = @$_POST['typ'];
    	$return = array();
    	if($type == 'json')
    	{
    		$old = $_POST['old'];
    		$user = $_COOKIE['user'];
    		$manage = new ManageModel();
    		$info = $manage->getManage(array('nick'=>$user));
    		$info = array_values($info);
    		$pass = $info[0]['password'];
    		if($pass == md5($old))
    		{
    			$return['status']	= 'success';
    			$return['content']	= '';
    		}
    		else
    		{
    			$return['status']	= 'failure';
    			$return['content']	= '旧密码不正确，请重新输入！';
    		}

    	}
    	else
    	{
    		$return['status']	= 'failure';
    		$return['content']	= '协议内容有误！';
    	}
    	$this->ajaxReturn($return);
    }

//==============================================================================================================
    //人员出入信息
    public function viewEntrance()
    {
        $type = @$_POST['typ'];
        if($type == 'json')
        {
            $return = array();
            $str = 1;
            $pname = @$_POST['pname'];
            $stime = @$_POST['stime'];
            $etime = @$_POST['etime'];
            if(!empty($pname))
            {
                $str .= " AND person_name like '%".$pname."%'";
            }
            if(!empty($stime))
            {
                $str .= " AND time>'".$stime."'";
            }
            if(!empty($etime))
            {
                $str .= " AND time<'".$etime."'";
            }
            $entrance = new EntranceModel();
            $enter_list = $entrance->getEntrance($str);
            if(!empty($enter_list))
            {
                foreach($enter_list as $k=>$v)
                {
                    if($v['type'] == "in")
                    {
                        $enter_list[$k]['type'] = "进入学校";
                    }
                    else
                    {
                        $enter_list[$k]['type'] = "离开学校";
                    }
                }
                $return['status']   = 'success';
                $return['content']  = $enter_list;
            }
            else
            {
                $return['status']   = 'failure';
                $return['content']  = '暂无该条件的数据';
            }
            $this->ajaxReturn($return);
        }
        else
        {
            $this->display('viewEntrance');
        }
    }

    //查看请假记录
    public function leaveRecord()
    {
        $type = @$_POST['typ'];
        if($type == 'json')
        {
            $leave = new StudentLeaveModel();
            $cond = array();
            $student = new StudentModel();
            // $slist = $student->getAssocStudent();
            $t = date("Y-m-d 00:00:00",time()-24*3600);
            $tt = array();
            $tt['begin_date'] = array("gt",$t);
            $aaa = $leave->getStudentLeave($tt);
            $aids = array();
            foreach($aaa as $c=>$cc)
            {
                $aids[] = $cc['student_id'];
            }
            $bb = array();
            $bb['id'] = array("IN",$aids);
            $sslist = $student->getStudent($bb);
            $slist = array();
            foreach ($sslist as $d => $dd) {
                $slist[$dd['id']] = $dd;
            }


            $class = new ClassModel();
            $class_list = $class->getAssocClass();
            foreach($slist as $kk=>$vv)
            {
                $slist[$kk]['class_text'] = $class_list[$vv['class_id']]['name'];
            }
            if(!empty($_POST['uname']))
            {
                $ids = array();
                $uname = $_POST['uname'];
                $student_list = $student->getStudent(array('name'=>$uname));
                foreach($student_list as $k=>$v)
                {
                    $ids[] = $v['id'];
                }
                $cond['student_id'] = array("IN",$ids);
            }
            if(!empty($_POST['stime']))
            {
                $stime = $_POST['stime'];
                $cond['begin_date'] = array('gt',$stime);
            }
            if(!empty($_POST['etime']))
            {
                $etime = $_POST['etime'];
                $cond['end_date'] = array('lt',$etime);
            }
            if($_POST['status'] == 10)
            {
                $cond['status'] = array('gt',0);
            }
            elseif(!empty($_POST['status']))
            {
                $cond['status'] = $_POST['status'];
            }
            else
            {
                $cond['status'] = 5;
            }

            $status = array(
                1=>'待提交',
                3=>'待签收',
                4=>'待批准',
                5=>'已批准',
                6=>'已完成',
                7=>'已退回'
            );
            $leave_list = $leave->getStudentLeave($cond,array('id'=>"desc"));
            if(!empty($leave_list))
            {
                foreach($leave_list as $key=>$val)
                {
                    $leave_list[$key]['student_text'] = $slist[$val['student_id']]['name'];
                    $leave_list[$key]['class_text'] = $slist[$val['student_id']]['class_text'];
                    $leave_list[$key]['status_text'] = $status[$val['status']];
                }
                $return['status']   = 'success';
                $return['content']  = $leave_list;
            }
            else
            {
                $return['status']   = 'failure';
                $return['content']  = '暂无该条件的数据';
            }
            $this->ajaxReturn($return);

        }
        else
        {
            $this->display('leaveRecord');
        }
    }

    public function leaveDetail()
    {
    	$leave = new StudentLeaveModel();
    	$cond = array();
    	$cond['status'] = 5;
    	$leave_list = $leave->getStudentLeave($cond,array("id"=>"desc"));
    	$status = array(
    		1=>'待提交',
    		3=>'待签收',
    		4=>'待批准',
    		5=>'已批准',
    		6=>'已完成',
    		7=>'已退回'
    	);
    	$student = new StudentModel();
    	// $student_list = $student->getAssocStudent();
        $t = date("Y-m-d 00:00:00",time()-24*3600);
        $tt = array();
        $tt['begin_date'] = array("gt",$t);
        $aaa = $leave->getStudentLeave($tt);
        $aids = array();
        foreach($aaa as $c=>$cc)
        {
            $aids[] = $cc['student_id'];
        }
        $bb = array();
        $bb['id'] = array("IN",$aids);
        $sslist = $student->getStudent($bb);
        $student_list = array();
        foreach ($sslist as $d => $dd) {
            $student_list[$dd['id']] = $dd;
        }
    	$class = new ClassModel();
    	$class_list = $class->getAssocClass();
    	foreach($student_list as $k=>$v)
    	{
    		$student_list[$k]['class_text'] = $class_list[$v['class_id']]['name'];
    	}
    	foreach($leave_list as $key=>$val)
    	{
    		$leave_list[$key]['status_text'] = $status[$val['status']];
    		$leave_list[$key]['name_text'] = $student_list[$val['student_id']]['name'];
    		$leave_list[$key]['class_text'] = $student_list[$val['student_id']]['class_text'];
    		$leave_list[$key]['photo_text'] = $student_list[$val['student_id']]['photo'];
    	}
    	$this->assign('list',$leave_list);
    	$this->display('leaveDetail');
    }

    public function getStudentById($id=null)
    {
    	$type = @$_POST['typ'];
    	$return = array();
    	$student = new StudentModel();
		$leave = new StudentLeaveModel();
		$class = new ClassModel();
    	if($type == 'json')
    	{
    		$student_list = $student->getAssocStudent();
            $t = date("Y-m-d 00:00:00",time()-24*3600);
            $tt = array();
            $tt['begin_date'] = array("gt",$t);
            $aaa = $leave->getStudentLeave($tt);
            $aids = array();
            foreach($aaa as $c=>$cc)
            {
                $aids[] = $cc['student_id'];
            }
            $bb = array();
            $bb['id'] = array("IN",$aids);
            $sslist = $student->getStudent($bb);
            $student_list = array();
            foreach ($sslist as $d => $dd) {
                $student_list[$dd['id']] = $dd;
            }
            
    		$class_list = $class->getAssocClass();
    		foreach($student_list as $k=>$v){
    			$student_list[$k]['class_text'] = $class_list[$v['class_id']]['name'];
    		}
    		if(!empty($_POST['qqid']))
            {
                $aid = $_POST['qqid'];
                $llist = $leave->getStudentLeave(array('id'=>$aid));
                $id = $llist[0]['student_id'];
            }
    		if(empty($id))
    		{
    			$return['status']	= 'failure';
    			$return['content']	= '传值错误！';
    		}
    		else
    		{
    			$cond = array();
    			$cond['student_id'] = $id;
    			$leave_list = $leave->getStudentLeave($cond,array("id"=>"desc"));
    			$status = array(
    				1=>'<span style="color:red;">待提交</span>',
    				3=>'<span style="color:red;">待签收</span>',
    				4=>'<span style="color:red;">待审核</span>',
    				5=>'<span style="color:green;">已批准</span>',
    				6=>'<span style="color:red;">已完成</span>',
    				7=>'<span style="color:red;">已退回</span>'
    			);
    			if(!empty($leave_list))
    			{
    				// $leave_info = $leave_list[0];
    				// $leave_info['class_text'] = $student_list[$leave_info['student_id']]['class_text'];
    				// $leave_info['name_text'] = $student_list[$leave_info['student_id']]['name'];
    				// $leave_info['status_text'] = $status[$leave_info['status']];
    				// $leave_info['photo_text'] = $student_list[$leave_info['student_id']]['photo'];
    				// $return['status']	= 'success';
    				// $return['content']	= $leave_info;
                    $leave_info = $leave_list[0];
                    $leave_info['class_text'] = $student_list[$leave_info['student_id']]['class_text'];
                    $leave_info['name_text'] = $student_list[$leave_info['student_id']]['name'];
                    $leave_info['photo_text'] = $student_list[$leave_info['student_id']]['photo'];
                    if($leave_info['type']==1)
                    {
                        $sdate = date("Y-m-d",time());
                        $stime = date("H:i:s",time());
                        $leave_info['leave_date'] = $leave_info['begins_date']."-".$leave_info['ends_date']."<br>每天<br> ".$leave_info['begins_time']." - ".$leave_info['ends_time'];
                        if(($sdate>=$leave_info['begins_date']&&$sdate<=$leave_info['ends_date']) && ($stime>=$leave_info['begins_time']&&$stime<=$leave_info['ends_time']))
                        {
                            $leave_info['status_text'] = $status[$leave_info['status']];
                            $return['status']   = 'success';
                            $return['content']  = $leave_info;
                        }
                        else
                        {
                            $leave_info['status_text'] = '不在请假时间范围内！';
                            $return['status']   = 'success';
                            $return['content']  = $leave_info;
                        }
                    }
                    else
                    {
                        $stime = date("Y-m-d H:i:s",time());
                        $leave_info['leave_date'] = $leave_info['begin_date']."<br>至<br>".$leave_info['end_date'];
                        if($stime>=$leave_info['begin_date']&&$stime<=$leave_info['end_date'])
                        {
                            $leave_info['status_text'] = $status[$leave_info['status']];
                            
                            $return['status']   = 'success';
                            $return['content']  = $leave_info;
                        }
                        else
                        {
                            $leave_info['status_text'] = '不在请假时间范围内！';
                            $return['status']   = 'success';
                            $return['content']  = $leave_info;
                        }
                    }

    			}
    			else
    			{
    				
    				$res = array();
    				$res['status_text'] = '该学生暂无请假信息！';
    				$res['class_text'] = $student_list[$id]['class_text'];
    				$res['name_text'] = $student_list[$id]['name'];
    				$return['status']	= 'success';
    				$return['content']	= $res;
    			}
    		}
    		$this->ajaxReturn($return);
    	}
    	else
    	{
    		$student_list = $student->getAssocStudent();
    		$class_list = $class->getAssocClass();
    		foreach($student_list as $k=>$v){
    			$student_list[$k]['class_text'] = $class_list[$v['class_id']]['name'];
    		}
    		if(empty($id))
    		{
    			$return['status']	= 'failure';
    			$return['content']	= '传值错误！';
    		}
    		else
    		{
    			$cond = array();
    			$time = date('Y-m-d 00:00:00',time()-24*3600);
    			$cond['begin_date'] = array("gt",$time);
    			$cond['student_id'] = $id;
    			$leave_list = $leave->getStudentLeave($cond,array("id"=>"desc"));
    			$status = array(
                    1=>'<span style="color:red;">待提交</span>',
                    3=>'<span style="color:red;">待签收</span>',
                    4=>'<span style="color:red;">待审核</span>',
                    5=>'<span style="color:green;">已批准</span>',
                    6=>'<span style="color:red;">已完成</span>',
                    7=>'<span style="color:red;">已退回</span>'
                );
    			if(!empty($leave_list))
    			{
    				// $leave_info = $leave_list[0];
    				// $leave_info['class_text'] = $student_list[$leave_info['student_id']]['class_text'];
    				// $leave_info['name_text'] = $student_list[$leave_info['student_id']]['name'];
    				// $leave_info['status_text'] = $status[$leave_info['status']];
    				// $leave_info['photo_text'] = $student_list[$leave_info['student_id']]['photo'];
    				// $return['status']	= 'success';
    				// $return['content']	= $leave_info;
                    $leave_info = $leave_list[0];
                    $leave_info['class_text'] = $student_list[$leave_info['student_id']]['class_text'];
                    $leave_info['name_text'] = $student_list[$leave_info['student_id']]['name'];
                    $leave_info['photo_text'] = $student_list[$leave_info['student_id']]['photo'];
                    if($leave_info['type']==1)
                    {
                        $sdate = date("Y-m-d",time());
                        $stime = date("H:i:s",time());
                        $leave_info['leave_date'] = $leave_info['begins_date']." - ".$leave_info['ends_date']." 每天 ".$leave_info['begins_time']." - ".$leave_info['ends_time'];
                        if(($sdate>=$leave_info['begins_date']&&$sdate<=$leave_info['ends_date']) && ($stime>=$leave_info['begins_time']&&$stime<=$leave_info['ends_time']))
                        {
                            $leave_info['status_text'] = $status[$leave_info['status']];
                            $return['status']   = 'success';
                            $return['content']  = $leave_info;
                        }
                        else
                        {
                            $leave_info['status_text'] = '不在请假时间范围内！';
                            $return['status']   = 'success';
                            $return['content']  = $leave_info;
                        }
                    }
                    else
                    {
                        $stime = date("Y-m-d H:i:s",time());
                        $leave_info['leave_date'] = $leave_info['begin_date']."至".$leave_info['end_date'];
                        if($stime>=$leave_info['begin_date']&&$stime<=$leave_info['end_date'])
                        {
                            $leave_info['status_text'] = $status[$leave_info['status']];
                            
                            $return['status']   = 'success';
                            $return['content']  = $leave_info;
                        }
                        else
                        {
                            $leave_info['status_text'] = '不在请假时间范围内！';
                            $return['status']   = 'success';
                            $return['content']  = $leave_info;
                        }
                    }

    			}
    			else
    			{
    				
    				$res = array();
    				$res['status_text'] = '该学生暂无请假信息！';
    				$res['class_text'] = $student_list[$id]['class_text'];
    				$res['name_text'] = $student_list[$id]['name'];
    				$return['status']	= 'success';
    				$return['content']	= $res;
    			}
    		}
    	}
    	return $return;
    }

    function curl_request($url,$post='',$cookie='', $returnCookie=0){
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

    //读取alarm 人脸截图照片
    function fetch_cface($strJSON)
    {
        $cmd="/rtmonitor/alarm";
        $url="http://192.168.1.234:8000";
        $return1 = json_decode($strJSON);
        if (isset($return1)&&!empty($return1))
        {

                         
                         $photo_host_id=$return1->photo_host_id;
                         $face_name=$return1->face_name;
                         $face_image_url=$url.$cmd."/cface/".$photo_host_id."?filename=".$face_name;
                         $imginfo=$this->curl_request($face_image_url);
                         $img_info_arr=json_decode($imginfo);
                          if($img_info_arr->ret==0 && isset($img_info_arr->image_data))
                              {
                               $imgo= $img_info_arr->image_data;
                               $img=$imgo->content;
                               }
                        
        return $img;

        }
    }
    //读取alarm 命中人员人脸照片
    function fetch_person_face($strJSON)
    {
        $cmd="/rtmonitor/alarm";
        $url="http://192.168.1.234:8000";
        
        $return1 = json_decode($strJSON);
        if (isset($return1)&&!empty($return1))
        {
                  $i= 0;
                         $photo_host_id=$return1->photo_host_id;
                         $alarm_type=$return1->alarm_type;   
                              
                         if ($alarm_type==1)
                             {
                               $simi=$return1->search_list[0]->similarity;
                               $person_name=$return1->search_list[0]->person_name;
                               $face_image_url=$return1->search_list[0]->face_url;
                               $face_image_url=str_replace("http://api.facecloud.reconova.com",$url,$face_image_url);
                              
                               $imginfo=$this->curl_request($face_image_url);
                               $img_info_arr=json_decode($imginfo);
                                if($img_info_arr->ret==0 && isset($img_info_arr->image_data))
                                 {
                                  $imgo= $img_info_arr->image_data;
                                  $img=$imgo->content;
                                 }
                               }
                        
        return $img;
        }

    }
    public function getFace()
    {
        $strJSON = $_REQUEST['dd'];
        $return = array();
        $return['img1'] = $this->fetch_cface($strJSON);
        $return['img2'] = $this->fetch_person_face($strJSON);
        $ss = json_decode($strJSON);
        $id = $ss->search_list[0]->person_name;
        $return['pinfo'] = $this->getStudentById($id);
        $return['pid'] = $id;
        $return['act'] = 'a';
        $this->ajaxReturn($return);
    }
}
?>