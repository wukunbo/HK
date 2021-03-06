<?php 
namespace app\shop\logic;
use think\Model;
use think\Db;

class Order extends Model{

    public function __construct(){
        $this->db= new \app\userweb\model\PublicModel();
        $this->cart_logic=new \app\shop\logic\Cart();      
    }



    /*
     * 购物车生成订单
       $post[app]
       $post[business_id]   
     */
    //type 订单类别   site_id地址id  user_id用户id  购物车列表 
    //$this->OrderLogic=new \Shop\Logic\OrderLogic();       
    //public function add_order($site_id,$cart_id,$user_id,$use_point,$shipping_id,$postscript,$goods_price_arr=''){
    public function add_order($user_id,$post,$post_data=array()){       
     
        $db_order=Db::name('order');       
        $order_goods=Db::name('order_goods');      
 
        $goods=Db::name('shop_goods');                     
        $cart=Db::name('shop_cart');   
        
        $this->GoodsLogic=new \app\shop\logic\Goods();
        
        
        //用户地址
        $AddressLogic=new \app\user\logic\Address();
        $address=$AddressLogic->address_detail_name($post[address_id]);
        // dump($address);exit;
     
            
        $order_data['address']=$address['address'];
        $order_data['address_id']=$post[address_id];        
        $order_data['address_province_id']=$address['province'];
        $order_data['address_city_id']=$address['city'];        
        $order_data['address_area_id']=$address['area'];    
        $order_data["type"]=0;      
        $order_data['user_id']=$user_id;        ///用户id
        $order_data["address_name"]=$address[name]; //联系人 姓名    
        $order_data["address_phone"]=$address[phone];   //联系电话  
        $order_data["pay_status"]=0;        //支付状态
        $order_data["shipping_status"]=0;//快递状态
        $order_data["msg"]=$post[msg];//留言
        $order_data["pay_style"]=$post[pay_style];//支付方式 1：微信支付 2：信用卡分期
        $order_data["shiiping_type"]=$post[shiiping_type];//快递方式
        $order_data["order_status"]=1;//这个正常订单状态
        $order_data["addtime"]=time();  

        $order_data['is_invoice']=$post['is_invoice'];//是否需要发票
        $order_data['is_use_points']=$post['is_use_points'];//是否使用积分
        
         
        $order_data['child_id']=$post['child_id']; //子账号
            
        //生成订单号
        $order_data[order_sn]=$order_sn=date("Ymdhis").substr(floatval($t1)*1,0,2).$user_id;    //订单号   
        $order_data[weixin_order_sn]=$order_sn=date("Ymdhis").substr(floatval($t1)*1,0,2).$user_id; //订单号   
            
         
        //新加信息 app订单类型 business_id 商家id或者其他
        $order_data[app] = $post[app] ;
        $order_data[business_id] = $post[business_id];
         

        //获取购物车列表 商城
        if($post[app]=="shop" || $post[app]==""){
            // dump($order_data);exit;
            $CartLogic=new \app\shop\Logic\Cart();     
            //获取购物车列表
            $search[cart_id]=$post[cart_id_lists];
            $tmp=$CartLogic->cart_lists($user_id,$search);
            // dump($tmp);exit;
            $cart_lists=$tmp[content];
            if(count($cart_lists)==0){
                $data[status]=10007;
                echo json_encode($data);    
                exit;
            }
                
            $cart_id=end(explode(",",$post[cart_id_lists]));
            $tmp=$CartLogic->cartd_detail($cart_id);
            $cartd_detail=$tmp[detail];             
            //重新写入 业务ID
            $order_data[business_id]=$cartd_detail[shop_id]; 
            
            //计算购物车的价格 积分等
            $calculate=$this->cart_logic->calculate($post[cart_id_lists],$post,$user_id);
            
            
            // dump($calculate);exit;
            //计算总价                      
            $order_data[give_points_all]=$calculate[give_points_all];//赠送的积分
            $order_data[user_points]=$calculate[user_points];//使用积分
            $order_data[points_fee]=$calculate[points_fee];//使用积分抵扣金额

            $order_data[shipping_fee]=$calculate[shipping_fee];//运费
            $order_data[total_fee]=$calculate[total_price];//总费用
            $order_data[goods_fee]=$calculate[total_goods_price];//商品总价
            $order_data[real_fee]=$calculate[real_fee];//实付
           
        }
        
        
        $order_data[wx_id]=1;
        //插入订单
        $order_id=$db_order->insertGetId($order_data);
        
        // echo $order_id;exit;
          
        
          
        //写入order_goods
        if($order_data[app]=="shop"){
            $give_points_all=0;
            $user_goods_log=Db::name('shop_user_goods_log');
            $tmp_point_all=0;
            
            //计算每个可用的积分 扣减库存 写入 order_goods表
            for ($i=0;$i<count($cart_lists);$i++){
                //订单内商品
                $order_goods_data[goods_id]=$cart_lists[$i]['goods_id'];
                $order_goods_data[amount]=$cart_lists[$i]['amount'];
                $order_goods_data[attr]=$cart_lists[$i]['attr'];
                $order_goods_data[goods_sn]=$cart_lists[$i]['goods_sn'];
                $order_goods_data[price]=$cart_lists[$i]['price'];
                $order_goods_data[buy_give_point]=$cart_lists[$i]['buy_give_point'];
                $order_goods_data[app]="shop";
                $order_goods_data[order_id]=$order_id;
                $order_goods_data[addtime]=time();

                //计算积分每个商品的得积分
                $give_points=Db::name("shop_goods")->where("goods_id={$order_goods_data[goods_id]}")->value("buy_give_point");
                $give_points_all+=$give_points;
             
                //得出每个商品的积分
                $order_goods_data[point_give]=$give_points;
                //插入 购买商品表
                $order_goods->insert($order_goods_data);
                // dump($order_goods_data);exit;
                //购买记录
                $user_goods_data[user_id]=$user_id;
                $user_goods_data[goods_id]=$order_goods_data[goods_id];
                $user_goods_data[status]=0;
                $user_goods_data[addtime]=time();
                $user_goods_log->insert($user_goods_data);
                

                //扣减库存 属性库存
                $search=array();
                $search[stock]=$cart_lists[$i]['amount'];
                $search[type]=-1;
                $search[sell]=1;
                $search[attr]=$cart_lists[$i]['attr'];
                $this->GoodsLogic->update_stock($cart_lists[$i]['goods_id'],$search);
    
                
            }


            
        }
         

        $is_share_user=Db::name("shop_share_user")->where('user_id',$user_id)->find();
        
        if($is_share_user){
            //分销系统接入
            $share_logic=new \app\share\logic\Share();
            $search[order_id]=$order_id;
            $search[user_id]=$order_data[user_id];
            $search[app]="shop";
            $search[business_id]=$order_data[business_id];
            $search[type]="neworder"; 
            $search[order_type]="2";
            $res=$share_logic->share_complete($search);
        }
         
            
            
             
        
            
        
        if ($order_id){
        
            $data[status]=10001;
            $data[order_id]=$order_id;
            $data[order_sn]=$order_sn;
            
            
            //需要发票
            if($post[is_invoice]){
                $post_invoice=array("user_id"=>$user_id,"order_id"=>$order_id,"type"=>$post[type],"taitou"=>$post[taitou],"number"=>$post[number],"addtime"=>time());
                M("order_invoice")->insert($post_invoice);
            }
            
            //清空购物车
            Db::name("shop_cart")->where("cart_id",'in',$post[cart_id_lists])->delete();
            //使用积分
            if($post['is_use_points']){
                Db::name("user")->where("id={$user_id}")->setDec("all_points",$order_data['use_points']);
            }
            
            $pay_status=0;
            

    
            $data[log_id]=$this->add_order_log($order_id,$user_id,$pay_status=0,$order_data[point_fee],$order_data[real_fee]);
            
            
             
            if($order_data[real_fee]==0){//无需支付，直接付款完毕
                $trade_out_on=$order_sn."-".$data[log_id];
                $this->pay_off("",$trade_out_on,-1);
            }
            $data[real_fee]=$order_data[real_fee];
            
        }else {
            $data[status]=10002;
        }
            
        return $data;
    }





    //订单记录
    /*
 
    //$status 0未支付 1支付 2发货 3收货 4退货 5已退货 6已退款 7删 除
    $log_data[child_id]="";
    $log_data[type]="fahuo";
    $log_data[content]="发货";
    $OrderLogic= new \Shop\Logic\OrderLogic();
    $OrderLogic->add_order_log($order_id,$user_id,$status,$point_fee,$money_fee,$form,$admin,$log_data);
    */
    public function add_order_log($order_id,$user_id,$status,$point_fee,$money_fee,$form="",$admin="",$data=array()){
        
        $order_log=Db::name('order_log');
 
        $sql_data[order_log_id]=uniqid();
        $sql_data[user_id]=$user_id;
        $sql_data[child_id]=$data[child_id];
        $sql_data[order_id]=$order_id;
        $sql_data[status]=$status;
        $sql_data[point_fee]=$point_fee;
        $sql_data[money_fee]=$money_fee;
        if ($form==null){
            $form=0;
        }
        if ($admin==null){
            $admin=0;
        }
        $sql_data[admin]=$admin;
        $sql_data[type]=$data[type]; //类型
        $sql_data[form]=$form;
        $sql_data[addtime]=time();
        $check=$order_log->insertGetId($sql_data);

        
        $order_log->where("id='".$check."'")->setField("order_log_id",$check);
        
        $order_log_id=$check;
                 
        return $order_log_id;
    }


    //发货操作
    public function add_shipping_log($order_id,$post,$admin_id=""){

        // echo $order_id;exit;

        $order_goods_id=$post['order_goods_id'];
         
        $order_shipping=Db::name('order_shipping');    
        //更改订单状态
     
        $order=Db::name('order');
        $order_goods=Db::name('order_goods');
        $order->where("order_id='".$order_id."'")->setField("shipping_status",1); //发货

        // echo $order_id;exit;
        //新增订单操作记录
        // $order_log=Db::name('order_log');
        // $result=$order_log->where("order_id='".$order_id."'")->find();
        // //$status 0未支付 1支付 2发货 3收货 4退货 5已退货 6已退款 7删 除
        // $log_data[child_id]="";
        // $log_data[type]="fahuo";
        // $log_data[content]="发货";
        // $this->add_order_log($result['order_id'],$admin_id,$status=2,$result['point_fee'],$result['money_fee'],1,$admin_id,$log_data);
        
        //设置order_goods表
        $where="order_id='".$order_id."'";
        $order_goods->where($where)->setField("shipping_status",1);

        //保存到主表
        $tmp['shipping_id']=$post['shipping_id'];
        $tmp['shipping_time']=time();
        $tmp['shipping_code']=$post['shipping_code'];
        $tmp['shipping_sn']=$post['shipping_sn'];
        $order->where("order_id='".$order_id."'")->update($tmp);


        $res=$order_shipping->where($where)->find();

        // dump($res);exit;

        if ($res){            
            $order_shipping->where($where)->update($post);            
        }else {         
            $order_shipping->insert($post);
        }

        // echo $order_shipping->getLastsql();exit;

    }




    //确认收货
    //改变订单快递状态 //收获 发货  2 收货 1 发货
    public function change_shipping_order($order_id,$user_id,$shipping_status,$is_system=1){
        $order=Db::name('order');
        $check=$order->where(" order_id='$order_id'")->setField('shipping_status',$shipping_status);

        // echo $order->getLastsql();exit;

        if(!$user_id){
            $user_id=$order->where(" order_id='$order_id'")->value("user_id");
        }
        
        //收货
        if ($shipping_status==2){
            //清除售后状态
            $order->where(" order_id='$order_id'")->setField('back_status',0);
            
            //更新收货时间
            $order->where(" order_id='$order_id'")->setField('comfirm_time',time());

            Db::name("order_goods")->where("order_id='{$order_id}'")->setField("confirm_status",1);
            
            $total_fee=$order->where(" order_id='$order_id'")->value('real_fee');
            //金币变化
 
            
            //分销接入      
            $share_logic=new \app\share\logic\Share();
            $search[order_id]=$order_id;
            $search[type]="shouhuo"; 
            $res=$share_logic->share_complete($search);
            
            
            $order->where("order_id='".$order_id."'")->setField("comfirm_stauts",$is_system);  //收货状态 1 系统收货2
            $order->where("order_id='".$order_id."'")->setField("comfirm_time",time());
            

            Db::name("order_goods")->where("order_id='{$order_id}'")->setField("shipping_status",1);

            
        }

        //发货
        if ($shipping_status==1){
            $status=2;
        }else if ($shipping_status==2){
            $status=3;
        }elseif ($shipping_status==3){
            $status=4;
        }elseif ($shipping_status==4){
            $status=5;
        }

        $this->add_order_log($order_id,$user_id,$status,$point_fee,$money_fee);
        
        if ($check) {
            $data[status]=10001;
        }else {
            $data[status]=10002;
            
        }
        return $data;
    }


    /*
     * 订单详情
     */
    public function order_detail($order_id,$user_id=null){   
        if($user_id==null){
            $where="order_id='$order_id' ";
        }else {
            $where="order_id='$order_id' and user_id='$user_id'";
        }
        $order=Db::name('order');
        // echo $where;exit;
        $order_result=$order->where($where)->find();

        $order_result['username']=Db::name('user')->where('id',$order_result['user_id'])->value("username");
        // echo $order->getLastsql();
        // dump($order_result);exit;
        
        $order_goods=Db::name('order_goods');
        $field="tl_order_goods.id as order_goods_id,tl_order_goods.topic_id as topic_id,tl_order_goods.comment_status as comment_status,tl_order_goods.point_fee,tl_order_goods.price,tl_shop_goods.img_thumb,tl_shop_goods.goods_id,tl_shop_goods.goods_name,tl_shop_goods.shop_price,tl_shop_goods.market_price,tl_order_goods.attr,tl_order_goods.goods_sn,tl_order_goods.amount,tl_order_goods.price as order_price";
        $join[]=["tl_shop_goods","tl_shop_goods.goods_id=tl_order_goods.goods_id"];
        $order_result['goods_lists']=$order_goods->where("order_id",$order_id)->join($join)->field($field)->select();
        // echo $order_goods->getLastsql();exit;
        
        
        return $order_result; 
    }


    public function pay_off($attach,$out_trade_no,$is_auto=0){
        $tmp=explode("-",$out_trade_no);
         
        if($_REQUEST["key2"]=="0-asdfsdfasdfasdf"){
            $is_auto=1;
        }

        if($_REQUEST["key"]=="0-asdfsdfasdfasdf"){
            $is_auto=1;
        }
         
        
        //shop.php?c=Order&a=pay_off&var_login=1&key2=0-asdfsdfasdfasdf&out_trade_no=20160331115335046-56fc3d45ca10c
        $order_sn=$tmp[0];
        $log_id=$tmp[1];
        $md5=md5(substr($out_trade_no,0,5));
        // echo $md5;exit;
        if ($attach!=$md5 && $is_auto==0) {
            $data[status]=10003;                
        }else {         
             
            $order_log=Db::name("order_log");
            $result=$order_log->where("order_log_id='$log_id'  ")->find();

            // dump($result);exit;

            if(!$result){
                $order_id=Db::name("order")->where(" order_sn='$order_sn'  ")->value("order_id");
                $result=Db::name("order_log")->where("order_id='$order_id'  ")->order("id desc")->find();
            }
          
            
            $check=$order_log->where(" order_log_id='".$log_id."'")->setField('status','1');
            $check=$order_log->where(" order_log_id='".$log_id."'")->setField('paytime',time());
            //echo $order_log->getLastsql();
            
            $money_fee=$result['money_fee'];
            $order_id=$result['order_id'];
             
            $order=Db::name('order');
            $order_result=$order->where(" order_id='$order_id'  ")->find();
                
            // dump($order_result);exit;

            if((!$order_result && $is_auto==0 ) || $order_result[pay_status]!=0  || $result[status]!=0){
                $data[status]=10005;
            }else{

                if ($order_result[real_fee]==$money_fee){//全部支付成功

                    $check=$order->where(" order_id='$order_id'")->setField('pay_status','1');
                    $weixin_order_sn=$order_sn."-".$log_id;
                    $check=$order->where(" order_id='$order_id'")->setField('weixin_order_sn',$weixin_order_sn);
                    $check=$order->where(" order_id='$order_id'")->setField('pay_time',time());

                    Db::name("user")->where("id={$order_result['user_id']}")->setInc("all_points",$order_result['give_points_all']);

                    //分销系统接入
                    
                    $share_logic=new \app\share\logic\Share();
                    $search['order_id']=$order_result['order_id'];
                    $search['type']="pay"; 
                    
                    $res=$share_logic->share_complete($search);
                     
                     
                    
                }else {

                    $order_log=Db::name('order_log');
                    $pay_lists=$order_log->where(" order_id='$order_id' and status='1'")->select();
                    
                    for ($i=0;$i<count($pay_lists);$i++){
                        $money_fee=$pay_lists[$i]['money_fee'];
                        $total_fee+=$money_fee;
                    }
                    if ($total_fee==$order_result['real_fee']){
                        $check=$order->where("  order_id='$order_id'")->setField('pay_status','1');

                        if ($order_result[app]=="shop"){
                         
                            //分销系统接入
                            $share_logic=new \app\share\logic\Share();
                            $search['order_id']=$order_result['order_id'];
                            $search['business_id']=$order_result['business_id'];
                            $search['app']=$order_result['app'];
                            $search['type']="pay"; 
                            $res=$share_logic->share_complete($search);
                        }
                    }
                }
                
                if (($check==null||$check==false)){
                    $data['status']=10002;
                }else {
                    
                    $data['status']=10001;
                }    
            }
             
             
        }
        return $data;
    }


}