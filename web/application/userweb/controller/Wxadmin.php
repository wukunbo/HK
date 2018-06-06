<?php
namespace app\userweb\controller;
use Think\Controller;
use think\Db;

class Wxadmin extends Base{

    public function __construct(){
        parent::__construct();
    }


    public function index(){

        $data[src]=config("DOMIN")."/wxadmin/admin/tlwx.php?m=".$_REQUEST[m_1]."&a=".$_REQUEST[a_1];
        $this->assign('data',$data);
        return $this->fetch("Wxadmin/index");
    }

}