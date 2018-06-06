<?php

namespace app\user\controller;
use think\Controller;
use think\Db;

class Index extends Controller{

    public function __construct(){
        parent::__construct();
    }



    //个人中心首页
    public function index(){
        $this->assign('page_title','我的');

        return $this->fetch();
    }
}