<?php 
namespace app\userweb\logic;
use think\Model;
use think\Session;
use think\Db;

class Login extends Model{

    public function __construct(){
        $this->db= new \app\userweb\model\PublicModel();
    }


    //登录操作
    public function login_action($search){
        $username=trim($search['username']);
        $password=$search['password'];
        $password=sha1($password);
        // $username=str_replace("：",":",$username);
        // if(strpos($username, ':')){ //子账号
        //     return $this->login_action_admin_child($username,$password);
        // }else{
        //     return $this->login_action_admin($username,$password);
        // }
        
        if($username=="admin"){
            return $this->login_action_admin($username,$password);
        }else{  //子账号
            return $this->login_action_admin_child($username,$password);
        }
        
    }



    public function login_action_admin($username,$password){
        $array['where']="loginname ='$username'";
        $array['table']='user';
         
        $detail=$this->db->Find($array);

        // dump($detail);exit;
         
        if ($detail==NULL){
            $data['status']="10002";
            $data['message']="没有这个账号";
             
         
        }else {
            if ($password==$detail['password']){

                
                $data['status']="10001";
                $data['message']='登录成功';
                $data['detail']=$detail;

                Session::set('userweb_userid',$detail['id']);
                Session::set('userweb_username',$detail['loginname']);
                // dump($_SESSION);exit;
                 
            }else {
                $data['status']="10003";
                $data['message']='密码错误';
            }
        }   
        return $data;   
    
    }


    public function login_action_admin_child($username,$password){
        $array['where']="tl_adm_username ='$username'";
        $array['table']='user_child';

        $detail=$this->db->Find($array);

        if ($detail==NULL){
            $data['status']="10002";
            $data['message']="没有这个账号";
        }else {
           
            if ($password==$detail['tl_adm_password']){
                $data['status']="10001";
                $data['message']='登录成功';
                $data['detail']=$detail;
                

                Session::set('userweb_userid',$detail['id']);
                Session::set('userweb_username',$detail['tl_adm_username']);

            }else {
                $data['status']="10003";
                $data['message']='密码错误';
                
            }
        }   
        return $data;   
    
    }


    /*
     * 退出登录
     */
    public function logout(){
        session_destroy();
    }



}