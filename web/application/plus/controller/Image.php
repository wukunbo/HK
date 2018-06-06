<?php
namespace app\plus\controller;
use think\Controller;
use think\Db;
use think\Session;

class Image extends Controller{

    public function __construct(){
        parent::__construct();
        $this->image_logic=new \app\plus\logic\Image();
        $this->user_id=Session::get('userweb_userid');    
    }


    public function upload_img(){
        
        $file=$_FILES['myfile'];        
        $type=$_REQUEST['type'];  
        $user_id=$this->user_id;
        if(!$user_id){
            $user_id=$_REQUEST[user_id];
        }
 
        $data=$this->image_logic->Upload_img($file,$type,$user_id);

        echo json_encode($data);
     
    }

}