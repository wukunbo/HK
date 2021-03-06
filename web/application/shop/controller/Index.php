<?php

namespace app\shop\controller;
use think\Controller;
use think\Db;

class Index extends Base{

    public function __construct(){
        parent::__construct();
    }



    //首页
    public function index(){
        $this->assign('page_title','首页');

        $data['ad_lists']=Db::name('ad')->where('cate_id',1)->order("sort_order ASC")->select();


        $data['cms_lists']=Db::name('cms_content')->where('cate_id',41)->order("id DESC")->limit(4)->select();


        $this->assign('data',$data);
        return $this->fetch("Index/index");
    }


    //购物车
    public function cart(){
        $this->assign('page_title','购物车');
        $map=array();
        $map['tl_shop_cart.user_id']=$this->user_id;

        $join[]=['tl_shop_goods','tl_shop_goods.goods_id=tl_shop_cart.goods_id'];
        $field="tl_shop_cart.cart_id,tl_shop_cart.goods_id,tl_shop_cart.amount,tl_shop_goods.goods_name,tl_shop_goods.market_price,tl_shop_goods.img_orogin";
        $data=Db::name("shop_cart")->where($map)->join($join)->field($field)->select();
        // dump($data);exit;
        $this->assign('data',$data);
        return $this->fetch("Index/cart");
    }


    public function ajax_add_cart(){

        $cart_id=$_REQUEST['cart_id'];
        $type=$_REQUEST['type'];
        $amount=Db::name("shop_cart")->where('cart_id',$cart_id)->value("amount");

        if($type=="add"){
            Db::name("shop_cart")->where('cart_id',$cart_id)->setInc("amount",1);
            $amount=$amount+1;
        }

        if($type=="del" && $amount>1){
            Db::name("shop_cart")->where('cart_id',$cart_id)->setDec("amount",1);
            $amount=$amount-1;
        }

        $res['status']=10001;
        $res['amount']=$amount;

        echo json_encode($res);

    }


    public function deal_price(){
        $cart_ids=$_REQUEST['cart_ids'];
        if(!$cart_ids){
            $total_price=0;
        }else{
            $map['cart_id']=['in',$cart_ids];
            $total_price=Db::name('shop_cart')->where($map)->sum('amount*price');
        }

        $res['status']=10001;
        $res['total_price']=$total_price;

        echo json_encode($res);

    }


    //商品列表
    public function goods_lists(){

        $this->assign('page_title','商品列表');

        $map=array();

        if($_REQUEST['cate_id']){
            $map["cate_id"]=$_REQUEST['cate_id'];
        }

        if($_REQUEST['search_keyword']){
            $map["goods_name"]=["like","%{$_REQUEST['search_keyword']}%"];
        }

        if($_REQUEST['page']){
            $page=$_REQUEST['page'];
        }else{
            $page=1;
        }

        if($_REQUEST['order']){
            $order=$_REQUEST['order']." DESC";
        }else{
            $order="shop_sort DESC";
        }


        $data=Db::name("shop_goods")->where($map)->field("goods_id,goods_name,market_price,shop_price,img_thumb,img_orogin")->order($order)->page($page,20)->select();
        // dump($data);exit;
        $this->assign('data',$data);

        $param=$_SERVER["QUERY_STRING"];
        $this->assign('param',$param);

        if($_REQUEST[ajax]){
            $res[status]=10001;
            $res[html]=$this->fetch('Index/goods_tpl');

            if(!$data){
                $res[status]=20001;
            }

            echo json_encode($res);
            exit;
        }

        
        return $this->fetch("Index/goods_lists");
    }


    //分类页面
    public function cate_lists(){

        $data=Db::name("shop_category")->where("parent_id",0)->field("cate_id,cat_name")->order("sort_order DESC")->select();

        $data[cate_lists]=Db::name("shop_category")->where("parent_id",$data[0]['cate_id'])->field("cate_id,cat_name,img_thumb")->select();

        $this->assign('data',$data);

        $this->assign('page_title','分类');
        return $this->fetch("Index/cate_lists");
    }

    public function ajax_cate(){
        $parent_id=$_REQUEST['parent_id'];
        $data=Db::name("shop_category")->where("parent_id",$parent_id)->field("cate_id,cat_name,img_thumb")->select();

        $this->assign('data',$data);

        $res['status']=10001;
        $res['html']=$this->fetch('Index/cate_tpl');

        echo json_encode($res);

    }

    //删除购物车
    public function del_cart(){
        $cart_id=input('cart_id');
        Db::name("shop_cart")->where('cart_id',$cart_id)->delete();

        return $this->showmsg("操作成功");
    }


}
