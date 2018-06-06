<?php
namespace app\userweb\controller;
use Think\Controller;
use think\Db;

class ShopOrder extends Base{

    public function __construct(){
        parent::__construct();
        $this->OrderDataLogic= new \app\shop\logic\OrderData();
        
        $this->order_logic= new \app\shop\logic\Order();

        $this->OrderStatusLogic= new \app\shop\logic\OrderStatus();
    }

    //订单列表
    public function order_lists(){

        $search[keyword]=$_REQUEST[keyword];
        $search[status]=$_REQUEST[status];
        $search[back_order]=$_REQUEST[back_order];
         

        $search[back_status]=$_REQUEST[back_status];
        $search[back_end]=$_REQUEST[back_end];
 
        $search[date_1]=$_REQUEST[date_1];
        $search[date_2]=$_REQUEST[date_2];
         
         
        $app_array['app'] = $_REQUEST['app'] ;
        if(!$app_array['app']){
            $app_array['app'] = "shop" ;
        }
        if($this->shop_id!=1){
            $app_array['business_id'] = $this->shop_id;
        }
        if($this->shop_id==1){
            $business_id=$_REQUEST[business_id];
            $app_array['business_id'] = $business_id;
        }

        $data=$this->OrderDataLogic->order_lists($user_id='',$search,$app_array);

        // dump($data);exit;
        // 获取订单详情

        for ($i=0;$i<count($data[content]);$i++){
            $order_id=$data[content][$i][order_id];
            $user_id=$data[content][$i][user_id];
            $order_detail=$this->order_logic->order_detail($order_id);
            //$userinfo=$user->user($user_id);   
            //$data[content][$i][name]=$userinfo[userinfo][nickname];
            $data[content][$i][order_detail]=$order_detail;
            $data[content][$i][shipping_title]=Db::name("shop_kuaidi")->where("code='{$data[content][$i][shipping_code]}' AND shop_id={$this->shop_id} ")->value("title");
            

            if($_REQUEST[status]==4 || $data[content][$i][shipping_status]==1){
                // echo 111;exit;
                // dump($data[content][$i]);exit;
                $totime=time()-60*60*24*7;

                
                
                //发货7天后 自动收货        
                 //已付款 已发货 状态整车  无退货

                if($data[content][$i][shipping_status]==1 && $data[content][$i][order_status]==1 && $data[content][$i][back_status]==0 && $data[content][$i][shipping_time]<$totime){
                    // dump($data[content][$i]);exit;
                    //更改收货状态
                    $shipping_status=2;
                    $Order_logic=new \app\shop\logic\Order();
                    $Order_logic->change_shipping_order($order_id,$data[content][$i][user_id],$shipping_status);
                }
                
            }

        }

        $this->assign('data',$data);
        $this->assign('status',$_REQUEST[status]);
      
        return $this->fetch("ShopOrder/order_lists");


    }


    //订单详情
    public function order_detail(){

        $order_id=$_REQUEST['order_id'];

        $data=$this->order_logic->order_detail($order_id);

        //订单状态
        $status_text=$this->OrderDataLogic->get_order_status_text($order_id);
        $data['pay_status_text']=$status_text['pay_status_text'];
        $data['shipping_status_text']=$status_text['shipping_status_text'];
        $data['back_status_text']=$status_text['back_status_text'];
        $data['comfirm_status_text']=$status_text['comfirm_status_text'];
        $data['order_status_text']=$status_text['order_status_text'];

        $this->attr_logic= new \app\shop\logic\Attr();
        $db_order_shipping=Db::name("order_shipping");

        for ($i=0;$i<count($data['goods_lists']);$i++){
            $tmp_attr=$data['goods_lists'][$i]['attr'];
            $tmp_attr_lists=explode(',', $tmp_attr);

            for ($j=0;$j<count($tmp_attr_lists);$j++){
                $tmp_op_id=$tmp_attr_lists[$j];
                $data['goods_lists'][$i]['op_lists'][]=$this->attr_logic->get_op_detail($tmp_op_id);
            }
            //物流信息
            $where=" order_id='".$order_id."' AND order_goods_id='".$data['goods_lists'][$i]['order_goods_id']."'";

            $tmp=$db_order_shipping->where($where)->find();
            $data['goods_lists'][$i]['shipping_id']=$tmp['shipping_id'];
            $data['goods_lists'][$i]['shipping_code']=$tmp['shipping_code'];
            $data['goods_lists'][$i]['shipping_addtime']=$tmp['addtime'];
            
        }
       
        $data['shipping_title']=Db::name("shop_kuaidi")->where("code='{$data[shipping_code]}'")->value("title");
                
        $this->assign('order_detail',$data);
        return $this->fetch("ShopOrder/order_detail");
    }


    //订单打印
    public function order_print(){
        $order_id=$_REQUEST['order_id'];

        $data=$this->order_logic->order_detail($order_id);

        //订单状态
        $status_text=$this->OrderDataLogic->get_order_status_text($order_id);
        $data['pay_status_text']=$status_text['pay_status_text'];
        $data['shipping_status_text']=$status_text['shipping_status_text'];
        $data['back_status_text']=$status_text['back_status_text'];
        $data['comfirm_status_text']=$status_text['comfirm_status_text'];
        $data['order_status_text']=$status_text['order_status_text'];

        $this->attr_logic= new \app\shop\logic\Attr();
        $db_order_shipping=Db::name("order_shipping");

        for ($i=0;$i<count($data['goods_lists']);$i++){
            $tmp_attr=$data['goods_lists'][$i]['attr'];
            $tmp_attr_lists=explode(',', $tmp_attr);

            for ($j=0;$j<count($tmp_attr_lists);$j++){
                $tmp_op_id=$tmp_attr_lists[$j];
                $data['goods_lists'][$i]['op_lists'][]=$this->attr_logic->get_op_detail($tmp_op_id);
            }
            //物流信息
            $where=" order_id='".$order_id."' AND order_goods_id='".$data['goods_lists'][$i]['order_goods_id']."'";

            $tmp=$db_order_shipping->where($where)->find();
            $data['goods_lists'][$i]['shipping_id']=$tmp['shipping_id'];
            $data['goods_lists'][$i]['shipping_code']=$tmp['shipping_code'];
            $data['goods_lists'][$i]['shipping_addtime']=$tmp['addtime'];
            
        }
       
        $data['shipping_title']=Db::name("shop_kuaidi")->where("code='{$data[shipping_code]}'")->value("title");
                
        $this->assign('order_detail',$data);
        return $this->fetch("ShopOrder/order_print");
    }


    //订单修改
    public function order_form(){
        $order_id=$_REQUEST['order_id'];
        $data=$this->order_logic->order_detail($order_id);
        //dump($data);
        $this->assign('data',$data);
        return $this->fetch("ShopOrder/order_form");
    }


    //订单修改
    public function order_add(){

        $order_id=$_REQUEST['order_id'];

        $post=$_REQUEST['post'];
        $order=Db::name('order');
        // 支付状态
        if($post['pay_status']){
            // $check1=$order->where("order_id='$order_id'")->setField('pay_status',$post['pay_status']);
        }
        // 发货状态
        if($post['shipping_status']){
            // $check2=$order->where("order_id='$order_id'")->setField(''shipping_status'',$post['shipping_status']);
        }
        $check3=$order->where("order_id='$order_id'")->update($post);

        return $this->showmsg('修改成功');

    }


    public function kuaidi_form(){

        $order_id=$_REQUEST['order_id'];
        $order_goods_id=$_REQUEST['order_goods_id'];
        $order_detail=$this->order_logic->order_detail($order_id);


        if($order_detail['pay_status']==0){
            return $this->showmsg("该订单未付款，请等待付款再发货");
        }
    
        if($order_goods_id==null){
            $where="order_id='$order_id'";
        }else {
            $where="order_id='$order_id' and order_goods_id ='$order_goods_id'";
        }
        
        $kuaidi=Db::name('shop_kuaidi');
        $kuaidi_lists=$kuaidi->where("shop_id='".$this->shop_id."'")->select();  
        $order_shipping=Db::name('order_shipping');
        $result=$order_shipping->where($where)->find();

        // echo $order_shipping->getLastSql();exit;


        $this->assign('order_goods_id',$order_goods_id);
        $this->assign('order_id',$order_id);
        $this->assign('order_detail',$order_detail);
        $this->assign('result',$result);
        $this->assign('kuaidi_lists',$kuaidi_lists);

        return $this->fetch("ShopOrder/kuaidi_form");
    }


    //发货
    public function add_order_shipping(){       
                
        $post=$_REQUEST[post];      
         
        $post[addtime]=time();  
        
        // dump($post);exit;
        $this->order_logic->add_shipping_log($post[order_id],$post,$this->user_id);
        
        
        return $this->showmsg('发货成功');
    }



    //退货地址列表
    public function address_lists(){
        $data[lists]=Db::name("order_back_address")->where("shop_id = '".$this->shop_id."'")->select();

        $this->assign('data',$data);      
        return $this->fetch("ShopOrder/address_lists");
    }

    //显示添加退货地址
    public function address_add(){
        $post=$_REQUEST[post];

        $post_id=$_REQUEST[post_id];
        $id=$_REQUEST[id];
        if($post){
            if(!$post[address]){
                return $this->showmsg('地址不能为空');
                exit;
            }
            $post['shop_id'] = $this->shop_id;

            if($post_id){
                Db::name("order_back_address")->where("id='".$post_id."'")->update($post);
            }else{
                Db::name("order_back_address")->insert($post);
            }
            return $this->showmsg('成功',url('address_lists'));
            exit;
        }
        if($id){
            $detail=Db::name("order_back_address")->where("id='".$id."'")->find();
        }
        $this->assign('detail',$detail);      
        return $this->fetch("ShopOrder/address_add");
    
    }



}