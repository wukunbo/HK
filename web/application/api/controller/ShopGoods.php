<?php
namespace app\api\controller;
use think\Controller;
use think\Db;

class ShopGoods extends Base{

    public function __construct(){
        parent::__construct();
        $this->logic= new \app\shop\logic\Goods();
        $this->attr_logic= new \app\shop\logic\Attr();
    }


    /**
     * 商品列表
     */
    public function lists(){

        $shop_id=$_REQUEST['shop_id'] ? $_REQUEST['shop_id'] : 1;
        $cate_id=$_REQUEST['cate_id'];
        $num=$_REQUEST['num'];
        if($num==null){
            $num=100;
        }
        $type=$_REQUEST['type'];
        $_GET['p']=$_REQUEST['p'];
        $order=$_REQUEST['order'];

        if(!$order){
            $order=" tl_shop_goods.is_top DESC,tl_shop_goods.addtime DESC ";
        }

        $keyword=$_REQUEST['keyword'];

        $map['cate_id_str']=$_REQUEST['cate_id_str'];
        $map['attr']=$_REQUEST['attr'];
        $map['activity']['id']=$_REQUEST['activity_id'];
        $map['tag']=$_REQUEST['tag'];

        $map['home_cate']=$_REQUEST['home_cate'];

        
        $field="tl_shop_goods.goods_id,tl_shop_goods.goods_sn,tl_shop_goods.goods_name,tl_shop_goods.sub_title,tl_shop_goods.goods_number,tl_shop_goods.goods_weight,tl_shop_goods.sell_number,tl_shop_goods.market_price,tl_shop_goods.pifa_price,tl_shop_goods.shop_price,tl_shop_goods.give_points,tl_shop_goods.img_thumb";

        $map['login_user']=$this->user_id;

        $status=1;#上架状态 

        $ret=$this->logic->goods_lists($shop_id,$cate_id,$num,$type,$order,$field,$keyword,$status,$map);
        // dump($ret);exit;
        $ret=$ret['lists'];
        if($ret['content']===null){
            $data['status']=10003;
            $data['msg']="无数据";
        }elseif($ret['content']===false){
            $data['status']=10002;
            $data['msg']="数据查询错误";
        }else{
            $data['status']=10001;
            $data['msg']="成功";
        }
        $data['lists']=$ret['content'];
        $this->return_data($data);
    }



    /**
     * 商品详情
     */
    public function detail(){
        $id=$_REQUEST['id'];
        $ret=$this->logic->goods_detail($id);

        if($ret['detail']===null){
            $data['status']=10003;
            $data['msg']="无数据";
        }elseif($ret['detail']===false){
            $data['status']=10002;
            $data['msg']="数据查询错误";
        }else{
            $data['status']=10001;
            $data['msg']="成功";
        }
        if($data['status']==10001){
            // 获取商品属性
            $ret['detail']['attr_lists']=$this->attr_logic->get_goods_attr_lists($id);
            $ret['detail']['gallery_lists']=$this->logic->get_goods_gallery($id);
            // 获取商品是否收藏
           
            $ret['detail']['wish']=Db::name('shop_wish')->where("goods_id={$id} AND user_id={$this->user_id}")->value("status");


            $history_data=array("user_id"=>$this->user_id,"goods_id"=>$id,"addtime"=>time());
            Db::name("shop_goods_history")->insert($history_data);//用户浏览商品历史
            Db::name("shop_goods")->where("goods_id={$id}")->setInc("click_count",1);

        }
        $data['detail']=$ret['detail'];
        $this->return_data($data);
    }



}