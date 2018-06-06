<?php
namespace app\api\controller;
use think\Controller;
use think\Db;

class ShopCart extends Base{

    public function __construct(){
        parent::__construct();
        $this->logic= new \app\shop\logic\Cart();
    }

    //添加购物车
    /**
     * 加入购物车
     */
    public function add(){
        if(!$this->user_id){
            $data[status]=10002;
            $data[msg]="请登录";
            $this->return_data($data);
            exit;
        }
        $goods_id=$_REQUEST['goods_id'];
        $attr=$_REQUEST['attr'];
        $amount=$_REQUEST['num'] ? $_REQUEST[num] : 1;
        $cart_id=$_REQUEST['cart_id'];
        if(is_array($attr)){
            $attr=implode("_",$attr);
        }
        $data=$this->logic->add_cart($this->user_id,$goods_id,$amount,$attr,$cart_id);
        $this->return_data($data);
    }


    //购物车列表
    public function lists(){

        $search['cart_id']=$_REQUEST['cart_id_str'];

        $ret=$this->logic->cart_lists($this->user_id,$search);
        // dump($ret);exit;

        foreach ($ret['content'] as $key => &$value) {
            if($value['attr']){
                $goods_id=$value['goods_id'];
                $title=Db::name('shop_goods_attr')->where("goods_id={$goods_id}")->value('title');
                $title=explode("_",$title);
                $attr=explode("_",$value['attr']);

                for($j=0;$j<count($title);$j++){
                    $attr_lists[$j]['title']=$title[$j];
                    $attr_lists[$j]['text']=$attr[$j];
                }
                $value['attr_lists']=$attr_lists;
            }else{
                $value['attr_lists']=null;
            }
            
        }

        // dump($ret);
        $data['status']=10001;
        $data['lists']=$ret['content'];
        $data['total']=$ret['total'];
        $data['total_goods_price']=$ret['total_goods_price'];
        $this->return_data($data);
    }
    

    /**
     * 价格核算
     */
    public function deal_price(){
        $cart_id_str=$_REQUEST['cart_id_str'];
        if($_REQUEST['is_use_points']){
            $search['is_use_points']=$_REQUEST['is_use_points'];
        }
       
        $ret=$this->logic->calculate($cart_id_str,"",$this->user_id);

        // dump($ret);exit;

        if($ret['lists']===null){
            $data['status']=10003;
            $data['msg']="无数据";
        }elseif($ret['lists']===false){
            $data['status']=10002;
            $data['msg']="数据查询错误";
        }else{
            $data['status']=10001;
            $data['msg']="成功";
        }
        if($data['status']==10001){
            $data['detail']['total_goods_price']=$ret['total_goods_price'];
            $data['detail']['shipping_fee']=$ret['shipping_fee'];
            
            $data['detail']['give_points_all']=$ret['give_points_all']; //获取积分
            $data['detail']['user_points']=$ret['user_points'];
            $data['detail']['exchange_price']=$ret['exchange_price'];

            $data['detail']['total_price']=$ret['total_price'];
            $data['detail']['real_fee']=$ret['real_fee'];
            $data['detail']['all_point']=$ret['all_point'];
            $data['detail']['buy_give_point']=$ret['buy_give_point'];
        }
        $this->return_data($data);
    }





    /**
     * 删除购物车中的商品
     */
    public function delete(){
        $cart_id_str=$_REQUEST['cart_id_str'];
        if(is_array($cart_id_str)){
            $cart_id_str=implode(",",$cart_id_str);
        }
        $ret=$this->logic->delete_cart($cart_id_str);
        if($ret===0){
            $data['status']=10003;
            $data['msg']="无数据";
        }elseif($ret===false){
            $data['status']=10002;
            $data['msg']="数据删除错误";
        }else{
            $data['status']=10001;
            $data['msg']="成功";
        }
        $this->return_data($data);
    }

}