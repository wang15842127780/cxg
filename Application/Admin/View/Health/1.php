<!DOCTYPE html>
<?php
//参数1：访问的URL，参数2：post数据(不填则为GET)，参数3：提交的$cookies,参数4：是否返回$cookies
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

function person_register($img1,$person_name,$xingbie)
{
                //人脸检测
				$site= "http://192.168.1.234:8000";
 
                $cmd = "/faceops/image_detection";
    
				$url=$site.$cmd;
                $data1 = json_encode(array('image_data' => array('type' => 'jpg','content'=>$img1 )));
            
                
                //curl使用post方式传输数据
                $ch1 = curl_init();
                curl_setopt($ch1, CURLOPT_URL, $url);
                curl_setopt($ch1, CURLOPT_POST, 1);
                curl_setopt($ch1, CURLOPT_POSTFIELDS, $data1);
                curl_setopt($ch1,CURLOPT_RETURNTRANSFER,1);
                //执行数据操作
                curl_exec($ch1);
                $return1 = curl_multi_getcontent($ch1); 

                $return1 = json_decode($return1);
                
                $image1=$return1->dection_list[0]->image_data;
                $image1=$image1->content;
                $feature1=$return1->dection_list[0]->feature_data;
                $feature1=$feature1->content;

  
				curl_close($ch1);
				
				 
				$cmd="/facedb/1/persons?name=".$person_name."&sex=".$xingbie."&card_type=128";
				$url=$site.$cmd;
 
                //curl使用post方式传输数据
                $ch1 = curl_init();
                curl_setopt($ch1, CURLOPT_URL, $url);
                curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch1, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch1,CURLOPT_RETURNTRANSFER,1);
                curl_exec($ch1);
                $return1 = curl_multi_getcontent($ch1); 

                $return1 = json_decode($return1);
				$person_id=$rerurn1->person_data->person_id;

              
                $data['image_data']=array('type' => 'jpg','content'=>$image1);
                $data['festure_data']=array('content'=>$feature1);   
                $data['blur']=1;
                $data = json_encode($data);
                $cmd="/facedb/1/persons/".$person_id."/faces";
				$url=$site.$cmd;
                $ch1 = curl_init();
                curl_setopt($ch1, CURLOPT_URL, $url);
                curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch1, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch1,CURLOPT_RETURNTRANSFER,1);
                curl_exec($ch1);
                $return1 = curl_multi_getcontent($ch1); 

                $return1 = json_decode($return1);

				if ($return1->ret==0)return json_encode(array('ret'=>'success'));

}
				
?>      

