<?php

namespace app\shop\controller;
use think\Controller;
use think\Db;

class Order extends Base{

    public function __construct(){
        parent::__construct();
    }


    //加入订单
    public function add_order(){

        $this->assign('page_title',"确认订单");

        $cart_ids=$_REQUEST['cart_ids'];
        $cart_arr=explode(",",$cart_ids);
        $cart_arr=array_filter($cart_arr); 

        $cart_ids=implode(",",$cart_arr);

        if(!$cart_ids){
            return $this->showmsg("请选择商品");
            exit;
        }

        $this->assign('cart_ids',$cart_ids);

        $map['cart_id']=['in',$cart_ids];

        $join[]=['tl_shop_goods','tl_shop_goods.goods_id=tl_shop_cart.goods_id'];
        $field="tl_shop_cart.cart_id,tl_shop_cart.goods_id,tl_shop_cart.amount,tl_shop_goods.goods_name,tl_shop_goods.market_price,tl_shop_goods.img_orogin";
        $data=Db::name("shop_cart")->where($map)->join($join)->field($field)->select();

        if(!$data){
            return $this->showmsg("请选择商品",url("Index/index"));
            exit;
        }

        $res['cart_lists']=$data;
        $res['total_price']=Db::name('shop_cart')->where($map)->sum('amount*price');

        $res['rmb_price']=ceil($res['total_price']*0.8);
        $res['purchase_fee']=ceil($res['total_price']*0.15);

        $res['real_fee']=ceil($res['rmb_price']+$res['purchase_fee']);

        $address_id=input('address_id');

        if(!$address_id){
            $address_id=Db::name('address')->where("user_id={$this->user_id} AND type=1")->value("id");
        }

        $address=Db::name('address')->where('id',$address_id)->find();

        $this->assign('address',$address);

        $this->assign('data',$res);
        return $this->fetch("Order/add_order");

    }


    public function order_action(){

        $db_order=Db::name('order');

        $cart_ids=input('cart_ids');
        $address_id=input('address_id');

        $map['cart_id']=['in',$cart_ids];

        $join[]=['tl_shop_goods','tl_shop_goods.goods_id=tl_shop_cart.goods_id'];
        $field="tl_shop_cart.cart_id,tl_shop_cart.goods_id,tl_shop_cart.amount,tl_shop_goods.goods_name,tl_shop_goods.market_price,tl_shop_goods.img_orogin";
        $data=Db::name("shop_cart")->where($map)->join($join)->field($field)->select();

        $res['cart_lists']=$data;
        $res['total_price']=Db::name('shop_cart')->where($map)->sum('amount*price');

        $res['rmb_price']=ceil($res['total_price']*0.8);
        $res['purchase_fee']=ceil($res['total_price']*0.15);

        $res['real_fee']=ceil($res['rmb_price']+$res['purchase_fee']);


        $address=Db::name('address')->where('id',$address_id)->find();

        //订单数据
        $order_data['address']=$address['address'];
        $order_data['address_id']=$address['id'];        
        $order_data['address_province_id']=$address['province'];
        $order_data['address_city_id']=$address['city'];        
        $order_data['address_area_id']=$address['area'];    
        $order_data["type"]=0;      
        $order_data['user_id']=$this->user_id;        ///用户id
        $order_data["address_name"]=$address['name']; //联系人 姓名    
        $order_data["address_phone"]=$address['phone'];   //联系电话  
        $order_data["pay_status"]=0;        //支付状态
        $order_data["shipping_status"]=0;//快递状态
        $order_data["msg"]=$post['msg'];//留言
        $order_data["order_status"]=1;//这个正常订单状态
        $order_data["addtime"]=time();  

        $order_data['order_sn']=$order_sn=date("Ymdhis").substr(floatval($t1)*1,0,2).$this->user_id;    //订单号   
        $order_data['weixin_order_sn']=$order_sn=date("Ymdhis").substr(floatval($t1)*1,0,2).$this->user_id; //订单号 

        $order_data['app'] = "shop";
        $order_data['business_id'] = 1;

        $order_data['total_fee']=$res['total_price'];  //港币总价
        $order_data['real_fee']=$res['real_fee'];   //人民币加代购费总价
        $order_data['rmb_fee']=$res['rmb_price'];
        $order_data['purchase_fee']=$res['purchase_fee'];

        $order_data['parent_user'] = Db::name('user')->where('id',$this->user_id)->value("parent_id");

        $order_data['wx_id']=1;

        //插入订单
        $order_id=$db_order->insertGetId($order_data);

        if ($order_id){
        
            $return_data['status']=10001;
            $return_data['order_id']=$order_id;
            $return_data['order_sn']=$order_sn;

            foreach ($res['cart_lists'] as $key => $value) {

                $order_goods_data['goods_id']=$value['goods_id'];
                $order_goods_data['amount']=$value['amount'];
                $order_goods_data['price']=$value['market_price'];
                $order_goods_data['app']="shop";
                $order_goods_data['order_id']=$order_id;
                $order_goods_data['addtime']=time();

                $is=Db::name('order_goods')->where("order_id={$order_id} AND goods_id={$value['goods_id']}")->find();
                if($is){
                    $order_goods_data['amount']=$value['amount']+$is['amount'];
                    Db::name('order_goods')->where('id',$is['id'])->setField('amount', $order_goods_data['amount']);
                }else{
                    Db::name('order_goods')->insert($order_goods_data);
                }

                //增加销量
                Db::name('shop_goods')->where('goods_id',$order_goods_data['goods_id'])->setInc('sell_number',$value['amount']);
            }

            Db::name("shop_cart")->where($map)->delete();

            return $this->showmsg("下单成功,请等我联系你哦，谢谢！",url("Order/order_lists",array("pay_status"=>0)));
            exit;
        }else{
            return $this->showmsg("下单失败");
        }


    }


    //订单列表
    public function order_lists(){
        $this->assign('page_title',"订单列表");

        $map['user_id']=$this->user_id;

        if(isset($_REQUEST['pay_status'])){
            $map['pay_status']=$_REQUEST['pay_status'];
        }

        if(isset($_REQUEST['shipping_status'])){
            $map['shipping_status']=$_REQUEST['shipping_status'];
        }

        $order=Db::name('order');

        $field="order_id,order_sn,address_name,address_phone,address,total_fee,rmb_fee,purchase_fee,real_fee,pay_status,shipping_status,shipping_id,shipping_code,addtime";
        $data=$order->where($map)->field($field)->order("addtime DESC")->select();

        $field=" tl_shop_goods.goods_id,tl_shop_goods.goods_name,tl_shop_goods.market_price,tl_shop_goods.img_orogin,tl_order_goods.amount ";
        $join[]=['tl_shop_goods','tl_shop_goods.goods_id=tl_order_goods.goods_id'];
        $order_goods=Db::name('order_goods');

        foreach ($data as $key => &$value) {
            $value['goods_lists']=$order_goods->where('order_id',$value['order_id'])->join($join)->field($field)->select();
        }

        $this->assign('data',$data);
        return $this->fetch("Order/order_lists");
    }


}