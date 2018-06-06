<?php 
namespace app\plus\logic;
use think\Model;
use think\Db;
use think\Config;

class Image extends Model{

    public function __construct(){
        $this->db= new \app\userweb\model\PublicModel();
        // $this->img_url="http://".$_SERVER["HTTP_HOST"]."/lingdu/web/";
        $this->img_url=config('DOMAIN')."/";
    }


    public function Upload_img($file,$type,$user_id){
        // echo $_SERVER["HTTP_HOST"];exit;
        ini_set('display_errors', 'Off');  
        error_reporting(E_ALL & ~ E_WARNING);

        if(!$type){
            $type="public";
        }
        if(!$user_id){
            $user_id="0";
        }
        if ($file==null){           
            $data['status']="10009";                
            return $data;               
            exit;           
        }       
        $tmp_type=$file['type'];              
        $uptypes=array('image/jpg','image/jpeg','image/png','image/pjpeg','image/gif','image/bmp','image/x-png');  
        if(!in_array($tmp_type,$uptypes)){                  
            $data['status']="10006";            
        }else {     
            //var_dump($user_id);
            $fliedir="Uploads/";            
            mkdir($fliedir);            
            $fliedir=$fliedir."$type/";         
            mkdir($fliedir);                    
            $fliedir=$fliedir."$user_id/";          
            mkdir($fliedir);            
            $cur_time=uniqid()."-".time();
            $file_type=str_replace("image/","",$tmp_type);
            $file_name=$fliedir.$user_id.'-orogin-'.'-'.$type.'-'.$cur_time.".".$file_type;         
            move_uploaded_file($file["tmp_name"],$file_name);         
            $none=file_exists($file_name);                          
            //var_dump($file_name);                     
            if ($none!=null){
                // $image = new \think\Image();
                $data["status"]=10001;    
                $data["img_orogin"]=$this->img_url.$file_name;   
                // $image->open($file_name);       
                // $img_thumb=$fliedir.$user_id.'-thumb'.'-'.$type.'-'.$cur_time.".".$file_type;
                $img_thumb=$this->img_url.$file_name;     
                if ($type=="goods"){
                    // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
                    //$image->thumb(300, 300,\think\Image::IMAGE_THUMB_FIXED)->save($img_thumb); 
                //  $image->thumb(800, 800,\Think\Image::IMAGE_THUMB_FIXED)->save($file_name); 
                }else {
                    //$image->save($img_thumb); 
                }
                
                // $data["img_thumb"]=$this->img_url.$img_thumb;    
                $data["img_thumb"]=$data["img_orogin"];                
            }else {             
                $data["status"]=10012;            
            }               
        }   

    //  dump($data);
        return $data;       
    }

}