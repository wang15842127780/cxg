<?php
/**
 * zip下载类文件
 * 遍历目录，打包成zip格式
 */
class traverseDir{
    public $currentdir;//当前目录
    public $filename;//文件名
    public $fileinfo;//用于保存当前目录下的所有文件名和目录名以及文件大小
    public $savepath;
    public function __construct($curpath,$savepath,$name){
        $this->currentdir=$curpath;//返回当前目录
        $this->savepath=$savepath;//返回当前目录
        $this->name = $name;
    }
    //遍历目录
    public function scandir($filepath){
        if (is_dir($filepath)){
            $arr=scandir($filepath);
            foreach ($arr as $k=>$v){
                $this->fileinfo[$v][]=$this->getfilesize($v);
            }
        }else {
            echo "<script>alert('当前目录不是有效目录');</script>";
        }
    }
    /**
     * 返回文件的大小
     *
     * @param string $filename 文件名
     * @return 文件大小(KB)
     */
    public function getfilesize($fname){
        return filesize($fname)/1024;
    }
    /**
     * 压缩文件(zip格式)
     */
    public function tozip($items){
        $savepath = "./TestImg/";
        $zip=new ZipArchive();
        // $zipname=date('Ymd',time());
        $zipname = $this->name.date("Ymd",time());
        if (!file_exists($zipname)){
            if ($zip->open($savepath.$zipname.".zip", ZIPARCHIVE::CREATE)!==TRUE) {
                exit("cannot open ".$savepath.$zipname.".zip\n");
            }
            for ($i=0;$i<count($items);$i++){
                $zip->addFile($savepath.$items[$i],$items[$i]);
            }
            $zip->close();
            return $savepath.$zipname.".zip";
        }
    }
}