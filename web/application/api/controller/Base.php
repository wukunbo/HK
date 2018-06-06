<?php
namespace app\api\controller;
use think\Controller;
use think\Db;

class Base extends Controller{

    public function __construct(){
        parent::__construct();
        $request= \think\Request::instance();
        $this->controller_name=$request->controller();
        $this->action_name=$request->action();

        $this->token_login=new \app\api\logic\Token();

        $controller_arr=array("Login","Reg","Code");

        if(!in_array($this->controller_name,$controller_arr) && $_REQUEST['visit']!='public' && !$_REQUEST["var_login"]){

            $res=$this->token_login->user_token($_REQUEST[token]);
            if($res[status]==20000){
                $res[msg]="token不匹配";
                echo json_encode($res);
                exit;
            }elseif($res[status]==30001) {
                $res[msg]="该用户已被冻结";
                echo json_encode($res);
                exit;
            }else{
                $this->user_id=$res[user_id];
            }
        }

        if($_REQUEST["var_login"]){
            $this->user_id=$_REQUEST[var_login];
        }
    }



    //跨域jsonp
    public function return_data($data,$type="josn",$lists_fomat=""){
        if($lists_fomat==1){
             
            $res[status]=10001;
            $res[page_num]=$data[lists][page_num];
            $res[sql]=$data[lists][sql];
            $res[total]=$data[lists][total];
            $res[lists]=$data[lists][content];
             
            unset($data);
            $data=$res;
        }
        $data=json_encode($data);       
        echo $data;
        exit;
        //echo $data=$_GET["callback"]."(". $data.");";
  
    }


    //检查是否登录
    
    public function is_login(){
    
        if(!$this->user_id){

            $this->user_id=Db::name("user")->where("token='".$_REQUEST[token]."'")->value("id");
            if(!$this->user_id){
                $res[msg]="尚未登录";
                $res[status]=20002;
                echo json_encode($res);
                exit;
            }
        }
    }


}