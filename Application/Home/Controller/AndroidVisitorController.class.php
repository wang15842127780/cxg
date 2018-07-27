<?php
namespace Home\Controller;
use Think\Controller;
use Think\Db;
use Admin\Model\EntryRecordModel;
use Admin\Model\ConfigModel;
use Aliyun\DySDKLite\Sms;
use Home\Model\MemberModel;

class AndroidVisitorController extends Controller{
    
    public function addVisitor()
    {
        require_once "/home/wwwroot/cxg/Public/sms-php/demo/sendSms.php";
        $type = $_GET['types'];
        $return = array();
        if($type == 'json')
        {
            $visitor = new EntryRecordModel();
            $add_row = array();
            $add_row['creator_id']  = $_GET['creator_id'];
            $add_row['entry_time']  = $_GET['entry_time'];
            $add_row['number']      = $_GET['number'];
            $add_row['phone']       = trim($_GET['phone']);
            $add_row['rand']        = rand(00000,99999);
            if(!preg_match("/^1[34578]\d{9}$/", $add_row['phone']))
            {
                $return['status']   = 'failure';
                $return['content']  = '电话格式不正确！';
            }
            else
            {
                $visitor->startTrans();
                $res1 = $visitor->addEntryRecord($add_row);
                $config = new ConfigModel();
                $config_info = $config->getConfig(array("name"=>"host_ip"));
                $ip = $config_info[0]['value'];
                $id = $this->getEntryRecordLastId();
                $code = "?i=".$id."&r=".$add_row['rand'];
                $school = "创新谷公司";
                $res2 = \Aliyun\DySDKLite\Sms\Sms::sendSms($add_row['phone'],$code,$add_row['entry_time'],$school);
                $r = $res2->Message;
                if($res1 && $r=='OK')
                {
                    //生成二维码图片
                    $value = "&i=".$id."&n=".rand(0000,9999)."&q=".rand(00000,99999)."&r=".$add_row['rand']."\r";
                    $errorCorrectionLevel = 'L';    //容错级别 
                    $matrixPointSize = 14;           //生成图片大小  

                    //生成二维码图片
                    $s = $id.$rand;
                    $filename = '../qrcode/'.$id.$rand.'.png';
                    QRcode::png($value,$filename , $errorCorrectionLevel, $matrixPointSize, 2);  

                    $QR = $filename;                //已经生成的原始二维码图片文件  
                    $logo = "./Public/images/lingxianguoji.png";
                    if ($logo !== FALSE) { 
                         $QR = imagecreatefromstring(file_get_contents($QR)); 
                         $logo = imagecreatefromstring(file_get_contents($logo));
                         $QR_width = imagesx($QR);//二维码图片宽度 
                         $QR_height = imagesy($QR);//二维码图片高度 
                         $logo_width = imagesx($logo);//logo图片宽度 
                         $logo_height = imagesy($logo);//logo图片高度 
                         $logo_qr_width = $QR_width / 5; 
                         $scale = $logo_width/$logo_qr_width; 
                         $logo_qr_height = $logo_height/$scale; 
                         $from_width = ($QR_width - $logo_qr_width) / 2; 
                         //重新组合图片并调整大小 
                         imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height); 
                    } 
                    //输出图片 
                    imagepng($QR, './Public/qrcode/'.$s.'_logo.png'); 
                	$visitor->commit();
                	$return['status']	= 'success';
                	$return['content']	= '操作成功！';
                }
                else
                {
                	$visitor->rollBack();
                	$return['status']	= 'failure';
                	$return['content']	= '操作失败！';
                }
            }
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

    public function getVisitor()
    {
        $type = @$_GET['types'];
        $return = array();
        if($type == 'json')
        {
           	$id = @$_GET['i'];
           	$rand = @$_GET['r'];
           	$record = new EntryRecordModel();
           	$cond = array();
           	if(empty($id) || empty($rand))
           	{
           		$return['status']	= 'failure';
           		$return['content']	= '无效的二维码！';
           	}
           	else
           	{
           		$cond['id'] = $id;
	           	$cond['rand'] = $rand;
	           	$res = $record->getEntryRecord($cond);
                $aa = date("Y-m-d",time());
	           	if(empty($res) || $res[0]['entry_time']!=$aa)
	           	{
	           		$return['status']	= 'failure';
	           		$return['content']	= '无效的二维码！';
	           	}
	           	else
	           	{
                    $mid = $res[0]['creator_id'];
                    $member = new MemberModel();
                    $rr = $member->getMember(array("id"=>$mid));
                    if(empty($rr))
                    {
                        $return['status']   = 'failure';
                        $return['content']  = '二维码已失效！';
                    }
                    else
                    {
                        $number = $res[0]['number'];
                        $true = $res[0]['true_time'];
                        if((int)$number>=1)
                        {
                            $edit_row = array();
                            if(empty($true))
                            {
                                $edit_row['true_time'] = date("Y-m-d H:i:s",time());
                                $n = $number-1;
                                $edit_row['number'] = $n;
                            }
                            else
                            {
                                $trues = @explode(",",$true);
                                $fff = date("Y-m-d H:i:s",time());
                                if(!in_array($fff,$trues))
                                {
                                    $trues[] = $fff;
                                    $tt = implode(",",$trues);
                                    $edit_row['true_time'] = $tt;
                                    $n = $number-1;
                                    $edit_row['number'] = $n;
                                }
                                    
                            }
                                
                            $re = $record->editEntryRecord($id,$edit_row);
                            if(true)
                            {
                                $return['status']   = 'success';
                                $return['content']  = '成功！';
                            }
                        }
                        else
                        {
                            $return['status']   = 'failure';
                            $return['content']  = '二维码已失效！';
                        }
                    }
    	           		
	           	}
	        }

        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        echo json_encode($return);
    }

    public function addVisitorOnWeixin()
    {
        require_once "/home/wwwroot/cxg/Public/sms-php/demo/sendSms.php";
        $type = $_GET['types'];
        $return = array();
        if($type == 'json')
        {
            $visitor = new EntryRecordModel();
            $add_row = array();
            $add_row['creator_id']  = $_GET['creator_id'];
            $add_row['entry_time']  = $_GET['entry_time'];
            $add_row['number']      = $_GET['number'];
            $add_row['phone']       = '微信好友';
            $add_row['rand']        = rand(00000,99999);

            $visitor->startTrans();
            $res1 = $visitor->addEntryRecord($add_row);
            $id = $this->getEntryRecordLastId();

            $r = $res2->Message;
            if($res1)
            {
                $visitor->commit();
                $return['status']   = 'success';
                $return['content']  = '操作成功！';
                $return['id']       = $id;
                $return['rand']     = $add_row['rand'];
            }
            else
            {
                $visitor->rollBack();
                $return['status']   = 'failure';
                $return['content']  = '操作失败！';
            }
        }
        else
        {
            $return['status']   = 'failure';
            $return['content']  = '协议内容有误！';
        }
        $this->ajaxReturn($return);
    }

    public function getEntryRecordLastId()
    {
    	$entry = new EntryRecordModel();
    	$entry_list = $entry->getEntryRecord(array(),array("id"=>"DESC"));
    	return $entry_list[0]['id'];
    }
	
}
?>