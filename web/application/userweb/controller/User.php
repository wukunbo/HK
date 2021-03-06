<?php
namespace app\userweb\controller;
use Think\Controller;
use think\Db;

class User extends Base{

    public function __construct(){
        parent::__construct();
        $this->logic= new \app\user\logic\User();
    }

    //会员列表
    public function lists(){

        $search[status]=$_REQUEST['status'];
        $search[start_time]=$_REQUEST[start_time];
        $search[end_time]=$_REQUEST[end_time];
        $search[nick_phone]=$_REQUEST[nick_phone];
        
        $data=$this->logic->user_lists($search);
        // dump($data);exit;
        $this->assign('data',$data);
        return $this->fetch("User/lists");
    }


    //会员详情
    public function detail(){
        $id = input('id');
        $data=$this->logic->detail($id);

        $this->assign('data',$data);
        return $this->fetch("User/detail");
    }


}