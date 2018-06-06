<?php
namespace app\shop\controller;
use think\Controller;
use think\Db;

class Goods extends Base{

    public function __construct(){
        parent::__construct();
    }

    //个人中心首页
    public function detail(){
        $this->assign('page_title',"商品详情");

        $goods_id=input('id');

        $data=Db::name('shop_goods')->where('goods_id',$goods_id)->find();
        

        $this->assign('data',$data);

        return $this->fetch("Goods/detail");
    }


}