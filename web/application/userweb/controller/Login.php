<?php
namespace app\userweb\controller;
use Think\Controller;

class Login extends Base{

    public function __construct(){
        parent::__construct();
        $this->logic= new \app\userweb\logic\Login();
    }

    //登录页面
    public function login(){
        return $this->fetch("Login/login");  
    }

    public function login_action(){

        $search["username"]=$_REQUEST['username'];
        $search["password"]=$_REQUEST['password'];
        // dump($search);exit;
        $res=$this->logic->login_action($search);
        return json($res);
    }

    //退出
    public function logout(){
        $this->logic->logout();
        $this->redirect("Login/login");
    }


}