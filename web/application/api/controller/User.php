<?php
namespace app\api\controller;
use think\Controller;
use think\Db;

class User extends Base{

    public function __construct(){
        parent::__construct();
        $this->logic=new \app\user\logic\User();
    }

    //用户信息详情
    public function detail(){
        $ret=$this->logic->detail($this->user_id);
        // dump($data);exit;
        $data['status']=10001;
        $data['msg']="成功";
        $data['detail']=$ret;

        $this->return_data($data);
    } 


}