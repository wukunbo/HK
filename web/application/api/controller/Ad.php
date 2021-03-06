<?php
namespace app\api\controller;
use think\Controller;
use think\Db;

class Ad extends Base{

    public function __construct(){
        parent::__construct();
        $this->logic=new \app\basic\logic\Ad();
    }

    //广告列表
    public function lists(){
        $cate_id=$_REQUEST['cate_id']; #广告位置ID
        $search['cate_id']=$cate_id;

        $data=$this->logic->lists($search);

        $res['status']=10001;
        $res['lists']=$data;
        $this->return_data($res);
    }

}