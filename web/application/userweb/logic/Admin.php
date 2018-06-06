<?php 
namespace app\userweb\logic;
use think\Model;
use think\Db;

class Admin extends Model{

    public function __construct(){
        $this->db= new \app\userweb\model\PublicModel();
    }

    //页面显示
    public function add_adm($wx_id){
      $array2[table]='user_child_role';
      $array2[order]='role_id desc';
      $array2[where]="wx_id='$wx_id'";
      $data[role]=$this->db->Select($array2);
      $id=input("id");
      if($id !=NULL){
        $array['table']="user_child";
        $array['where']="id='$id'";
        $data=$this->db->Find($array);
        $data[role]=$this->db->Select($array2);
      }
      return $data;
    }


    //添加管理员
    public function add($post){
 
      if($post['tl_adm_password']){
        $post['tl_adm_password']=sha1($post['tl_adm_password']);
      }
      
 
      //修改管理员
      if($post['id']){
        
        //不能更改用户名
        unset($post['tl_adm_username']);
        if(!$post['tl_adm_password']){
          unset($post['tl_adm_password']);
        }
        Db::name('user_child')->where("id={$post['id']}")->update($post);
        $id=$post['id'];
      }else{
        $is=Db::name("user_child")->where("tl_adm_username='".$post['tl_adm_username']."'")->value("id");
         
        if($is){
            
            $data[status]=10002;
            return $data;
        }
         
        $post['add_time']=time();
        $id=Db::name('user_child')->insertGetId($post);
        
      }
      if($id){
          $data[status]=10001;
      }else{
          $data[status]=10002;
      }
      return $data;
    }


    public function adm_lists($wx_id){
        $array[table]='user_child';
        $array[where]="wx_id='$wx_id'";
        $data=$this->db->Page($array);
        return $data;
    }

}