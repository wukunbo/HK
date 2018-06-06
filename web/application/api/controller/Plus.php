<?php
namespace app\api\controller;
use think\Controller;
use think\Db;

class Plus extends Base{

    public function __construct(){
        parent::__construct();
        $this->logic=new \app\plus\logic\Image();
    }


    //上传图片
    public function upload_img(){
        
        $file=$_FILES['myfile'];        
            
        if(!$user_id){
            $user_id=$_REQUEST[user_id];
        }
 
        $data=$this->logic->Upload_img($file,$type,$user_id);
        echo json_encode($data);
    }

}