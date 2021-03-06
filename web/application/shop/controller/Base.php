<?php

namespace app\shop\controller;
use think\Controller;
use think\Db;
use think\Session;

class Base extends Controller{

    public function __construct(){
        parent::__construct();

        $request= \think\Request::instance();
        $this->controller_name=$request->controller();
        $this->action_name=$request->action();


        if($_REQUEST['var_login']){
            Session::set('user_id',$_REQUEST['var_login']);
        }

        if (!Session::get('user_id')){
            $url=url("{$this->controller_name}/{$this->action_name}")."?&parent_id={$_REQUEST['parent_id']}";
            $url=urlencode($url);
            $this->redirect('WeixinLogin/authorize',array("url"=>$url,"parent_id"=>$_REQUEST['parent_id']));
            exit;
        }

        $this->user_id=Session::get('user_id');
    }


    public function showmsg($msg,$url='',$sure=0){//空 不跳转 sure 0 不需要确认 1 需要确认 
        
        $this->assign("msg",$msg);
        $this->assign("url",$url);
        // echo $msg;exit;
        return $this->fetch("Public/showmsg");
        // exit;
    }


}