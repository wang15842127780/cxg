<?php 
class Excel{  
  
      /** 
       * @param $map excel中的列与数据库列名的映射 
       * @param $map excel中的列与列名的映射 
       * @param $data 数据 
       * @throws PHPExcel_Exception 
       * @throws PHPExcel_Reader_Exception 
       */  
        public static function export($map,$firstRow,$title,$data){  
            require_once '../PHPExcel-1.8/Classes/PHPExcel.php';  
            require_once '../PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';  
//如果要导出xls而不是xlsx，则改为require_once 'PHPExcel/Writer/Excel5.php';  
  
            $objPHPExcel = new PHPExcel();  
            $objPHPExcel->getProperties()->setCreator('http://www.style.net')  
                ->setLastModifiedBy('http://www.style.net')  
                ->setTitle('Office 2007 XLSX Document')  
                ->setSubject('Office 2007 XLSX Document')  
                ->setDescription('Document for Office 2007 XLSX, generated using PHP classes.')  
                ->setKeywords('office 2007 openxml php')  
                ->setCategory('Result file');  
  
            //设置列的宽度，第一行加粗居中  
            foreach ($map as $k=>$v){  
                $objPHPExcel->getActiveSheet()->getColumnDimension($k)->setWidth(22);  
                $objPHPExcel->getActiveSheet()->getStyle($k.'1')->getFont()->setBold(true);  
                $objPHPExcel->getActiveSheet()->getStyle($k.'1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
            }  
  
            //设置列名  
            foreach ($firstRow as $k=>$v){  
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($k,$v);  
            }  
  
            $i = 2;  
  
            foreach ($data as $k=>$v) {  
                foreach ($map as $col=>$name) {  
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col . $i, $v[$name]);  
                }  
                $i++;  
            }  
  
            $objPHPExcel->getActiveSheet()->setTitle($title);  
  
            $objPHPExcel->setActiveSheetIndex(0);  
            $filename1 = urlencode('导出_'.$title) . '_' . date('Y-m-dHis');  
  
//生成xlsx文件  
  
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
            header('Content-Disposition: attachment;filename="' . $filename1 . '.xlsx"');  
            header('Cache-Control: max-age=0');  
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
  
  
//生成xls文件  
            /* 
            header('Content-Type: application/vnd.ms-excel'); 
            header('Content-Disposition: attachment;filename="'.$filename.'.xls"'); 
            header('Cache-Control: max-age=0'); 
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
            */  
            $objWriter->save('php://output');  
        }  
    }
$con = mysql_connect("localhost","root","123456");
if(!$con){
    die("数据库连接失败！");
}
mysql_select_db("manage");
mysql_set_charset("utf8");
$sql = "select number,name,iden,sex,class_id,dormitory_id,contact,contact_phone,note from student";
$res = mysql_query($sql);
$lists = array();
while($re = mysql_fetch_assoc($res))
{
    $lists[] = $re;
}
$sex = array(0=>"女",1=>"男");
foreach ($lists as $key => $value) {
    $lists[$key]['sex'] = $sex[$value['sex']];
    $lists[$key]['iden'] = $value['iden']." ";
    $lists[$key]['contact_phone'] = $value['contact_phone']." ";
}
$filename = "学生信息表".date("Ymd",time());
$map = array('A' => 'number',  
            'B' => 'name',  
            'C' => 'iden',  
            'D' => 'sex'  ,
            'E' => 'class_id'  ,
            'F' => 'dormitory_id'  ,
            'G' => 'contact'  ,
            'H' => 'contact_phone'  ,
            'I' => 'note'  
        ); 
$firstRow = array('A1' => '学号',  
                'B1' => '姓名',  
                'C1' => '身份证号',  
                'D1' => '性别',  
                'E1' => '班级ID',  
                'F1' => '宿舍ID',  
                'G1' => '联系人',  
                'H1' => '联系人电话',  
                'I1' => '备注'  
            );  

excel::export($map, $firstRow, $filename, $lists);
?>