<?php
namespace app\userweb\controller;
use Think\Controller;

class Index extends Base{

    //初始化方法
    public function __construct(){
        parent::__construct();

    }

    public function index(){
        return $this->fetch();
    }
}
